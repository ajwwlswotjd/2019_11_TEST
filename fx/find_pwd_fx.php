<?php
require './db.php';
if(!isset($_POST['id']) || !isset($_POST['name']) || !isset($_POST['email'])){
	msgAndBack("잘못된 접근 입니다.");
	exit;
}
$name = $_POST['name'];
$id = $_POST['id'];
$email = $_POST['email'];

$sql = "SELECT * FROM `user` WHERE `name` = ? AND `id` = ? AND `email` = ?";
$cnt = fetch($con,$sql,[$name,$id,$email]);
if($cnt==true){
	echo "s";
	exit;
}else {
	echo "f";
	exit;
}