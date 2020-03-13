<?php
require './db.php';
checkLogin();

$originPwd = $_POST['originPwd'];
$newPwd = $_POST['newPwd1'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$sql = "SELECT * FROM `user` WHERE `email` = ? AND `phone` = ? AND `password` = PASSWORD(?)";
$user = fetch($con,$sql,[$email,$phone,$originPwd]);
if(!$user || $user->id!=$_SESSION['user']->id){
	msgAndBack("올바른 현재 비밀번호를 입력해주세요.");
	exit;
}
$sql = "UPDATE `user` SET `password` = PASSWORD(?), `name` = ?, `email` = ?, `phone` = ? WHERE `number` = ?";
$cnt = query($con,$sql,[$newPwd,$name,$email,$phone,$user->number]);
if($cnt){
	msgAndGo("성공적으로 개인정보가 수정되었습니다.","/me.php?id=$user->number");
	exit;
}else {
	msgAndBack("동일한 이메일 혹은 휴대폰 번호가 있습니다.");
	exit;
}