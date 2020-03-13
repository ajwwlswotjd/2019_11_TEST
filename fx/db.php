<?php

session_start();

$con = new PDO(
	"mysql:host=gondr.asuscomm.com;
	dbname=yy_10122;
	charset=utf8mb4;","yy_10122","asdf1234"
);

function query($con,$sql,$param = []){
	$q = $con->prepare($sql);
	$cnt = $q->execute($param);
	return $cnt;
}

function fetch($con,$sql,$param = []){
	$q = $con->prepare($sql);
	$q->execute($param);
	return $q->fetch(PDO::FETCH_OBJ);
}

function fetchAll($con,$sql,$param = []){
	$q = $con->prepare($sql);
	$q->execute($param);
	return $q->fetchAll(PDO::FETCH_OBJ);
}

function msgAndBack($msg){
	echo "<script>";
	echo "alert('$msg');";
	echo "history.back();";
	echo "</script>";
}

function msgAndGo($msg,$link){
	echo "<script>";
	echo "alert('$msg');";
	echo "location.href = '$link'";
	echo "</script>";
}

function checkLogin(){
	if(!isset($_SESSION['user'])){
		msgAndBack("잘못된 접근입니다. (비로그인)");
		exit;
	}
}