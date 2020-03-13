<?php 
require './db.php';
if(!isset($_POST['id']) || !isset($_POST['password']) || !isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['call']) || !isset($_POST['address'])){
	msgAndBack("잘못된 접근 입니다.");
	exit;
}
$id = $_POST['id'];
$password = $_POST['password'];
$name = $_POST['name'];
$email = $_POST['email'];
$call = $_POST['call'];
$address = $_POST['address'];

$sql = "SELECT * FROM `user` WHERE `id` = ?";
$cnt = fetch($con,$sql,[$id]);
if($cnt==true){
	echo "i";
	exit;
}
$sql = "SELECT * FROM `user` WHERE `phone` = ?";
$cnt = fetch($con,$sql,[$call]);
if($cnt==true){
	echo "p";
	exit;
}
$sql = "SELECT * FROM `user` WHERE `email` = ?";
$cnt = fetch($con,$sql,[$email]);
if($cnt==true){
	echo "e";
	exit;
}


$level = 'user';
$sql = "INSERT INTO `user`(`number`, `id`, `password`, `name`, `phone`, `address`,`email`,`point`,`level`) VALUES (null,?,PASSWORD(?),?,?,?,?,0,?)";

$cnt = query($con,$sql,[$id,$password,$name,$call,$address,$email,$level]);
echo $cnt==true ? "s" : "f";