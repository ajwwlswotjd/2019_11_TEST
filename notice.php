<!DOCTYPE html>
<html lang="ko">
<head>
	<?php require './head.php'; ?>
	<link rel="stylesheet" href="./css/noticeStyle.css">
</head>
<body>
	<div id="wrap">
		<div id="container">
			<div id="header">
				<?php require './header.php'; ?>
			</div>

			<div id="main">
				<div id="content">
					<div class="page_aticle aticle_type2">
						<div id="snb" class="snb_cc">
							<h2 class="tit_snb">고객센터</h2>
							<div class="inner_snb">
								<ul class="list_menu">
									<li class="on">
										<a href="/notice.php">공지사항</a>
									</li>
									<li>
										<a href="/question.php">1:1문의</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="page_section">
							<div class="head_aticle">
								<h2 class="tit">
									공지사항
									<span class="tit_sub">
										덜퍼니잇의 새로운 소식들과 유용한 정보들을 한곳에서 확인하세요.
									</span>
								</h2>
							</div>
							<table width="100%">
								<tbody>
									<tr>
										<td>
											<div class="xans-element-xans-myshop xans-myshop-couponserial">
												<table cellpadding="0" class="xans-board-listheader jh">
													<tbody>
														<tr>
															<th>번호</th>
															<th>제목</th>
															<th>작성자</th>
															<th>작성일</th>
															<th>조회</th>
														</tr>
														<?php

														$sql = "SELECT * FROM `notice` ORDER BY `day` DESC `id` DESC";
														$list = fetchAll($con,$sql,[]);
														$showCnt = 10;
														$itemCnt = count($list);
														$pageCnt = ceil($itemCnt/12);
														if($pageCnt <= 0)  $pageCnt = 1;
														$chapCnt = ceil($pageCnt/3);
														$pageNum = isset($_GET['page']) ? $_GET['page'] : 1;
														if($pageNum < 0 || $pageNum > $pageCnt){
															msgAndBack("잘못된 접근 입니다.");
															exit;
														}
														$chapNum = ceil($pageNum/3);
														$itemIdx = ($pageNum-1)*12;
														$sql = "SELECT * FROM `notice` LIMIT {$itemIdx}, ${showCnt}";
														$itemList = fetchAll($con,$sql,[]);
														?>
														<?php foreach ($itemList as $item) : ?>
															<tr>
																<td width="50" nowrap align="center"><?=$item->id?></td>
																<td style="padding-left: 10px; text-align: left; color: #999">
																	<a href="/noticeView.php?id=<?= $item->id ?>"><?= $item->title ?></a>
																</td>
																<td width="100" nowrap align="center"><?= $item->writer ?></td>
																<td width="100" nowrap align="center" class="eng2"><?= $item->day ?></td>
																<td width="30" nowrap="" align="center" class="eng2"><?= $item->cnt ?></td>
															</tr>
														<?php endforeach; ?>
													</tbody>
												</table>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="layout-pagination">
								<div class="pagediv">
									<?php
									$start = $chapNum*3-2;
									$end = $start+2;
									if($end > $pageCnt) $end = $pageCnt;
									?>
									<a href="/notice.php?page=1" class="prev2"></a>
									<?php
									$prevChap = $chapNum-1;
									if($prevChap <= 0) $prevChap = 1;
									$prevPage = $prevChap*3-2;
									?>
									<a href="/notice.php?page=<?= $prevPage ?>" class="prev1"></a>
									<?php for($i=$start;$i<= $end;$i++) : ?>
										<a href="/notice.php?page=<?=$i?>" class="<?= $pageNum==$i ? 'nowPage' : '' ?>">
											<strong><?= $i ?></strong>
										</a>
									<?php endfor;  ?>
									<?php
									$nextChap = $chapNum+1;
									if($nextChap > $chapCnt) $nextChap = $chapCnt;
									$nextPage = $nextChap*3-2;
									?>
									<a href="/notice.php?page=<?= $nextPage ?>" class="next1"></a>
									<a href="/notice.php?page=<?= $pageCnt ?>" class="next2"></a>
								</div>
							</div>
						</div>
					</div>		
				</div>		
			</div>
			<?php require './footer.php'; ?>
		</div>
	</div>
</body>
</html>

<!-- INSERT INTO ``(`id`, `title`, `writer`, `day`, `content`, `cnt`) VALUES (null,"공지사항 테스트","관리자","2019/11/16","공지사항 컨텐츠 입니다. 다음주까지 제출해야되는데 이제 고객센터를 다 만들었다..ㅎㅎ 조졌누 ㅜㅜ",0); -->