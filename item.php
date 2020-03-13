<!DOCTYPE html>
<html lang="ko">
<head>
	<?php require './head.php'; ?>
	<link rel="stylesheet" href="./css/itemStyle.css">
</head>
<body>
	<div id="wrap"><div id="container">
		<div id="header"><?php require './header.php'; ?></div>
		<?php
		if(!isset($_GET['id'])){
			msgAndBack("잘못된 접근입니다.");
			exit;
		}
		$id = $_GET['id'];
		$sql = "SELECT * FROM `item` WHERE `id` = ?";
		$item = fetch($con,$sql,[$id]);
		if(!$item){
			msgAndBack("잘못된 접근입니다.");
			exit;
		}
		?>
		<div id="main">
			<div id="content">
				<div class="section_view">
					<div id="sectionView">
						<div class="inner_view">
							<div class="thumb" style="background-image: url(<?= $item->img ?>);">
								<img src="./imgs/bg_no.png" alt="상품 대표이미지" class="bg">						
							</div>

							<p class="goods_name">
								<span class="btn_share">
									<button id="btnShare">
										<?php
										$sql = "SELECT * FROM `kate` WHERE `en` = ?";
										$kate = fetch($con,$sql,[$item->kate]);
										?>
										<?= $kate->icon ?>
									</button>
								</span>
								<strong class="name"><?= html_entity_decode($item->name) ?></strong>
								<span class="short_desc"><?= html_entity_decode($kate->ko) ?></span>
							</p>
							
							<?php if($item->sale!=0) : ?>
								<div class="goods_dcinfo">
									<a href="#" class="btn_memberdc">할인가</a>
								</div>
							<?php endif; ?>
							<p class="goods_price">
								<span>
									<?php if($item->sale!=0) : #세일을 한다 ?>
										<span class="dc">
											<?php
											$cost = (100-$item->sale)/100;
											$cost *= $item->price;
											?>
											<span class="dc_price"><?= number_format($cost) ?></span><span class="won">원</span>
											<span class="dc_percent"><?= $item->sale ?></span>
											<span class="percent">%</span>
										</span>
										<span class="original_price">
											<?= number_format($item->price) ?>
											<span class="won">원</span>
										</span>
										<?php else : #세일을 안한다 ?>
											<span class="dc_price">
												<?= number_format($item->price) ?><span class="won" style="">원</span>
											</span>
										<?php endif; ?>
									</span>
								</p>

								<div class="goods_info">
									<dl class="list fst">
										<dt class="tit">등록날짜</dt>
										<dd class="desc"><?= html_entity_decode($item->date) ?></dd>
									</dl>
									<dl class="list">
										<dt class="tit">재고량</dt>
										<dd class="desc"><?= number_format(html_entity_decode($item->leftCnt)) ?>개</dd>
									</dl>
									<dl class="list">
										<dt class="tit">총 출고량</dt>
										<dd class="desc"><?= number_format(html_entity_decode($item->soldCnt)) ?>개</dd></dd>
									</dl>
									<dl class="list">
										<dt class="tit">카테고리</dt>
										<?php
										$sql = "SELECT * FROM `kate` WHERE `en` = ?";
										$kate = fetch($con,$sql,[$item->kate]);
										?>
										<dd class="desc"><?= html_entity_decode($kate->ko) ?></dd>
									</dl>
									<dl class="list info">
										<dt class="tit">상세정보</dt>
										<dd class="desc"><?= html_entity_decode($item->info) ?></dd>
									</dl>
								</div>
							</div>
						</div>

						<div id="cartPut">
							<div class="cart_option cart_type2">
								<div class="inner_option">
									<div class="in_option">
										<div class="list_goods">
											<ul class="list list_nopackage">
												<span class="tit_item">구메수량</span>
												<div class="option">
													<span class="count">
														<button type="button" class="btn down"></button>
														<input id="inp" type="number" readonly="readonly" onfocus="return false;" class="inp" min="1" value="1" max="<?= $item->leftCnt ?>" data-id="<?= $item->id ?>" data-img="<?= $item->img ?>" data-name="<?= $item->name ?>">
														<button type="button" class="btn up"></button>
													</span>
												</div>
											</ul>
										</div>
										<div class="total">
											<div class="price">
												<strong class="tit">총 상품금액 :</strong>
												<span class="sum">
													<span data-price="<?= $item->sale==0 ? $item->price : $item->price*(100-$item->sale)/100 ?>" class="num price_total"><?= number_format($item->sale==0 ? $item->price : $item->price*(100-$item->sale)/100) ?></span>
													<span class="won">원</span>
												</span>
											</div>
										</div>
									</div>

									<div class="group_btn off">
										<span class="btn_type1">
											<button type="button" class="txt_type" id="fill">장바구니 담기</button>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="layout-wrapper goods-view-area">
					<div class="goods-add-product">
						<h3 class="goods-add-product-title">
							RELATED PRODUCT
						</h3>
						<div class="goods-add-product-wrapper __slide-wrapper">
							<div class="goods-add-product-list-wrapper">
								<ul class="goods-add-product-list __slide-mover">
									<?php
									$sql = "SELECT * FROM `item` WHERE `kate` = ? ORDER BY rand() LIMIT 5";
									$list = fetchAll($con,$sql,[$item->kate]);
									?>
									<?php foreach($list as $item) : ?>
										<li class="goods-add-product-item __slide-item">
											<div class="goods-add-product-item-figure">
												<a href="./item.php?id=<?= $item->id ?>">
													<img class="goods-add-product-item-image" src="<?= $item->img ?>" alt="이미지">
												</a>
											</div>
											<div class="goods-add-product-item-content">
												<div class="goods-add-product-item-content-wrapper">
													<p class="goods-add-product-item-name">
														<?= html_entity_decode($item->name) ?>
													</p>
													<p class="goods-add-product-item-price">
														<?= number_format(html_entity_decode($item->price)) ?>원
													</p>
												</div>
											</div>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php require './footer.php'; ?>
	</div>
	<script>
		const log = console.log;
		let priceOne = $(".price_total").data("price");
		let max = $('#inp').attr("max");
		let now = 1;
		let price = priceOne;
		$(".down").on("click",(e)=>{
			if(now<=1) return;
			now-=1;
			$("#inp").val(now);
			price = priceOne*now;
			$('.price_total').html(price.toLocaleString());
		});

		$(".up").on("click",(e)=>{
			if(now>=max) return;
			now+=1;
			$("#inp").val(now);
			price = priceOne*now;
			$('.price_total').html(price.toLocaleString());
		});

		$("#fill").on('click',(e)=>{
			if(now <= 0 || now > max){
				alert("구매수량이 올바르지 않습니다.");
				return;
			}
			let data = {};
			data.id = $('#inp').data("id");
			data.cnt = now;
			$.ajax({
				url:"/fx/put_basket.php",
				method: "POST",
				data:data,
				success:function(result){
					if(result=="u"){
						swal("error","삐빅!","장바구니에 담으려면, 로그인을 해야합니다.","<a href='/login.php'>로그인하러 가기</a>");
						return;
					}
					if(result=="t"){
						
					let img = $("#inp").data("img");
					let name = $("#inp").data("name");
					$(".msg_cart img").attr("src",img);
					$(".msg_cart .tit").html(name);
					$(".msg_cart").fadeIn();
					setTimeout((e)=>{
						$(".msg_cart").fadeOut();
					},2000);

					}else if(result=="f"){
						swal("error","오류","장바구니에 담는데 실패하였습니다. 다시시도해주세요.");
						return;	
					}else {
						alert("잘못된 접근입니다.");
						return;
					}
				}
			});
		});

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