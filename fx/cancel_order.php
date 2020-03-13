<?php
require './db.php';
checkLogin();
if(!isset($_POST['id'])){
	msgAndBack("잘못된 접근입니다.");
	exit;
}

if(!isset($_SESSION['user'])){
	msgAndBack("잘못된 접근입니다.");
	exit;	
}

$user = $_SESSION['user'];

$id =  $_POST['id'];
$sql = "SELECT * FROM `basket` WHERE `id` = ?";
$basketItem = fetch($con,$sql,[$id]);
$sql = "SELECT * FROM `item` WHERE `id` = ?";
$item = fetch($con,$sql,[$basketItem->item]);
$price = $item->price*(100-$item->sale)/100;
$price*=$basketItem->cnt;
$sql = "UPDATE `user` SET `point`=`point`+? WHERE `number` = ?";
$cnt = query($con,$sql,[$price,$user->number]);
$sql = "DELETE FROM `basket` WHERE `id` = ?";
$cnt = query($con,$sql,[$id]);
echo $cnt ? "t" : "f";
exit;