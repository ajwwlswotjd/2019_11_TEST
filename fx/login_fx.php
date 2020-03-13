<?php 
require './db.php';
$id = $_POST['id'];
$password = $_POST['password'];
if(!isset($_POST['id']) || !isset($_POST['password'])){
	msgAndBack("잘못된 접근 입니다.");
	exit;
}
$sql = "SELECT * FROM `user` WHERE `id` = ? AND `password` = PASSWORD(?)";
$cnt = fetch($con,$sql,[$id,$password]);
if($cnt==true){
	$_SESSION['user'] = $cnt;
	echo "s".$cnt->name;
	exit;
}else {
	echo "f";
	exit;
}