<?php 

require './db.php';
if(!isset($_GET['id'])){
	msgAndBack("잘못된 접근입니다.");
	exit;
}
if(!isset($_SESSION['user'])){
	msgAndBack("잘못된 접근입니다.");
	exit;
}
$user = $_SESSION['user'];
$id = $_GET['id'];
$sql = "SELECT * FROM `question` WHERE `id` = ?";
$item = fetch($con,$sql,[$id]);
if($item->writer!=$user->number){
	msgAndBack("잘못된 접근입니다.");
	exit; 
}
// 접근권한 테스트 완료
$sql = 'DELETE FROM `question` WHERE `id` = ?';
$cnt = query($con,$sql,[$id]);
if($cnt){
	msgAndBack("문의 삭제에 성공하였습니다.");
	exit;
}else {
	msgAndBack("문의 삭제에 실패하였습니다. 다시시도해주세요.");
	exit;
}