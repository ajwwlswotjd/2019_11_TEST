<?php
require './fx/db.php';
if(!isset($_POST['mod']) || !isset($_POST['title']) || !isset($_POST['content'])){
	msgAndBack("잘못된 접근입니다.");
	exit;
}

if(!isset($_SESSION['user'])){
	msgAndBack("잘못된 접근입니다.");
	exit;	
}

$mod = $_POST['mod'];
$user = $_SESSION['user'];
if($mod!=null){
	$sql = "SELECT * FROM `answer` WHERE `question_id` = ?";
	$cnt = fetch($con,$sql,[$mod]);
	if($cnt){
		msgAndBack("이미 답변이 달린 문의 입니다.");
		exit;
	}
}
$title = $_POST['title'];
$content = $_POST['content'];
$result;
$today = date("Y-m-d");
$file = null;

if($_FILES['upload']['name']!=""){
	$file = $_FILES['upload'];
}


if($file != null){
	if(strncmp("image/", $file['type'], 6) != 0){
		msgAndBack("이미지 파일만 업로드할 수 있습니다.");
		exit;
	}

}

if($mod==null){
	// 1:1문의 작성일때
	if($file==null){ // 파일업로드를 안했다면
		$sql = "INSERT INTO `question`(`id`, `title`, `writer`, `day`, `content`) VALUES (?,?,?,?,?)";
		$result = query($con,$sql,[$mod,$title,$user->number,$today,$content]);
	}else { // 파일업로드를 했으면
		$sql = "INSERT INTO `question`(`id`,`title`,`writer`,`day`,`content`,`img`) VALUES (?,?,?,?,?,?)";
		move_uploaded_file($file['tmp_name'], "upload/" . $file['name']);
		$imgDir = "./upload/".$file['name'];
		$result = query($con,$sql,[$mod,$title,$user->number,$today,$content,$imgDir]);
	}
}else {
	// 수정일때
	if($file==null)	{// 파일 업로드를 안했다면
		$sql = "UPDATE `question` SET `title` = ?, `day` = ?, `content` = ? WHERE `id` = ?";
		$result = query($con,$sql,[$title,$today,$content,$mod]);
	}else { // 파일 업로드를 했다면?
		$sql = "UPDATE `question` SET `title` = ?, `day` = ?, `content` = ?, `img` = ? WHERE `id` = ?";
		$imgDir = "./upload/".$file['name'];
		$result = query($con,$sql,[$title,$today,$content,$imgDir,$mod]);
	}
}

if($result){
	msgAndGo("정상적으로 문의하였습니다. 최대한 빠른 시간내에 답변해드리겠습니다.","/question.php");
	exit;
}else {
	msgAndBack("데이터베이스 오류가 발생하였습니다. 다시시도해주세요.");
	exit;
}