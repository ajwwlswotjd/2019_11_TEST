<!DOCTYPE html>
<html lang="ko">
<head>
	<?php require './head.php'; ?>
	<link rel="stylesheet" href="./css/questionStyle.css">
</head>
<body>
	<div id="agree_popup">
		<div class="popup_inner">
			<div class="popup-box">
				<h4>답변보기의 타이틀</h4>
				<div class="popup_content">
					답변보기의 컨텐츠
				</div>
				<button>확인</button>
			</div>
		</div>
	</div>
	<div id="wrap">
		<div id="container">
			<div id="header">
				<?php require './header.php'; ?>
				<?php
				if(!isset($_SESSION['user'])){
					msgAndGo("1:1문의를 위해서는 로그인이 필요합니다.","/login.php");
					exit;
				}
				$sql = "SELECT * FROM `question` WHERE `writer` = ?";
				$uid = $_SESSION['user']->number;
				$itemList = fetchAll($con,$sql,[$uid]);
				$itemCnt = count($itemList);
				$pageCnt = ceil($itemCnt/10);
				if($pageCnt <= 0)  $pageCnt = 1;
				$chapCnt = ceil($pageCnt/3);
				$pageNum = isset($_GET['page']) ? $_GET['page'] : 1;
				if($pageNum <= 0 || $pageNum > $pageCnt){
					msgAndBack("잘못된 접근 입니다.");
					exit;
				}
				$chapNum = ceil($pageNum/3);
				$itemIdx = ($pageNum-1)*10;
				$sql = "SELECT * FROM `question` ORDER BY `day` DESC, `id` DESC LIMIT ${itemIdx}, 10";
				$itemList = fetchAll($con,$sql,[$uid]);
				?>
			</div>

			<div id="main">
				<div id="content">
					<div class="page_aticle aticle_type2">
						<div id="snb" class="snb_cc">
							<h2 class="tit_snb">고객센터</h2>
							<div class="inner_snb">
								<ul class="list_menu">
									<li>
										<a href="/notice.php">공지사항</a>
									</li>
									<li class="on">
										<a href="/question.php">1:1문의</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="page_section section_qna">
							<div class="head_aticle">
								<h2 class="tit">
									1:1 문의
									<span class="tit_sub">
										덜퍼니잇에 불편한 점이 있으시면, 언제든지 문의해주세요. (제목을 클릭하면 내용이, 답변완료를 클릭하면 답변이 나옵니다)
									</span>
								</h2>
							</div>

							<table class="xans-board-listheader" width="100%">
								<tbody><tr class="input_txt">
									<th width="8%">번호</th>
									<th width="15%">답변상태</th>
									<th>제목</th>
									<th width="12%">작성자</th>
									<th width="12%">작성일</th>
								</tr>
							</tbody></table>
							<?php foreach($itemList as $item) : ?>
								<div class="mypage_wrap" style="float: none; width: 100%;" onclick="view_content(this);">
									<table class="table_faq" width="100%;">
										<tbody>
											<tr>
												<td width="8%" align="center"><?= $item->id ?></td>
												<?php
												$sql = "SELECT * FROM `answer` WHERE `question_id` = ?";
												$cnt = fetch($con,$sql,[$item->id]);
												?>
												<td width="15%" align="center" class="<?= $cnt ? 'status_true' : 'status_false' ?>"><?= $cnt ? '답변완료' : '답변대기' ?></td>
												<td style="padding-top:5px; padding-bottom:5px;"><?= $item->title ?></td>
												<td width="12%" align="center"><?= $_SESSION['user']->id ?></td>
												<td width="12%" align="center"><?= $item->day ?></td>
											</tr>
										</tbody>
									</table>
									<div class="question_preview">
										<div class="preview_content" width="100%" style="padding-left: 55px;">
											<?= $item->content ?>
										</div>
										<div class="goods-review-grp-btn">
											<?php if(!$cnt) : ?>
												<a href="/question_form.php?id=<?= $item->id ?>" class="styled-button">수정</a>
											<?php endif; ?>
											<a href="/fx/question_del.php?id=<?= $item->id ?>" class="styled-button">삭제</a>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
							<div style="position: relative;">
								<div style="position: absolute; right: 0; top: 60px;">
									<a href="/question_form.php">
										<span class="bhs_buttonsm yb" style="float: none;">글쓰기</span>
									</a>
								</div>
							</div>

							<div class="layout-pagination">
								<div class="pagediv">
									<?php
									$start = $chapNum*3-2;
									$end = $start+2;
									if($end > $pageCnt) $end = $pageCnt;
									?>
									<a href="/question.php?page=1" class="prev2"></a>
									<?php
									$prevChap = $chapNum-1;
									if($prevChap <= 0) $prevChap = 1;
									$prevPage = $prevChap*3-2;
									?>
									<a href="/question.php?page=<?= $prevPage ?>" class="prev1"></a>
									<?php for($i=$start;$i<= $end;$i++) : ?>
										<a href="/question.php?page=<?=$i?>" class="<?= $pageNum==$i ? 'nowPage' : '' ?>">
											<strong><?= $i ?></strong>
										</a>
									<?php endfor;  ?>
									<?php
									$nextChap = $chapNum+1;
									if($nextChap > $chapCnt) $nextChap = $chapCnt;
									$nextPage = $nextChap*3-2;
									?>
									<a href="/question.php?page=<?= $nextPage ?>" class="next1"></a>
									<a href="/question.php?page=<?= $pageCnt ?>" class="next2"></a>
								</div>
							</div>
						</div>
					</div>		
				</div>		
			</div>
			<?php require './footer.php'; ?>
		</div>
	</div>
	<script>
		const log = console.log;
		function view_content(e){
			let dom = e.querySelector(".question_preview");
			let style = dom.style.display;
			dom.style.display = style=="none" ? 'block' : 'none';
		}
		$(".status_true").on("click",(e)=>{
			let num = $(e.target).parent()[0].querySelectorAll("td")[0].innerHTML;
			let data = {};
			data.id = num;
			$.ajax({
				url : "./fx/get_answer.php",
				method : "POST",
				data : data,
				dataType : 'json',
				success : function(result){
					if(result=="f"){
						alert("서버 오류입니다. 다시시도 해주세요.");
						return;
					}
					$(".popup-box > h4").html(result.title);
					$(".popup_content").html(`${result.content}<br><br>(답변날짜 : ${result.day})`);
					$("#agree_popup").fadeIn();
				}
			});
		});
		$(".popup-box > button").on("click",(e)=>{
			$("#agree_popup").fadeOut();
		});
	</script>
</body>
</html>

<!-- INSERT INTO ``(`id`, `title`, `writer`, `day`, `content`, `cnt`) VALUES (null,"공지사항 테스트","관리자","2019/11/16","공지사항 컨텐츠 입니다. 다음주까지 제출해야되는데 이제 고객센터를 다 만들었다..ㅎㅎ 조졌누 ㅜㅜ",0); -->