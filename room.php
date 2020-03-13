<!DOCTYPE html>
<html lang="ko">
<head>
	<?php require './head.php'; ?>
	<style>
		#img {
			width: 80%;
			height: 80vh;
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%,-50%);
			background-image: url("/imgs/room.png");
			background-size: cover;
			background-repeat: no-repeat;
			cursor: pointer;
			display: flex;
			justify-content: center;
			align-items: center;
			background-position: center center;
		}
		#room_p {
			text-align: center;
			font-weight: bolder;
			font-size: 50px;
		}
		.room_span {
			color: #ddd;
			position: absolute;
			font-size: 60px;
			opacity: 0.24;
			cursor: <?php  ?>
		}
	</style>
</head>
<body>
	<p id="room_p">내가 접근 이상하게 하지 말랬지!!</p>
	<div id="img">
		<span class="room_span">이전 페이지로 돌아가기</span>
	</div>
	<script>
		document.querySelector("#img").addEventListener("click",(e)=>{
			if(confirm("다음부터 이상한 접근을 하지 않겠다고 약속 합니까?")){
				alert("이번 한번만 봐주는겁니다.(이전 페이지로 돌아갑니다)");
				history.back();
			}else {
				alert("그러면 못보내주지 ㅋ");
			}
		});
	</script>
</body>
</html>