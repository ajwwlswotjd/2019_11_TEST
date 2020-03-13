<?php 

require './db.php';
if(!isset($_SESSION['user'])){
	msgAndBack("잘못된 접근입니다.");
	exit;
}

if(!isset($_POST['id'])){
	msgAndBack("잘못된 접근입니다.");
	exit;
}

$id = $_POST['id'];
$sql = "DELETE FROM `basket` WHERE `id` = ?";
$cnt = query($con,$sql,[$id]);
echo $cnt ? "t" : "f";
exit;
