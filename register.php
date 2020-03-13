<!DOCTYPE html>
<html lang="ko">
<head>
	<?php require './head.php';  ?>
	<link rel="stylesheet" href="./css/registerStyle.css">
	<script src="./js/registerApp.js"></script>
</head>
<body>

	<div id="agree_popup">
		<div class="popup_inner">
			<div class="popup-box">
				<h4>이용약관 및<br>개인정보처리방침</h4>
				<div class="popup_content">
					총칙<br>
					제1조(목적)<br>
					이 약관은 주식회사 덜퍼니잇(전자상거래 사업자)기 운영하는
					인터넷사이트 덜퍼니잇에서 제공하는 전자상거래 관련 서비스를 이용함에 있어 덜퍼니잇과 이용자의 권리,의무 책임사항을 규정함을 목적으로 한다.
					<br><br>
					제2조(정의)<br>
					①"덜퍼니잇"이란 회사가 재화 또는 용역(이화 "재화 등"이라 함)을 이용자에게 제공하기 위하여 컴퓨터 등 정보통신설비를 이용하여 재화 등을 거래할 수 있도록 설정한 가상의 영업장을 말하며, 아울러 서비스를 운영하는 사업자의 의미로도 사용합니다.
					<br>
					② "이용자"란 "덜퍼니잇"에 접속하여 이 약관에 따라 "덜퍼니잇"이 제공하는 서비스를 받는 회원 및 비회원을 말합니다.
					<br>
					③ ‘회원’이라 함은 "덜퍼니잇"에 회원등록을 한 자로서, 계속적으로 "덜퍼니잇"이 제공하는 서비스를 이용할 수 있는 자를 말합니다.
					<br><br>
					개인정보처리방침(수집목적)<br>
					맞춤형 회원 서비스 제공, 거점 기반 서비스 제공, 이용자 식별 및 본인여부 등
					<br><br>
					개인정보처리방침(수집 항목)<br>
					아이디, 비밀번호, 이름, 이메일, 휴대폰, 배송 주소
				</div>
				<button>확인</button>
			</div>
		</div>
	</div>

	<?php require './header.php';  ?>


	<section id="main">
		<div id="content">
			<div class="page_location">
				<a href="/">홈</a>
				<i class="fas fa-angle-right"></i>
				<strong>회원가입</strong>
			</div>

			<div class="head_join">
				<h2 class="tit">회원가입</h2>
			</div>

			<div class="member_join">

				<div class="field_head">
					<p>필수입력사항</p>
				</div>

				<div class="form_background">
					<table>
						<tbody>
							<tr>
								<td class="memberCols1">아이디</td>
								<td class="memberCols2">
									<input type="text" maxlength="16" placeholder="6자 이상, 16자 이하의 영문 혹은 영문과 숫자를 조합" id="id">
									<p class="txt_guide">
										<span>6자 이상, 16자 이하의 영문 혹은 영문과 숫자를 조합</span>
									</p>
								</td>
							</tr>
							<tr>
								<td class="memberCols1">비밀번호</td>
								<td class="memberCols2">
									<input type="password" id="pwd1" placeholder="비밀번호를 입력해주세요" max="20">
									<p class="txt_guide">
										<span>8자 이상, 20자이하 영문/숫자/특수문자를 모두 조합</span>
									</p>
								</td>
							</tr>
							<tr>
								<td class="memberCols1">비밀번호 확인</td>
								<td class="memberCols2">
									<input type="password" id="pwd2" placeholder="비밀번호를 한번 더 입력해주세요" max="20">
									<p class="txt_guide">
										<span>동일한 비밀번호를 입력해주세요.</span>
									</p>
								</td>
							</tr>
							<tr>
								<td class="memberCols1">이름</td>
								<td class="memberCols2">
									<input type="text" id="name" placeholder="고객님의 이름을 입력해주세요">
								</td>
							</tr>
							<tr>
								<td class="memberCols1">이메일</td>
								<td class="memberCols2">
									<input type="email" id="email" placeholder="예: ajwwlswotjd@naver.com">
								</td>
							</tr>
							<tr>
								<td class="memberCols1">휴대폰</td>
								<td class="memberCols2">
									<input value type="text" pattern="[0-9]*" id="call" placeholder="숫자만 입력해주세요 ( '-' 없이)">
									<p class="txt_guide">
										<span>'-'없이 숫자로만 입력해주세요. &nbsp;(10~11자)</span>
									</p>
								</td>
							</tr>
							<tr>
								<td class="memberCols1">배송 주소</td>
								<td class="memberCols2">
									<input type="text" id="address1" readonly placeholder="배송 주소를 검색해주세요">
									<div class="bhs_btn">
										<span class="ico"></span>
										<span class="txt">주소 검색</span>
									</div>
								</td>
							</tr>
							<tr>
								<td class="memberCols1">상세 주소</td>
								<td class="memberCols2">
									<input type="text" id="address2" placeholder="상세 주소를 입력해주세요">
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="reg_agree">
					<div class="fid_head">
						<h3>이용약관동의</h3>
					</div>
					<div class="check">
						<input type="checkbox" name="inp_check" id="inp_check">
						<label for="inp_check">
							<span class="txt_checkbox">본인은 이용약관 및, 개인정보처리방침에 동의합니다.</span>
						</label>
						<span class="agree_btn">
							약관보기
						</span>
					</div>
				</div>

				<div class="avoidDbl">
					<button class="btn_submit">가입하기</button>
				</div>
			</div>
		</div>
	</section>
	<?php require './footer.php';  ?>
	<form id="register_form">
		<input type="text" id="fid" name="id">
		<input type="password" id="fpwd" name="password">
		<input type="text" id="fname" name="name">
		<input type="email" id="femail" name="email">
		<input type="text" id="fcall" name="call">
		<input type="text" id="faddress" name="address">
	</form>
</body>
</html>