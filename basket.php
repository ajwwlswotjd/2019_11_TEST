<!DOCTYPE html>
<html lang="ko">
<head>
	<?php require './head.php'; ?>
	<link rel="stylesheet" href="./css/basketStyle.css">
</head>
<body>
	<div id="wrap">
		<div id="container">
			<div id="header"><?php require './header.php'; ?></div>
			<div class="layout-wrapper">
				<p class="goods-list-position"></p>
			</div>
			<div class="layout-page-header">
				<h2 class="layout-page-title">장바구니</h2>
				<div class="pg_sub_desc">
					<p>주문하실 상품명 및 수량을 정확하게 확인해 주세요.</p>
				</div>
			</div>
			<div id="main">
				<div id="content">
					<div class="user_form section_cart">
						<!-- <form id="viewCart"> -->
							<div class="tbl_comm cart_goods">
								<table class="tbl_comm tbl_header">
									<caption>장바구니 목록 제목</caption>
									<colgroup>
										<col style="width: 375px;">
										<col style="width: 432px;">
										<col style="width: 115px;">
										<col style="width: 110px;">
										<col style="width: auto;">
									</colgroup>
									<thead>
										<tr>
											<th id="thSelect">
												<span class="tit">카테고리</span>
											</th>
											<th id="thInfo">상품 정보</th>
											<th id="thCount">수량</th>
											<th id="thCost">상품금액</th>
											<th id="thDelete"><span class="screen_out">삭제선택</span></th>
										</tr>
									</thead>
								</table>
								<div id="viewGoods">
									<?php
									if(!isset($_GET['id']) || !isset($_SESSION['user'])){
										msgAndBack("잘못된 접근입니다.");
										exit;
									}
									$number = $_GET['id'];
									$sql = "SELECT * FROM `user` WHERE `number` = ?";
									$user = fetch($con,$sql,[$number]);
									if($user->number!=$_SESSION['user']->number){
										msgAndBack("잘못된 접근입니다.");
										exit;
									}
									$sql = "SELECT * FROM `basket` WHERE `owner` = ? AND `status` = 'in' ORDER BY `id` DESC";
									$list = fetchAll($con,$sql,[$number]);
									$cnt = count($list);
									?>
									<?php if($cnt==0) : ?>
										<div class="no_data">장바구니에 담긴 상품이 없습니다.</div>
									<?php endif; ?>
									<?php for($i=0; $i<$cnt;$i++) : ?>
										<?php
										$basketItem = $list[$i];
										$sql = "SELECT * FROM `item` WHERE `id` = ?";
										$item = fetch($con,$sql,[$basketItem->item]);
										$sql = "SELECT * FROM `kate` WHERE `en` = ?";
										$kate = fetch($con,$sql,[$item->kate]);
										$cost;
										?>
										<div>
											<div class="view_goods">
												<table class="tbl_goods goods">
													<caption>장바구니 목록 내용</caption>
													<colgroup>
														<col style="width: 76px;">
														<col style="width: 100px;">
														<col style="width: 488px;">
														<col style="width: 112px;">
														<col style="width: 86px;">
														<col style="width: 110px;">
														<col style="width: auto;">
													</colgroup>
													<tbody>
														<tr>
															<td headers="thSelect" class="goods_check">
																<?= $kate->icon ?>
															</td>
															<td class="goods_thumb" headers="thInfo">
																<a href="/item.php?id=<?= $item->id ?>" class="thumb">
																	<img src="<?= $item->img ?>" alt="상품이미지">
																</a>
															</td>
															<td class="goods_info" headers="thInfo">
																<a href="/item.php?id=<?= $item->id ?>" class="name">
																	<?= html_entity_decode($item->name) ?>
																</a>
																<dl class="goods_cost">

																	<?php if($item->sale!=0) : //세일 아님 ?>

																		<dd class="selling_price">
																			<span class="num">
																				<?php
																				$sale = (100-$item->sale)/100;
																				$cost = $item->price*$sale;
																				?>
																				<?= number_format(html_entity_decode($cost)) ?>
																			</span>
																			<span class="txt">원</span>
																		</dd>

																		<dd class="cost">
																			<span class="num"><?= number_format(html_entity_decode($item->price)) ?></span>	
																			<span class="txt">원</span>
																		</dd>

																		<?php else : ?>

																			<dd class="selling_price">
																				<?php $cost = $item->price ?>
																				<span class="num">
																					<?= number_format(html_entity_decode($cost)) ?>
																				</span>
																				<span class="txt">원</span>
																			</dd>

																		<?php endif; ?>
																	</dl>
																</td>
																<td class="goods_condition" headers="thInfo">
																	<div class="condition"></div>
																</td>
																<td headers="thCount">
																	<div class="goods_quantity">
																		<div class="quantity">
																			<div class="inp_quantity">
																				<?= number_format($basketItem->cnt) ?>
																			</div>
																		</div>
																	</div>
																</td>
																<td headers="thCost">
																	<dl class="goods_total">
																		<dd class="result">
																			<span class="num">
																				<?php
																				$price = $cost*$basketItem->cnt;
																				?>
																				<?= number_format($price) ?>
																			</span>
																			<span class="txt">원</span>
																		</dd>
																	</dl>
																</td>
																<td class="goods_delete" headers="thDelete">
																	<button onclick="basketDel(this);" type="button" class="btn btn_delete" data-id="<?= $basketItem->id ?>"><img src="https://res.kurly.com/pc/ico/1801/btn_close_24x24_514859.png" alt="삭제"></button>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										<?php endfor; ?>
									</div>
								</div>

								<?php
									$origin_price_all=0;
									$sale_price_all=0;
									$deliPrice = $cnt==0 ? 0 : 2500;
									for($i=0; $i < count($list); $i++){
										$basketItem = $list[$i];
										$cnt = $basketItem->cnt;
										$sql = "SELECT * FROM `item` WHERE `id` = ?";
										$item = fetch($con,$sql,[$basketItem->item]);
										$origin_price_all+=$item->price*$cnt;
										if($item->sale!=0){
											$cost = $item->price*$item->sale/100;
											$sale_price_all+=$cost;
										}
									}
									$price_all = $origin_price_all-$sale_price_all+$deliPrice;
								?>
								
								<div class="cart_result">
									<div class="cart_amount cell_except">
										<div class="amount_detail">
											<dl class="list amount_total">
												<dt class="tit">상품금액</dt>
												<dd class="result">
													<span class="inner_result">
														<span class="num"><?= number_format($origin_price_all) ?></span>
														<span class="txt">원</span>
													</span>
												</dd>
											</dl>
											<div class="deco deco_minus">
												<span class="ico"></span>
											</div>
											<dl class="list amount_dc">
												<dt class="tit">상품할인금액</dt>
												<dd class="result">
													<span class="inner_result">
														<span class="num"><?= number_format($sale_price_all) ?></span>
														<span class="txt">원</span>
													</span>
												</dd>
											</dl>
										</div>
										<div class="deco deco_plus">
											<span class="ico fst"></span>
											<span class="ico"></span>
										</div>
										<dl class="list amount_delivery">
											<dt class="tit">배송비</dt>
											<dd class="result">
												<span class="inner_result">
													<span class="num"><?= number_format($deliPrice) ?></span>
													<span class="txt">원</span>
												</span>
											</dd>
										</dl>
										<div class="deco deco_equal">
											<span class="ico fst"></span>
											<span class="ico"></span>
										</div>
										<dl class="list amout_result">
											<dt class="tit">결제예정금액</dt>
											<dd class="result">
												<span class="inner_result add">
													<span class="num" id="price_all" data-price="<?= $price_all ?>"><?= number_format($price_all) ?></span>
													<span class="txt">원</span>
												</span>
											</dd>
										</dl>
									</div>
									<?php

									?>
									<button onclick="order(this)" class="btn_submit <?= $cnt!=0 ? '' : 'no_submit' ?>">
										주문하기
									</button>

								</div>


								<!-- </form> -->
							</div>
						</div>
					</div>
					<?php require './footer.php'; ?>
				</div>
			</div>
			<script>
				const log = console.log;

				function basketDel(e){
					if(!confirm("정말 삭제하시겠습니까?")) return;
					let id = $(e).data("id");
					let data = {};
					data.id = id;
					$.ajax({
						url:"/fx/basket_del.php",
						method:"POST",
						data:data,
						success:function(e){
							if(e=="t"){
								location.reload();
							} else {
								swal("error","오류","데이터베이스 오류로 인해 실패하였습니다. 다시시도해주세요.");
								return;
							}
						}
					});
				}

				function order(e){
					if(e.classList.length==2){
						swal("info","빈 장바구니","장바구니가 비어있습니다. 장바구니를 채워주세요.","<a href='/navList.php?order=date'>신상품 보러가기</a>");
						return;
					}
					let price = $("#price_all").data("price");
					if(!confirm(`결제금액은 총 ${price.toLocaleString()}원 입니다. 주문하시겠습니까?`)) return;
					let data = {};
					data.price = price;
					$.ajax({
						url:"/fx/order.php",
						method:"POST",
						data:data,
						success:function(result){
							log(result);
							if(result=="m"){
								swal("error","금액 부족","가지고계신 돈보다 결제금액이 더 큽니다.","");
								return;
							}

							if(result=="f"){
								alert("데이터베이스 오류로 인해 요청이 취소되었습니다. 다시시도해주세요.");
								return;
							}

							if(result=="t"){
								alert("주문에 성공하였습니다. 감사합니다.");
								location.reload();
							}
						}
					});
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