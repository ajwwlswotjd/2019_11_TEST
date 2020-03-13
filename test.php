<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<title>관리자 추가 폼 데모버전</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: "Arial";
			font-weight: bolder;
		}
		.title {
			text-align: center;
			font-weight: bolder;
		}
	</style>
</head>
<body>
	<form id="form" onsubmit="return chk(this);" action="/test_fx.php" method="POST" enctype="multipart/form-data">
		<div class="container">
			<h1 class="mt-5 title">관리자 폼</h1>
			<div class="input-group mb-3 mt-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1">이름</span>
				</div>
				<input type="text" class="form-control" placeholder="아이템 이름" id="name" name="name">
			</div>

			<div class="input-group mb-3 mt-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1">세일</span>
				</div>
				<input type="number" class="form-control" placeholder="n%" id="sale" name="sale">
			</div>

			<div class="input-group mb-3 mt-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1">재고량</span>
				</div>
				<input type="number" class="form-control" placeholder="아이템 재고량" id="leftCnt" name="leftCnt">
			</div>

			<div class="input-group mb-3 mt-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1">출고량</span>
				</div>
				<input type="number" class="form-control" placeholder="아이템 풀고량" id="soldCnt" name="soldCnt">
			</div>

			<div class="input-group mb-3 mt-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1">가격</span>
				</div>
				<input type="number" class="form-control" placeholder="아이템 가격" id="price" name="price">
			</div>

			<div class="input-group mb-3 mt-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1">날짜</span>
				</div>
				<input type="date" class="form-control" placeholder="아이템 등록날짜" id="day" name="date">
			</div>

			<div class="input-group mb-3 mt-3">
				<div class="input-group-prepend">
					<label class="input-group-text" for="inputGroupSelect01">카테고리</label>
				</div>
				<select class="custom-select" id="kate" name="kate">
					<?php
					require_once './fx/db.php';
					$sql = "SELECT * FROM `kate` WHERE 1";
					$list = fetchAll($con,$sql,[]);
					?>
					<?php foreach($list as $item) :  ?>
						<?php
						$sql = "SELECT * FROM `item` WHERE `kate` = ?";
						$cnt = count(fetchAll($con,$sql,[$item->en]));
						?>
						<option value="<?= $item->en ?>"><?=$item->ko ?>&nbsp;(<?=$cnt?>개)</option>
					<?php endforeach;  ?>
				</select>
			</div>


			<div class="input-group mt-3">
				<div class="input-group-prepend">
					<span class="input-group-text">상세정보</span>
				</div>
				<textarea name="info" rows="6" class="form-control" id="info"></textarea>
			</div>


			<div class="input-group mb-3 mt-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="inputGroupFileAddon01">이미지파일</span>
				</div>
				<div class="custom-file">
					<input name="img" type="file" class="custom-file-inputs" id="file" aria-describedby="inputGroupFileAddon01">
				</div>
			</div>
			<button type="submit" id="btn" class="btn btn-primary float-right btn-lg">확인</button>
		</div>
	</form>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script>
		const log = console.log;
		$("input, textarea").val("");
		let randLeft = Math.floor(Math.random()*200+20);
		let randSold = Math.floor(Math.random()*200+20);
		let randSale = Math.floor(Math.random()*3)>=1 ? Math.floor(Math.random()*40+10) : 0;
		let y = Math.floor(Math.random()*9+2010);
		if(y<10) y = "0"+y;
		let m = Math.floor(Math.random()*12+1);
		if(m<10) m = "0"+m;
		let d = Math.floor(Math.random()*25+1);
		if(d<10) d = "0"+d;
		let randDate = `${y}-${m}-${d}`;
		$("#day").val(randDate);
		$("#leftCnt").val(randLeft);
		$("#soldCnt").val(randSold);
		$("#sale").val(randSale);
		function chk(e){

			let name = $("#name").val();
			let sale = $("#sale").val();
			let leftCnt = $('#leftCnt').val();
			let soldCnt = $('#soldCnt').val();
			let price = $('#price').val();
			let date = $('#day').val();
			let kate = $("#kate").val();
			let info = $("#info").val();
			let img = $("#file").val();

			let data = {};
			data.name = name;
			data.sale = sale;
			data.leftCnt = leftCnt;
			data.soldCnt = soldCnt;
			data.price = price;
			data.date = date;
			data.kate = kate;
			data.info = info;
			data.img = img;
			return true;
		};
	</script>
</body>
</html>

<!-- 이름, 세일, 재고량, 팔린갯수, 가격, 상세정보, 카테고리, 이미지, 날짜 -->