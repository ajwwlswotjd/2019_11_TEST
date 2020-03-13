<!DOCTYPE html>
<html lang="ko">
<head>
	<?php require './head.php'; ?>
	<link rel="stylesheet" href="./css/ktListStyle.css">
</head>
<body>
	<?php
	require './header.php';
	if(!isset($_GET['item'])){
		msgAndBack("잘못된 접근입니다.");
		exit;
	}
	$kate = $_GET['item'];
	$sql = "SELECT * FROM `kate` WHERE `en` = ?";
	$result = fetch($con,$sql,[$kate]);
	$sql = "SELECT * FROM `kate` WHERE 1";
	$list = fetchAll($con,$sql,[]);
	if(!$result){
		msgAndBack("잘못된 접근입니다.");
		exit;
	}
		// 권한 검사 끝
	?>
	<section id="main">
		<div id="content">
			<div class="page_aticle">
				<div id="lnbMenu" class="lnb_menu">
					<div class="inner_lnb">
						<div class="ico_cate">
							<span class="ico">
								<!-- <?= $result->icon ?> -->
								<img src="./imgs/shop_icon.png" alt="오류">
							</span>
							<sapn class="tit"><?= $result->ko ?></sapn>
						</div>
						<ul class="list">
							<?php foreach ($list as $item) : ?>
								<li>
									<a href="/ktList.php?item=<?= $item->en ?>" class="<?= $item->en==$kate ? 'on' : '' ?>"><?= $item->ko ?></a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>

				<div id="goodsList" class="page_section section_goodslist">
					<div class="list_goods">
						<div class="inner_lsitgoods">
							<?php
							$sql = "SELECT * FROM `item` WHERE `kate` = ?";
							$itemList = fetchAll($con,$sql,[$kate]);
							$itemCnt = count($itemList);
							$pageCnt = ceil($itemCnt/12);
							if($pageCnt <= 0)  $pageCnt = 1;
							$chapCnt = ceil($pageCnt/3);
							$pageNum = isset($_GET['page']) ? $_GET['page'] : 1;
							if($pageNum <= 0 || $pageNum > $pageCnt){
								msgAndBack("잘못된 접근 입니다.");
								exit;
							}
							$chapNum = ceil($pageNum/3);
							$itemIdx = ($pageNum-1)*12;
							$sql = "SELECT * FROM `item` WHERE `kate` = ? LIMIT {$itemIdx}, 12";
							$itemList = fetchAll($con,$sql,[$kate]);
							?>
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
													<?php
														$txt = $item->info;
														$length = strlen($txt);
														$limit = 150;
														if($length > $limit){
															$txt = substr($txt,0,$limit-2);
															$txt.="...";
														}
													?>
													<?= $txt ?>
												</span>
											</a>
										</div>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>

				<div class="layout-pagination">
					<div class="pagediv">
						<?php
						$start = $chapNum*3-2;
						$end = $start+2;
						if($end > $pageCnt) $end = $pageCnt;
						?>
						<a href="/ktList.php?item=<?= $kate ?>&page=1" class="prev2"></a>
						<?php
						$prevChap = $chapNum-1;
						if($prevChap <= 0) $prevChap = 1;
						$prevPage = $prevChap*3-2;
						?>
						<a href="/ktList.php?item=<?= $kate ?>&page=<?= $prevPage ?>" class="prev1"></a>
						<?php for($i=$start;$i<= $end;$i++) : ?>
							<a href="/ktList.php?item=<?=$kate?>&page=<?=$i?>" class="<?= $pageNum==$i ? 'nowPage' : '' ?>">
								<strong><?= $i ?></strong>
							</a>
						<?php endfor;  ?>
						<?php
						$nextChap = $chapNum+1;
						if($nextChap > $chapCnt) $nextChap = $chapCnt;
						$nextPage = $nextChap*3-2;
						?>
						<a href="/ktList.php?item=<?= $kate ?>&page=<?= $nextPage ?>" class="next1"></a>
						<a href="/ktList.php?item=<?= $kate ?>&page=<?= $pageCnt ?>" class="next2"></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php require './footer.php'; ?>
</body>
</html>