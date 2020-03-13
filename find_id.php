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
				<h3 class="tit_login">아이디 찾기</h3>
				<div class="write_form find_view">
					<form id="form" method="POST" onsubmit="return chkForm(this);">
						<strong class="tit_label">이름</strong>
						<input id="name" type="text" name="name" placeholder="고객님의 이름을 입력해주세요">
						<strong class="tit_label">이메일</strong>
						<input id="email" type="email" name="email" placeholder="가입시 등록하신 이메일 주소를 입력해주세요">
						<button type="submit" class="btn_type1"><span class="txt_type">확인</span></button>
					</form>
				</div>
			</div>
		</div>
	</section>
	<?php require './footer.php'; ?>
</body>
</html>