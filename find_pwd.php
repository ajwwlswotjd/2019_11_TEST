<!DOCTYPE html>
<html lang="ko">
<head>
	<?php require "./head.php"; ?>
	<link rel="stylesheet" href="./css/findStyle.css">
	<script src="/js/find_idApp.js"></script>
</head>
<body>
	<?php require './header.php'; ?>
	<section id="main">
		<div id="content">
			<div class="section_login">
				<h3 class="tit_login">비밀번호 변경</h3>
				<div class="write_form find_view">
					<form id="form" class="form2" method="POST" onsubmit="return chkForm2(this);">
						<strong class="tit_label">이름</strong>
						<input id="name" type="text" name="name">
						<strong class="tit_label">아이디</strong>
						<input id="id" type="text" name="id">
						<strong class="tit_label">이메일</strong>
						<input id="email" type="email" name="email">
						<button type="submit" class="btn_type1"><span class="txt_type">찾기</span></button>
					</form>
				</div>
			</div>
		</div>
	</section>
	<form id="form2" style="display: none;">
		<input type="password" id="pwd_hide" name="pwd">
		<input type="text" id="id_hide" name="id">
	</form>
	<?php require './footer.php'; ?>
</body>
</html>