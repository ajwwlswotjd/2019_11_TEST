<?php 
require './db.php';
$sql = "SELECT * FROM `item` WHERE `id` = ?";
$item = fetch($con,$sql,[$_POST['id']]);
if(!isset($_SESSION['user'])){
	echo "u";
	exit;
}
if(!$item){
	echo "f";
	exit;
}

$sql = "INSERT INTO `basket`(`id`,`owner`,`item`,`cnt`,`status`) VALUES (null,?,?,?,'in')";
$owner = $_SESSION['user']->number;
$item = $item->id;
$cnt = $_POST['cnt'];
$result = query($con,$sql,[$owner,$item,$cnt]);
if($result){
	echo "t";
	exit;
}else {
	echo "f";
}