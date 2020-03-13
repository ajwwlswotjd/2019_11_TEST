<?php
require './db.php';
if(!isset($_SESSION['user'])){
	msgAndBack("잘못된 접근입니다.");
	exit;
}

if(!isset($_POST['point'])){
	msgAndBack("잘못된 접근입니다.");
	exit;
}

$point = $_POST['point'];
$user = $_SESSION['user'];
$sql = "UPDATE `user` SET `point`=`point`+? WHERE `number` = ?";
$cnt =query($con,$sql,[$point,$user->number]);
echo $cnt ? "t" : "f";
exit;