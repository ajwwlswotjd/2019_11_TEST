<?php 
require './db.php';
if(!isset($_POST['name']) || !isset($_POST['email'])){
	msgAndBack("잘못된 접근 입니다.");
	exit;
}
$name = $_POST['name'];
$email = $_POST['email'];
$sql = "SELECT * FROM `user` WHERE `name` = ? AND `email` = ?";
$cnt = fetch($con,$sql,[$name,$email]);
if($cnt==true){
	echo "s".$cnt->id;
	exit;
}else {
	echo "f";
	exit;
}