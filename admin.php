<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>덜퍼니잇 관리자 모드</title>
	<link rel="stylesheet" href="./css/adminStyle.css">
	<script src="./js/adminApp.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="./js/jquery.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>
<body>
	<?php require './fx/db.php'; ?>
	<?php
	if(!isset($_SESSION['user'])){
		msgAndBack("잘못된 접근입니다.");
		exit;
	}
	$user = $_SESSION['user'];
	if($user->level!='admin'){
		msgAndBack("잘못된 접근입니다.");
		exit;
	}
	?>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="#">덜퍼니잇 관리자</a>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="#notice">공지사항 작성</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#question">문의 답변</a>
				</li>
			</ul>
		</div>
	</nav>
	<div class="container">
		<div class="jumbotron" id="main">
			<h1 class="display-4">덜퍼니잇 관리자모드</h1>
			<p class="lead">반갑습니다. <?= htmlentities($user->name) ?>님</p>
			<hr class="my-4">
			<p>오늘날짜 : <?= date("Y년 m월 d일") ?></p>
			<a class="btn btn-primary mt-2" href="/main.php" role="button">메인페이지</a>
		</div>

		<h2 class="tit" id="notice">공지사항 작성</h2>
		
		<form action="/fx/write_notice.php" method="POST">
			<div class="form-group mt-3">
				<label for="notice_title">제목</label>
				<input type="text" class="form-control mt-2" id="notice_title" placeholder="공지사항 제목" name="title">
			</div>
			<div class="form-group">
				<label for="notice_content">내용</label>
				<textarea name="content" class="form-control" id="notice_content" rows="3"></textarea>
			</div>
			<button class="btn btn-primary mt-2 float-right" type="submit">작성</button>
		</form>
		
		<h2 class="tit answer" id="question">1:1문의 답변하기</h2>
		
		<table class="table mt-5 question_tbl">
			<thead>
				<tr>
					<th scope="col">번호</th>
					<th scope="col">제목</th>
					<th scope="col">작성자</th>
					<th scope="col">날짜</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = "SELECT * FROM `question`";
				$list = fetchAll($con,$sql,[]);
				?>
				<?php foreach($list as $item) : ?>

					<?php
					$sql = "SELECT * FROM `answer` WHERE `question_id` = ?";
					$cnt = fetch($con,$sql,[$item->id]);
					?>
					<?php if(!$cnt) : ?>
						<tr data-content="<?= $item->content ?>" data-id="<?= $item->id ?>">
							<?php 
							$sql = "SELECT * FROM `user` WHERE `number` = ?";
							$writer = fetch($con,$sql,[$item->writer]);
							?>
							<th scope="row"><?= $item->id ?></th>
							<td><?= htmlentities($item->title) ?></td>
							<td><?= $writer->name ?></td>
							<td><?= htmlentities($item->day) ?></td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>

	</div>

	<script>
		const log = console.log;
		$("nav a").on("click",(e)=>{
			e.preventDefault();
			let href = $(e.target).attr("href");
			let offset = $(href).offset();
			$("html,body").animate({scrollTop : offset.top-80}, 400);
		});

		$(".question_tbl tr").on("click",(e)=>{
			let content = $(e.target).parent().data("content");
			let id = $(e.target).parent().data("id");
			if(confirm("문의내용 입니다. 답변을 작성하시겠습니까? \n \n \n "+content)){
				async function asdf(){
					const { value: formValues } = await Swal.fire({
						title: '답변하기',
						html:
						'<input id="swal-input1" class="swal2-input" placeholder="답변 제목">' +
						'<textarea id="swal-input2" class="swal2-input" placeholder="답변 내용"></textarea>',
						focusConfirm: false,
						preConfirm: () => {
							return [
							document.getElementById('swal-input1').value,
							document.getElementById('swal-input2').value
							]
						}
					})

					if (formValues) {
						let title = formValues[0];
						let content = formValues[1];
						if(title=="" || content==""){
							Swal.fire({
								icon: 'error',
								title: '빈 값',
								text: '빈 값이 있습니다.',
								footer: ''
							})
							return;
						}

						let data = {};
						data.title = title;
						data.content = content;
						data.id = id;
						$.ajax({
							url : "/fx/answer.php",
							method : "POST",
							data : data,
							success : function(result){
								if(result=="t"){
									alert("답변이 정상적으로 처리되었습니다.");
									location.reload();
									return;
								}else if(result=="f"){
									alert("답변작성에 실패하였습니다. ");
									return;
								}
							}
						});

					}
				}
				asdf();
			}
		});
	</script>
	
</body>
</html>