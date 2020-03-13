<!DOCTYPE html>
<html lang="ko">
<head>
	<?php require './head.php'; ?>
	<link rel="stylesheet" href="./css/edit2Style.css">
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
			if(!isset($_POST['password'])){
				msgAndBack("잘못된 접근 입니다.");
				exit;	
			}
			$sql = "SELECT * FROM `user` WHERE `number` = ? AND `password` = PASSWORD(?)";
			$number = $_GET['id'];
			$user = fetch($con,$sql,[$number,$_POST['password']]);
			if(!$user){
				msgAndBack("비밀번호가 올바르지 않습니다.");
				exit;	
			}
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
								</h2>
							</div>
							
							<div class="member_join">
								<div>
									<form action="/fx/change_info.php" method="POST" id="edit2_form" onsubmit="return chkEditForm2(this)">
										<div class="field_head head_type1">
											<h3 class="tit">기본정보</h3>
											<p class="sub">*필수입력사항</p>
										</div>
										<div class="boardWrite">
											<table class="tbl_comm">
												<tbody>
													<tr>
														<td class="memberCols1">아이디*</td>
														<td class="memberCols2">
															<input id="id" type="text" value="<?= $user->id ?>" readonly="" class="inp_read">
														</td>
													</tr>
													<tr>
														<td class="memberCols1">현재 비밀번호*</td>
														<td class="memberCols2">
															<input type="password" name="originPwd" id="originPwd" value>
														</td>
													</tr>
													<tr class="member_pwd">
														<td class="memberCols1">새 비밀번호*</td>
														<td class="memberCols2">
															<input type="password" name="newPwd1" id="newPwd1" maxlength="20">
															<p class="txt_guide">
																<span class="txt txt_case4">
																	8자 이상, 20자이하 영문/숫자/특수문자를 모두 조합
																</span>
															</p>
														</td>
													</tr>
													<tr class="member_pwd">
														<td class="memberCols1">새 비밀번호 확인*</td>
														<td class="memberCols2">
															<input type="password" id="newPwd2" name="newPwd2">
															<p class="txt_guide">
																<span class="txt case_same">
																	동일한 비밀번호를 입력해주세요.
																</span>
															</p>
														</td>
													</tr>
													<tr>
														<td class="memberCols1">이름*</td>
														<td class="memberCols2">
															<input id="name" placeholder="고객님의 이름을 입력해주세요." type="text" name="name" value="<?= $user->name ?>">
														</td>
													</tr>
													<tr>
														<td class="memberCols1"> 이메일*</td>
														<td class="memberCols2">
															<input id="email" placeholder="예 : yy_1910122@y-y.hs.kr" type="text" name="email" value="<?= $user->email ?>">
														</td>
													</tr>
													<tr class="mobile">
														<td class="memberCols1"> 휴대폰*</td>
														<td class="memberCols2">
															<div class="phone_num">
																<input placeholder="숫자만 입력해주세요." id="phone" type="text" value="<?= $user->phone ?>" name="phone">
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										
										<div id="avoidDbl" class="after" style="text-align: center;margin-bottom: 70px; margin-top: -40px;">
											<span class="noline">
												<input type="submit" class="bhs_button" value="회원정보수정">
											</span>
										</div>

									</form>
								</div>
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
		let pwd2_ok = false;
		let pwd_ok = false;
		let phone_ok = true;

		window.onload=function(){
			let pwdPtn = /^(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9])(?=.*[0-9]).{8,20}$/;
			let phonePtn = /^[0-9]{10,11}$/;
			$("#newPwd1").on("input",(e)=>{
				$("#newPwd2").val("");
				let value = e.target.value;
				pwd_ok = pwdPtn.test(value);
				pwd2_ok = false;
				document.querySelector(".case_same").style.color = pwd2_ok ? "#0f851a" : "#b3130b";
				document.querySelector(".txt_case4").style.color = pwd_ok ? "#0f851a" : "#b3130b";
			});
			$("#newPwd2").on("input",(e)=>{
				let value = e.target.value;
				pwd2_ok = value==$("#newPwd1").val();
				document.querySelector(".case_same").style.color = pwd2_ok ? "#0f851a" : "#b3130b";
			});
			$("#phone").on('input',(e)=>{
				let value = e.target.value;
				phone_ok = phonePtn.test(value);
			});
		}

		function chkEditForm2(e){
			let isEmpty = false;
			document.querySelectorAll(".tbl_comm input").forEach(x=>{
				if(x.value=="") isEmpty=true;
			});
			let nowPwd = $("#originPwd").val();
			let newPwd1 = $("#newPwd1").val();
			let newPwd2 = $("#newPwd2").val();
			let name = $("#name").val();
			let email = $("#email").val();
			let phone = $("#phone").val();
			let id = $("#id").val();
			let data = {};
			data.nowPwd = nowPwd;
			data.id = id;
			data.newPwd1 = newPwd1;
			data.newPwd2 = newPwd2;
			data.name = name;
			data.email = email;
			data.phone = phone;
			if(isEmpty){
				swal("error","빈 값","필수값이 비어있습니다. 확인해주세요.","");
				return false;
			}
			if(!pwd_ok){
				swal("error","잘못된 형식","비밀번호의 형식이 잘못되어있습니다.","");
				$("#newPwd1").focus();
				return false;
			}
			if(!pwd2_ok){
				swal("error","잘못된 형식","비밀번호와 비밀번호 확인이 다릅니다.","");
				$("#newPwd2").focus();
				return false;
			}
			if(!phone_ok){
				swal("error","잘못된 형식","휴대폰번호를 제대로 입력해주세요.","");
				$("#phone").focus();
				return false;
			}
			return true;
		}



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