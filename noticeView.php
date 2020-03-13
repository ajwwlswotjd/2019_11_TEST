<!DOCTYPE html>
<html lang="ko">
<head>
	<?php require "./head.php"; ?>
	<link rel="stylesheet" href="./css/noticeViewStyle.css">
</head>
<body>
	<?php
	if(!isset($_GET['id'])){
		msgAndBack("잘못된 접근입니다.");
		exit; 
	}
	?>
	<div id="wrap"><div id="container">
		<?php require './header.php'; ?>
		<?php
		$sql = "SELECT * FROM `notice` WHERE `id` = ?";
		$dom = fetch($con,$sql,[$_GET['id']]);
		if(!$dom){
			msgAndBack("잘못된 접근입니다.");
			exit; 
		}
		$sql = "UPDATE `notice` SET `cnt` = `cnt`+1 WHERE `id` = ?";
		$cnt = fetch($con,$sql,[$_GET['id']]);
		?>
		<div id="main"><div id="content">
			<div class="page_aticle">
				<div class="page_section">
					<div class="head_aticle">
						<h2 class="tit">
							공지사항
							<span class="tit_sub">덜퍼니잇의 새로운 소식들과 유용한 정보들을 한곳에서 확인하세요.</span>
						</h2>
					</div>
				</div>
			</div>	
			<div class="layout-wrapper">
				<div class="xans-element- xans-myshop xans-myshop-couponserial">
					<table width="100%" align="center" cellspacing="0" cellpadding="0">
						<tbody><tr><td><table width="100%"><tbody>
							<tr><td><table class="boardView" width="100%"><tbody>
								<tr>
									<th scope="row" style="border: none;">제목</th>
									<td><?= html_entity_decode($dom->title) ?></td>
								</tr>
								<tr>
									<th scope="row">작성자</th>
									<td><?= html_entity_decode($dom->writer) ?></td>
								</tr>
								<tr class="etcArea">
									<td colspan="2">
										<ul>
											<li class="date">
												<strong class="th">작성일</strong>
												<span class="td"><?= $dom->day ?></span>
											</li>
											<li class="hit">
												<strong class="th">조회수</strong>
												<span class="td"><?= $dom->cnt ?></span>
											</li>
										</ul>
									</td>
								</tr>
							</tbody></table></td>
						</tr>
						<tr>
							<td style="padding: 10px;" height="200" valign="top
							" id="contents">
							<table width="100%" style="table-layout: fixed;">
								<tbody><tr><td class="board_view_content" style="word-wrap: break-word; word-break: break-all;" id="contents_608" valign="top">
									<p><?= htmlentities($dom->content) ?></p>
								</td></tr>
								<tr><td height="1" bgcolor="#522671"></td></tr>
							</tbody>
							</table>
						</td>	
					</tr>
				</tbody></table>
				<br>
				<table width="100%" style="table-layout: fixed;" cellpadding="0" cellspacing="0">
					<tbody><tr><td align="center" style="padding-top: 10px;">
						<table width="100%"><tbody><tr>
							<td align="right">
								<?php
									$id = $_GET['id'];
									$page = ceil($id/10);
								?>
								<a href="/notice.php?page=<?= $page ?>">
									<span class="bhs_button yb" style="float:none;">목록</span>
								</a>
							</td>
						</tr></tbody></table>
					</td></tr></tbody>
				</table>
			</td></tr></tbody>
			</table>
		</div>
	</div>	
</div></div>
<?php require './footer.php'; ?>
</div></div>
</body>
</html>