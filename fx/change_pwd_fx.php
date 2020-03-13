<?php
require './db.php';
if(!isset($_POST['id']) || !isset($_POST['pwd'])){
	msgAndBack("잘못된 접근 입니다.");
	exit;
}
$id = $_POST['id'];
$password = $_POST['pwd'];
$sql = "UPDATE `user` SET `password` = PASSWORD(?) WHERE `id` = ?";
$cnt = query($con,$sql,[$password,$id]);
echo $cnt==true ? "s" : "f";