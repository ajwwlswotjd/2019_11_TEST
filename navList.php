<!DOCTYPE html>
<html lang="ko">
<head>
	<?php require './head.php'; ?>
	<link rel="stylesheet" href="./css/navListStyle.css">
</head>
<body>
	<?php require './header.php'; ?>
	<?php
	if(!isset($_GET['order'])){
		msgAndBack("잘못된 접근 입니다.");
		exit;
	}
	$order = $_GET['order'];
	$sql = "SELECT * FROM `item` WHERE 1";
	$itemCnt = count(fetchAll($con,$sql,[]));
	$pageCnt = ceil($itemCnt/12);
	$chapCnt = ceil($pageCnt/3);
	$pageNum = isset($_GET['page']) ? $_GET['page'] : 1;
	if($pageNum < 0 || $pageNum > $pageCnt){
		msgAndBack("잘못된 접근 입니다.");
		exit;
	}
	$chapNum = ceil($pageNum/3);
	$itemIdx = ($pageNum-1)*12;
	$ud = null;
	if($order=="date"){
		$ud = "DESC"; // 클수록 좋다면, DESC 아니면 ASC
	}else if($order=="soldCnt"){
		$ud = "DESC";
	}else if($order=="sale"){
		$ud = "DESC";
	}else if($order=="leftCnt"){
		$ud = "ASC";
	}else {
		msgAndBack("잘못된 접근 입니다.");
		exit;
	}
	$sql = "SELECT * FROM `item` ORDER BY $order $ud LIMIT {$itemIdx}, 12";
	$itemList = fetchAll($con,$sql,[]);
	?>
	<?php 
	$idx = null;
	if($order=="date") $idx = 1;
	else if($order=="soldCnt") $idx = 2;
	else if($order=="sale") $idx = 3;
	else if($order=="leftCnt") $idx = 4;
	echo "<script>";
	echo "document.querySelectorAll('.nav-left > li')[$idx].classList.add('active');";
	echo "</script>";
	?>
	<section id="main">
		<div id="content">
			<div class="page_aticle">
				<div id="lnbMenu" class="lnb_menu">
					<div class="inner_lnb">
						<div class="ico_cate">
							<span class="ico">
								<img src="https://res.kurly.com/pc/img/1808/bg_blink_120_91.png" id="goodsListIconView" alt="카테고리 아이콘">
							</span>
							<span class="tit">NEW</span>
						</div>
						<ul class="list">
							<li>
								<a class="on">신상품</a>
								<script>
									document.querySelector("a.on").innerHTML = document.querySelector(".active > a").innerHTML;
								</script>
							</li>
							<li class="bg"></li>
						</ul>
					</div>
				</div>

				<div id="goodsList" class="page_section section_goodslist">
					<div class="list_ability"></div>
					<div class="list_goods">
						<div class="inner_listgoods">
							<ul class="list">
								<?php foreach ($itemList as $item) : ?>
									<li>
										<div class="item">
											<div class="thumb">
												<a href="/item.php?id=<?= $item->id ?>" class="img">
													<img src="<?= $item->img ?>" alt="아이템<?=$item->id?>번" width="308" height="396">
													<div class="group_btn">
														<button class="btn btn_cart">
															<span class="screen"></span>
														</button>
													</div>
												</a>
												<?php if($item->sale!=0) : ?>
													<span class="ico">
														SAVE
														<br>
														<span><?= $item->sale ?></span>%
													</span>
												<?php endif; ?>
											</div>
											<a href="/item.php?id=<?= $item->id ?>" class="info">
												<span class="name">
													<?= $item->name ?>
												</span>
												<span class="cost">
													<?php if($item->sale!=0) : ?>
														<span class="dc"><?= number_format($item->price) ?>원</span> <span class="emph">→</span>
														<span class="price">
															<?php
															$cost = $item->price;
															$sale = (100-($item->sale))/100;
															$cost *= $sale;
															echo number_format($cost);
															?>원
														</span>
														<?php else : ?>
															<span class="price">
																<?= number_format($item->price) ?>
																원
															</span>
														<?php endif; ?>
													</span>
													<span class="desc">
														<?= $item->info  ?>
													</span>
												</a>
											</div>
										</li>
									<?php endforeach; ?>

								</ul>
							</div>				
						</div>

						<div class="layout-pagination">
							<div class="pagediv">
								<?php
								$start = $chapNum*3-2;
								$end = $start+2;
								if($end > $pageCnt) $end = $pageCnt;
								?>
								<a href="/navList.php?order=<?= $order ?>&page=1" class="prev2"></a>
								<?php
								$prevChap = $chapNum-1;
								if($prevChap <= 0) $prevChap = 1;
								$prevPage = $prevChap*3-2;
								?>
								<a href="/navList.php?order=<?= $order ?>&page=<?= $prevPage ?>" class="prev1"></a>
								<?php for($i=$start;$i<= $end;$i++) : ?>
									<a href="/navList.php?order=<?=$order?>&page=<?=$i?>" class="<?= $pageNum==$i ? 'nowPage' : '' ?>">
										<strong><?= $i ?></strong>
									</a>
								<?php endfor;  ?>
								<?php
								$nextChap = $chapNum+1;
								if($nextChap > $chapCnt) $nextChap = $chapCnt;
								$nextPage = $nextChap*3-2;
								?>
								<a href="/navList.php?order=<?= $order ?>&page=<?= $nextPage ?>" class="next1"></a>
								<a href="/navList.php?order=<?= $order ?>&page=<?= $pageCnt ?>" class="next2"></a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</section>
		<?php require './footer.php'; ?>
	</body>
	</html>