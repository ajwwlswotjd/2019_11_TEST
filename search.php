<!DOCTYPE html>
<html lang="ko">
<head>
	<?php require './head.php'; ?>
	<link rel="stylesheet" href="./css/searchStyle.css">
</head>
<body>
	<div id="wrap">
		<div id="container">
			<div id="header"><?php require './header.php'; ?></div>
			<?php
			if(!isset($_GET['txt'])){
				msgAndBack("잘못된 접근입니다.");
				exit;
			}
			$txt = $_GET['txt'];
			if($txt==""){
				msgAndBack("검색어가 없습니다.");
				exit;
			}
			$sql = "SELECT * FROM `item` WHERE `info` LIKE '%".$txt."%'"." OR `name` LIKE '%".$txt."%'";
			$list = fetchAll($con,$sql,[]);
			$itemCnt = count($list);
			?>
			<div id="main"><div id="content">
				<div class="page_aticle page_search">
					<div class="head_section head_search">
						<h2 class="tit">상품검색</h2>
						<p class="desc">질좋은 덜퍼니잇의 상품을 검색해보세요.</p>
					</div>

					<form id="search_form" onsubmit="return search2(this);">
						<div class="search_box">
							<div class="tit">
								<label for="sch">검색 조건</label>
							</div>
							<div class="desc">
								<input type="text" name="txt" id="sch2" class="inp" value="<?=$txt ?>">
								<input type="submit" class="styled-button btn_search" value="검색하기">
							</div>
						</div>
					</form>
					
					<div id="goodsList" class="page_section section_goodslist">
						<p class="search_result">
							<strong class="emph">총&nbsp;<span><?= $itemCnt ?>&nbsp;</span>개</strong>
							의 상품이 검색되었습니다.
						</p>
						<div class="list_goods">
							<div class="inner_listgoods"><ul class="list">
								<?php if($itemCnt==0) : ?>
									<li class="no_data">
										검색된 상품이 없습니다.
									</li>
									<?php else : ?>
										<?php foreach ($list as $item) : ?>
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
										<?php endif; ?>
									</ul></div>
								</div>
							</div>

						</div>
					</div></div>
					<div id="footer">
						<?php require './footer.php'; ?>
					</div>
				</div>	
			</div>
			<script>
				function search2(e){
					let value = document.querySelector("#sch2").value;
					let url = "/search.php?txt="+value;
					location.href = url;
					return false;
				}
			</script>
		</body>
		</html>