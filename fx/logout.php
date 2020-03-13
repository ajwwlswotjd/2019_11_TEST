<?php
require './db.php';

if(!isset($_SESSION['user'])){
	msgAndBack("잘못된 접근 입니다.");
	exit;
}

unset($_SESSION['user']);
echo "<script>";
echo "history.back()";
echo "</script>";