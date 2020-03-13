<!DOCTYPE html>
<html lang="ko">
<head>
	<?php require './head.php';?>
	<link rel="stylesheet" href="./css/question_formStyle.css">s
	<script src="./js/question_formApp.js"></script>
</head>
<body>
	<div id="wrap">
		<div id="container">
			<?php require './header.php'; ?>
			<?php
			$mod = isset($_GET['id']) ? $_GET['id'] : null;
			$origin;
			if($mod!=null){
				$sql = "SELECT * FROM `question` WHERE `id` = ?";
				$origin = fetch($con,$sql,[$mod]);
				if(!$origin){
					msgAndBack("잘못된 접근입니다.");
					exit;
				}
				echo "<pre>";
				var_dump($origin);
				var_dump($user);
				echo "</pre>";
				if($user->number != $origin->writer){
					// msgAndBack("잘못된 접근입니다.");
					exit;
				}
			}
			if(!isset($_SESSION['user'])){
				msgAndBack("잘못된 접근입니다.");
				exit;
			}
			$user = $_SESSION['user'];
			?>
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
								<h2 class="tit">1:1문의</h2>
							</div>
							<div class="xans-board-write">
								<form id="fm" method="POST" action="/question_process.php" enctype="multipart/form-data" style="height: 100%;" onsubmit="return chkProcess(this);">
									<input type="hidden" name="mod" id="mod" value="<?=$mod?>">
									<table id="table_after" class="boardWrite2" width="100%">
										<colgroup>
											<col width="14%" align="right">
										</colgroup>
										<tbody>
											<tr>
												<th class="input_txt">제목</th>
												<td>
													<input type="text" name="title" style="width: 100%;" id="title" value="<?= $mod==null ? null : $origin->title ?>">
												</td>
											</tr>
											<tr>
												<th class="input_txt">내용</th>
												<td class="edit_area" style="position: relative;">
													<div id="qnaNotice">
														<div class="inner_qnaNotice">
															<div class="notice_qna">
																<strong class="tit qna_public">1:1 문의 작성 전 확인해주세요!</strong>
																<dl class="list qna_public">
																	<dt>반품 / 환불</dt>
																	<dd>
																		<span>제품 하자 혹은 이상으로 반품 (환불)이 필요한 경우 사진과 함께 구체적인 내용을 남겨주세요.</span>
																	</dd>
																</dl>

															</div>
														</div>
													</div>
													<textarea id="txtArea" name="content" placeholder="문의 내용을 입력해주세요." required fld_essential><?= $mod==null ? null : $origin->content ?></textarea>
												</td>
											</tr>
											<tr>
												<th class="input_txt">이미지</th>
												<td>
													<table id="table" width="95%" cellpadding="0" cellspacing="0" border="0"><tbody>
														<tr id="tr_0">
															<td width="20" nowrap align="center"></td>
															<td width="100%">
																<input type="file" name="upload" id="file" class="linebg" value="<?= $mod==null ? '' : $origin->img ?>">
															</td>
														</tr>
													</tbody></table>
													<table width="100%">
														<tbody>
															<tr>
																<td align="right" style="padding-top: 5px; border: none;" id="avoidDbl">
																	<input type="submit" class="bhs_button yb" value="저장" style="float:none;">
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php require './footer.php'; ?>
		</div>
	</div>
	<script>
		function chkProcess(e){
			let title = $('#title').val();
			let content = $('#txtArea').val();
			let file = $("#file").val();
			if(title=="" || content==""){
				swal("warning","삐빅!","빈 값이 있습니다. 확인해주세요.","");
				return false;
			}
			return true;
		}

		function swal(type,title,text,footer){
			Swal.fire({
				type: type,
				title: title,
				text: text,
				footer: footer
			})
		}
	</script>
</body>
</html>