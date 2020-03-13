<?php require './fx/db.php' ?>
<?php
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$admin = $user==null ? false : $user->level=='admin' ? true : false;
?>
<?php if($admin) :  ?>
	<div id="admin">
		<a href="/admin.php">
			관리자님 이시군요? 관리자 모드로 접속 할 수 있습니다!
		</a>
		<button></button>
	</div>
<?php endif; ?>
<!-- 헤더 --> 
<header>
	<!-- 헤더 윗부분 -->
	<div class="header-top">
		<!-- 헤더 윗부분, 윗부분 -->
		<div class="header-user">
			<!-- 좌측 상단 작은 타원 -->
			<div class="user-left">
				<?php if($user==null) : ?>
					<a href="/register.php">
						덜퍼니잇 시작&nbsp;<span>회원가입 <i class="fas fa-angle-right"></i></span>
					</a>
					<?php else : ?>
						<a href="/basket.php?id=<?= $user->number ?>">
							쇼핑의 첫걸음&nbsp;<span>장바구니 <i class="fas fa-angle-right"></i></span>
						</a>	
					<?php endif; ?>
				</div>
				<!-- 좌측 상단 작은 타원 끝-->

				<!-- 세션 관련 메뉴 -->
				<div class="user-right">
					<?php if($user==null) : ?>
						<li>
							<a href="/register.php">회원가입</a>
						</li>
						<li>
							<a href="/login.php">로그인</a>
						</li>
						<li class="">
							<a href="/notice.php">고객센터 <i class="fas fa-sort-down"></i></a>
							<ul class="sub">
								<li><a href="/notice.php">공지사항</a></li>
								<li><a href="/question.php">1:1 문의</a></li>
							</ul>
						</li>
						<li>
							<a href="/find_id.php">아이디</a>
							/
							<a href="/find_pwd.php">비밀번호 찾기</a>
						</li>
						<?php else :  ?>
							<li>
								<a href="/me.php?id=<?= $user->number ?>">
									<span class="ico_grade <?= $user->level=='admin'? 'admin' : ''  ?>"><?= $admin ? "관리자" : "사용자" ?></span>
									<span class="txt"><?= $user->name ?>님</span>
								</a>
							</li>
							<li>
								<a href="/notice.php">고객센터 <i class="fas fa-sort-down"></i></a>
								<ul class="sub">
									<li><a href="/notice.php">공지사항</a></li>
									<li><a href="/question.php">1:1 문의</a></li>
								</ul>
							</li>
							<li>
								<a href="/fx/logout.php">로그아웃</a>
							</li>
						<?php endif; ?>
					</div>
					<!-- 세션 관련 메뉴 끝 -->
				</div>
				<!-- 헤더 윗부분, 윗부분 끝 -->
				<div class="header-logo">
					<a href="/main.php" class="gomain">
						<img src="./imgs/logo.png" alt="네임리스 로고">
					</a>
				</div>
			</div>
			<!-- 헤더 윗부분 끝 -->

			<!-- 네비게이션 (화면 고정) -->
			<nav>
				<!-- 네비게이션 좌측 -->
				<div class="nav-left">
					<li>
						<a href="#">
							<i class="fas fa-bars"></i>
							전체 카테고리
						</a>
						<ul class="sub2">
							<li>
								<a href="ktList.php?item=part">
									<i class="fas fa-microchip"></i>
									컴퓨터 주요부품
								</a>
							</li>
							<li>
								<a href="ktList.php?item=km">
									<i class="fas fa-keyboard"></i>
									키보드·마우스·주변기기
								</a>
							</li>
							<li>
								<a href="ktList.php?item=broadcast">
									<i class="fas fa-network-wired"></i>
									음향·방송용 장비
								</a>
							</li>
							<li>
								<a href="ktList.php?item=software">
									<i class="fas fa-database"></i>
									소프트웨어·프로그램
								</a>
							</li>
							<li>
								<a href="ktList.php?item=game">
									<i class="fas fa-gamepad"></i>
									게이밍 의자·책상
								</a>
							</li>
							<li>
								<a href="ktList.php?item=raptop">
									<i class="fas fa-laptop"></i>
									노트북·랩탑
								</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="/navList.php?order=date">신상품</a>
					</li>
					<li>
						<a href="/navList.php?order=soldCnt">베스트</a>
					</li> 
					<li>
						<a href="/navList.php?order=sale">알뜰쇼핑</a>
					</li>
					<li>
						<a href="/navList.php?order=leftCnt">매진임박</a>
					</li>
				</div>
				<!-- 네비게이션 좌측 끝 -->

				<!-- 네비게이션 우측 -->
				<form id="form" onsubmit="return search(this);">
					<div class="nav-right">
						<div class="search-box">
							<input type="text" placeholder="검색어를 입력하세요." required="required" name="txt" id="sch">
							<button type="submit">
								<i class="fas fa-search"></i>
							</button>
						</div>
						<a href="/basket.php?id=<?= $user->number ?>">
							<img src="./imgs/cart.png" alt="장바구니">
						</a>
					</div>
				</form>
				<!-- 네비게이션 우측 끝 -->

			</nav>
			<div id="addMsgCart" class="msg_cart">
				<span class="point"></span>
				<div class="inner_msgcart">
					<img src="./imgs/logo.png" alt="" class="thumb">
					<p class="desc">
						<span class="tit" id="msg_cart_tit">오뚜기 냉동 고르곤졸라 사각피자 88g</span>
						<span class="txt">장바구니에 담겼습니다.</span>
					</p>
				</div>
			</div>
			<!-- 네비게이션 끝 -->

			<!-- 스크립트 -->
			<script>
				window.addEventListener("scroll",(e)=>{
					let nav = $('nav');
					let msg_cart = $(".msg_cart");
					let scrollTop = $("html, body").scrollTop();
					scrollTop >= 80 ? nav.addClass('stick') : nav.removeClass('stick');
					scrollTop >= 80 ? msg_cart.addClass('st') : msg_cart.removeClass('st');
				});
				function search(e){
					let value = document.querySelector("#sch").value;
					let url = "/search.php?txt="+value;
					console.log(url);
					location.href = url;
					return false;
				}
				$("#admin > button").on("click",(e)=>{
					$("#admin").slideUp("slow");
				});
			</script>
			<!-- 스크립트 끝 -->
		</header>
	<!-- 헤더 끝 -->