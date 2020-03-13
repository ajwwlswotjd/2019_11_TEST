<?php
require './db.php';
$title = $_POST['title'];
$content = $_POST['content'];
$user = $_SESSION['user'];
$today = date("Y-m-d");
if($title=="" || $content==""){
	msgAndBack("공지사항 등록에 실패하였습니다.");
	exit;
}
$sql = "INSERT INTO `notice`(`id`, `title`, `writer`, `day`, `content`, `cnt`) VALUES (null,?,?,?,?,0)";
$cnt = query($con,$sql,[$title,$user->name,$today,$content]);
if($cnt){
	msgAndBack("공지사항이 성공적으로 등록되었습니다.");
	exit;
}else {
	msgAndBack("공지사항 등록에 실패하였습니다.");
	exit;
}