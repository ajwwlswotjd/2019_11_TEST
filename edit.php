<!DOCTYPE html>
<html lang="ko">
<head>
	<?php require './head.php'; ?>
	<link rel="stylesheet" href="./css/editStyle.css">
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
												$sql = "SELECT * FROM `basket` WHERE `owner` = ? AND `status` = 'out'";
												$list = fetchAll($con,$sql,[$user->number]);
												$cnt = count($list);
												?>
												<?= number_format($cnt) ?>개
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
									<li>
										<a href="/me.php?id=<?= $user->number ?>">주문내역</a>
									</li>
									<li class="on">
										<a href="/edit.php?id=<?= $user->number ?>">개인정보 수정</a>
									</li>
								</ul>
							</div>
						</div>
						<div id="viewOrderList" class="page_section section_orderlist">
							<div class="head_aticle">
								<h2 class="tit">
									개인정보 수정
									<span class="tit_sub">회원님의 개인정보를 수정해보세요.</span>
								</h2>
							</div>
							
							<div class="conf_pw">
								<form id="edit_form" onsubmit="return chkEditForm(this)" action="/edit2.php?id=<?= $_GET['id'] ?>" method="POST">
									<div class="tit"><img src="./imgs/edit.png"></div>
									<div class="field_pw">
										<div class="tit_id">아이디</div>
										<span class="txt_id"><?= html_entity_decode($user->id)?></span>
										<div class="tit_pw">비밀번호</div>
										<div>
											<input type="password" name="password" id="password" class="inp_pw">
										</div>
									</div>
									<div class="group_btn">
										<span class="inner_groupbtn">
											<button type="submit" class="btn btn_positive">확인</button>
										</span>
									</div>
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
		const log = console.log;

		function chkEditForm(e){
			let password = $("#password").val();
			if(password=="") return false;
			return true;
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