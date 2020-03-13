<!DOCTYPE html>
<html lang="ko">
<head>
	<?php require './head.php'; ?>
	<link rel="stylesheet" href="./css/indexStyle.css">
</head>
<body>
	<?php require './header.php'; ?>
	<section id="visual">
		
		<div id="mySlide">
			<img src="./imgs/bg3.png" alt="슬라이더 3">
			<img src="./imgs/bg2.png" alt="슬라이더 2">
			<img src="./imgs/bg1.png" alt="슬라이더 1">
		</div>

		<div class="btn-box">
			<div class="btn-left" data-dir="0"></div>
			<div class="btn-right" data-dir="1"></div>
		</div>
		<script>
			let slider = $("#mySlide");
			let isSliding = false;
			let now = 0;
			let imgs = $("#mySlide img");
			$("#mySlide img").css({position : "absolute", right : "100%"});
			$("#mySlide img").eq(0).css({right : 0});
			$(".btn-box > div").on("click",(e)=>{
				let dir = $(e.target).data("dir");
				if(isSliding) return;
				isSliding = true;
				if(dir == 0){
					let next = now > 0 ? now - 1 : 2;
					$(imgs[now]).animate({right : "-100%"}, 1500,function(){isSliding = false;});
					$(imgs[next]).css({right : "100%"}).animate({right :0},1500);
					now = next;
				}else{
					let next = now < 2 ? now + 1 : 0;
					$(imgs[now]).animate({right : "100%"}, 1500,function(){isSliding = false;});
					$(imgs[next]).css({right : "-100%"}).animate({right :0},1500);
					now = next;
				}
			});
			let frame = setInterval(()=>{
				document.querySelector(".btn-right").click();
			},6000);
		</script>
	</section>
	
	<section id="recommend">
		<h1>이 상품 어때요?</h1>
		<div class="list-good">
			<?php
			$sql = "SELECT * FROM `item` ORDER BY rand() LIMIT 4";
			$result = fetchAll($con,$sql,[]);
			?>

			<?php foreach($result as $item) : ?>
				<?php if($item->sale==0) : ?>
					<li>
						<a href="/item.php?id=<?= $item->id ?>">
							<img src="./imgs/bg_no.png" alt="<?= $item->id ?>번 이미지" style="background-image: url(<?= $item->img ?>);">
						</a>
						<div class="info-goods">
							<span class="name-good"><a href="/item.php?id=<?= $item->id ?>">
								<?= html_entity_decode($item->name) ?>
							</a></span>
							<span class="price-good">
								<?= number_format($item->price) ?>원
							</span>
						</div>
					</li>
					<?php else : ?>
						<li>
							<a href="/item.php?id=<?= $item->id ?>">
								<div class="sale-box">SALE<br><span><?= $item->sale ?></span>%</div>
								<img src="./imgs/bg_no.png" alt="<?= $item->id ?>번 이미지" style="background-image: url(<?= $item->img ?>);">
							</a>
							<div class="info-goods">
								<span class="name-good"><a href="/item.php?id=<?= $item->id ?>">
									<?= html_entity_decode($item->name) ?>
								</a></span>
								<span class="price-good">
									<?php
									$sale = (100-$item->sale)/100;
									$cost = $item->price*$sale;
									?>
									<?= number_format($cost) ?>원
								</span>
								<span class="cost-good">
									<?= number_format($item->price) ?>원
								</span>
							</div>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</section>

		<section id="sale">
			<div class="sale-inner">
				<div class="sale-title">
					<h3>
						<span class="sale-name">
							최대할인
							<span class="tit-desc">
								현 시간, 할인율이 가장 높은 상품!
							</span>
						</span>
					</h3>
					<p class="sub_hook">망설이면 늦어요!</p>
				</div>
				<div class="sale-item">
					<ul>
						<li>
							<?php
							$sql = "SELECT * FROM `item` ORDER BY `sale` DESC, `date` DESC, `leftCnt` ASC LIMIT 1";
							$item = fetch($con,$sql,[]);
							?>
							<a href="/item.php?id=<?= $item->id ?>">
								<div class="sale-box">SALE<br><span><?= $item->sale ?></span>%</div>
								<img src="./imgs/bg_no.png" alt="<?= $item->id ?>번 이미지" style="background-image: url(<?= $item->img ?>);">
							</a>
							<div class="info_sale">
								<span class="sale-item-name">
									<a href="/item.php?id=<?= $item->id ?>">
										<?= html_entity_decode($item->name) ?>
									</a>
								</span>
								<a href="/item.php?id=<?= $item->id ?>">
									<?= html_entity_decode($item->info) ?>
								</a>
								<span class="dc"><?= $item->sale ?>%</span>
								<span class="sale-price">
									<?php
									$sale = (100-$item->sale)/100;
									$cost = $item->price*$sale;
									?>
									<?= number_format($cost) ?>원
								</span>
								<span class="sale-cost">
									<?= number_format($item->price) ?>원
								</span>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</section>

		<section id="best">
			<div class="best-list">
				<div class="best-title"><h3>
					<a href="/navList.php?order=soldCnt">베스트 <i class="fas fa-angle-right"></i></a>
				</h3></div>

				<div class="list-good">
					<?php
					$sql = "SELECT * FROM `item` ORDER BY `soldCnt` DESC, `date` DESC, `leftCnt` DESC LIMIT 4";
					$result = fetchAll($con,$sql,[]);
					?>

					<?php foreach($result as $item) : ?>
						<?php if($item->sale==0) : ?>
							<li>
								<a href="/item.php?id=<?= $item->id ?>">
									<img src="./imgs/bg_no.png" alt="<?= $item->id ?>번 이미지" style="background-image: url(<?= $item->img ?>);">
								</a>
								<div class="info-goods">
									<span class="name-good"><a href="/item.php?id=<?= $item->id ?>">
										<?= html_entity_decode($item->name) ?>
									</a></span>
									<span class="price-good">
										<?= number_format($item->price) ?>원
									</span>
								</div>
							</li>
							<?php else : ?>
								<li>
									<a href="/item.php?id=<?= $item->id ?>">
										<div class="sale-box">SALE<br><span><?= $item->sale ?></span>%</div>
										<img src="./imgs/bg_no.png" alt="<?= $item->id ?>번 이미지" style="background-image: url(<?= $item->img ?>);">
									</a>
									<div class="info-goods">
										<span class="name-good"><a href="/item.php?id=<?= $item->id ?>">
											<?= html_entity_decode($item->name) ?>
										</a></span>
										<span class="price-good">
											<?php
											$sale = (100-$item->sale)/100;
											$cost = $item->price*$sale;
											?>
											<?= number_format($cost) ?>원
										</span>
										<span class="cost-good">
											<?= number_format($item->price) ?>원
										</span>
									</div>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</section>

			<section id="new">
				<h1>오늘의 신상품 <i class="fas fa-angle-right"></i></h1>
				<span class="sub_new">매 순간, 덜퍼니잇의 새로운 상품을 만나보세요</span>
				<div class="list-good">
					<?php
					$sql = "SELECT * FROM `item` ORDER BY `date` DESC, `sale` DESC, `leftCnt` ASC LIMIT 4";
					$result = fetchAll($con,$sql,[]);
					?>

					<?php foreach($result as $item) : ?>
						<?php if($item->sale==0) : ?>
							<li>
								<a href="/item.php?id=<?= $item->id ?>">
									<img src="./imgs/bg_no.png" alt="<?= $item->id ?>번 이미지" style="background-image: url(<?= $item->img ?>);">
								</a>
								<div class="info-goods">
									<span class="name-good"><a href="/item.php?id=<?= $item->id ?>">
										<?= html_entity_decode($item->name) ?>
									</a></span>
									<span class="price-good">
										<?= number_format($item->price) ?>원
									</span>
								</div>
							</li>
							<?php else : ?>
								<li>
									<a href="/item.php?id=<?= $item->id ?>">
										<div class="sale-box">SALE<br><span><?= $item->sale ?></span>%</div>
										<img src="./imgs/bg_no.png" alt="<?= $item->id ?>번 이미지" style="background-image: url(<?= $item->img ?>);">
									</a>
									<div class="info-goods">
										<span class="name-good"><a href="/item.php?id=<?= $item->id ?>">
											<?= html_entity_decode($item->name) ?>
										</a></span>
										<span class="price-good">
											<?php
											$sale = (100-$item->sale)/100;
											$cost = $item->price*$sale;
											?>
											<?= number_format($cost) ?>원
										</span>
										<span class="cost-good">
											<?= number_format($item->price) ?>원
										</span>
									</div>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</section>
				<?php require './footer.php'; ?>
			</body>
			</html>
