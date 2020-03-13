<!DOCTYPE html>
<html lang="ko">
<head>
	<?php require './head.php'; ?>
	<link rel="stylesheet" href="./css/loginStyle.css">
	<script src="./js/loginApp.js"></script>
</head>
<body>
	<?php require './header.php'; ?>
	<section id="main">
		<div id="content">
			<div class="section_login">
				<h3 class="tit_login">로그인</h3>
				<div class="write_form">
					<div class="write_view login_view">
						<form id="form_login" name="form" onsubmit="return go();">
							<input id="id" type="text" name="id" placeholder="아이디를 입력해주세요">
							<input id="pwd" type="password" name="password" placeholder="비밀번호를 입력해주세요">
							<div class="checkbox_save">
								<div class="login_search">
									<a href="/find_id.php" class="link">아이디 찾기</a>
									<span class="bar"></span>
									<a href="/find_pwd.php" class="link">비밀번호 변경</a>
								</div>
							</div>
							<button id="login" class="btn" type="submit">
								<span>로그인</span>
							</button>
							<a href="/register.php" id="register" class="btn">
								<span>회원가입</span>
							</a>
						</form>
					</div>	
				</div>
			</div>
		</div>
	</section>
	<?php require './footer.php'; ?>
</body>
</html>