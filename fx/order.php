<?php
require './db.php';
if(!isset($_SESSION['user'])){
	msgAndBack("잘못된 접근입니다.");
	exit;
}

if(!isset($_POST['price'])){
	msgAndBack("잘못된 접근입니다.");
	exit;
}

$price = $_POST['price'];
$user = $_SESSION['user'];
// $sql = "SELECT * FROM `basket` WHERE `owner` = ?";
// $basketList = fetchAll($con,$sql,[$user->number])
if($user->point < $price){
	echo "m";
	exit;
}

$today = date("Y-m-d");
$sql = "UPDATE `user` SET `point`=`point`-? WHERE `number` = ?";
$cnt = query($con,$sql,[$price,$user->number]);
$sql = "UPDATE `basket` SET `status` = 'out', `day` = ? WHERE `owner` = ?";
$cnt = query($con,$sql,[$today,$user->number]);
echo $cnt ? "t" : "f";
exit;