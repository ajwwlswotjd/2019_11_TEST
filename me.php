<!DOCTYPE html>
<html lang="ko">
<head>
	<?php require './head.php'; ?>
	<link rel="stylesheet" href="./css/meStyle.css">
</head>
<body>
	<div id="wrap">
		<div id="container">
			<div id="header"><?php require './header.php'; ?></div>
			<?php
			if(!isset($_SESSION['user'])){
				msgAndBack("잘못된 접근 입니다.");
				exit;
			}
			if(!isset($_GET['id'])){
				msgAndBack("잘못된 접근 입니다.");
				exit;	
			}
			$sql = "SELECT * FROM `user` WHERE `number` = ?";
			$number = $_GET['id'];
			$user = fetch($con,$sql,[$number]);
			if($user->number != $_SESSION['user']->number){
				msgAndBack("잘못된 접근 입니다.");
				exit;
			}
			?>
			<div id="main">
				<div id="content">
					<div id="myPageTop" class="page_aticle mypage_top">
						<div class="mypagetop_user">
							<div class="inner_mypagetop">
								<div class="grade_user">
									<div class="grade">
										<span class="ico_grade class6">
											<span class="inner_grade">
												<span class="in_grade">
													사용자
												</span>
											</span>
										</span>
										<div class="grade_bnenfit">
											<div class="user">
												<strong class="name"><?= html_entity_decode($user->name) ?></strong>
												<span class="txt">님</span>
											</div>
											<div class="benefit">반갑습니다.</div>
										</div>
									</div>
								</div>
								
								<ul class="list_mypage">
									<li class="user_reserve">
										<div class="link">
											<div class="tit">현재잔액</div>
											<a href="#" class="info"><?= number_format($user->point) ?>원</a>
										</div>
									</li>

									<li class="user_coupon">
										<div class="link">
											<div class="tit">장바구니</div>
											<a href="/basket.php?id=<?= $user->number ?>" class="info">
												<?php
												$sql = "SELECT * FROM `basket` WHERE `owner` = ? AND `status` = 'out' ORDER BY `id` DESC";
												$list = fetchAll($con,$sql,[$user->number]);
												$cnt = count($list);
												$sql = "SELECT * FROM `basket` WHERE `owner` = ? AND `status` = 'in'";
												$basketCnt = count(fetchAll($con,$sql,[$user->number]));
												?>
												<?= number_format($basketCnt) ?>개
											</a>
										</div>
									</li>

									<li class="user_kurlypass"><div class="link"><div class="tit">잔액충전</div><a href="#" class="info info_link">충전하기</a></div></li>
								</ul>

							</div>
						</div>
					</div>
					
					<div class="page_aticle aticle_type2">
						<div id="snb" class="snb_my">
							<h2 class="tit_snb">마이페이지</h2>
							<div class="inner_snb">
								<ul class="list_menu">
									<li class="on">
										<a href="/me.php?id=<?= $user->number ?>">주문내역</a>
									</li>
									<li>
										<a href="/edit.php?id=<?= $user->number ?>">개인정보 수정</a>
									</li>
								</ul>
							</div>
						</div>
						<div id="viewOrderList" class="page_section section_orderlist">
							<div class="head_aticle">
								<h2 class="tit">
									주문 내역
									<span class="tit_sub">덜퍼니잇의 주문 내역을 조회 합니다.</span>
								</h2>
							</div>
							<ul class="list_order">
								<table class="tbl_comm tbl_header">
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
												<span class="tit">날짜</span>
											</th>
											<th id="thInfo">상품정보</th>
											<th id="thCount">수량</th>
											<th id="thCost">결제금액</th>
											<th id="thDelete"></th>
										</tr>
									</thead>
								</table>
								<?php if($cnt==0) : ?>
									<li class="no_data">주문내역이 없습니다.</li>
									<?php else : ?>
										<div id="viewGoods">

											<?php foreach($list as $basketItem) : ?>
												<?php
												$sql = "SELECT * FROM `item` WHERE `id` = ?";
												$item = fetch($con,$sql,[$basketItem->item]);
												?>
												<div>
													<div class="view_goods">
														<table class="tbl_goods goods">
															<colgroup>
																<col style="width: 156px;">
																<col style="width: 70px;">
																<col style="width: 450px;">
																<col style="width: 112px;">
																<col style="width: 74px;">
																<col style="width: 110px;">
																<col style="width: auto;">
															</colgroup>

															<tbody>
																<tr>

																	<td headers="thSelect" class="goods_check">
																		<?= htmlentities($basketItem->day) ?>
																	</td>

																	<td class="goods_thumb" headers="thInfo">
																		<a href="/item.php?id=<?= $item->id ?>" class="thumb">
																			<img src="<?=$item->img?>" alt="">
																		</a>
																	</td>

																	<td class="goods_info" headers="thInfo">
																		<a href="/item.php?id=<?= $item->id ?>" class="name">
																			<?= html_entity_decode($item->name) ?>
																		</a>
																	</td>

																	<td class="goods_condition" headers="thInfo">
																		<div class="condition"></div>
																	</td>
																	<td headers="thCount">
																		<div class="goods_quantity">
																			<?= number_format($basketItem->cnt) ?>
																		</div>
																	</td>
																	<td headers="thcost">
																		<dl class="goods_total">
																			<div class="result">
																				<?php
																					$itemPrice = $item->price*(100-$item->sale)/100;
																					$itemPrice*=$basketItem->cnt;
																				?>
																				<span class="num"><?= number_format($itemPrice) ?></span>
																				<span class="txt">원</span>
																			</div>
																		</dl>
																	</td>

																	<td class="goods_delete" headers="thDelete">
																		<button onclick="refuse(this);" class="btn btn_delete" data-id="<?= $basketItem->id ?>">
																			<img src="https://res.kurly.com/pc/ico/1801/btn_close_24x24_514859.png" alt="삭제">
																		</button>
																	</td>

																</tr>
															</tbody>
														</table>
													</div>
												</div>
											<?php endforeach; ?>
										<?php endif; ?>
									</div>
								</ul>
							</div>


						</div>

					</div>
				</div>

				<?php require './footer.php'; ?>
			</div>
		</div>
		<script>
			const log = console.log;

			function refuse(e){
				if(!confirm("정말로 주문을 취소하시겠습니까? 취소시 금액은 반환됩니다.")) return;
				let id = $(e).data("id");
				let data = {};
				data.id = id;
				$.ajax({
					url : "/fx/cancel_order.php",
					data : data,
					method : "POST",
					success : function(result){
						if(result=="t"){

						alert("성공적으로 주문을 취소하였습니다.");
						location.reload();
						return;

						}else if(result=="f"){
							alert("데이터베이스 오류로인해 실패하였습니다. 다시시도해주세요.");
							return;
						}
					}
				});
			}

			$(".info_link").on("click",(e)=>{
				async function asdf(){
					const { value: num } = await Swal.fire({
						title: '잔액충전',
						input: 'text',
						inputPlaceholder: '충전할금액을 입력해주세요.'
					})
					let value;
					if (num) {
						value=parseInt(num);
						if(isNaN(value) || value < 0){
							swal("error","잘못된 입력","충전금액은 자연수만입력해주세요.","");
							return;
						}
					}	
					let data = {};
					data.point = value;
					$.ajax({
						url:"/fx/get_point.php",
						method:"POST",
						data:data,
						success:function(result){
							if(result=="t"){
								alert("충전이 완료되었습니다.");
								location.reload();
							}else if(result=="f") {
								swal("error","실패","올바른 값으로 다시 충전해주세요.","");
								return;
							}
						}
					});
				}
				asdf();
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