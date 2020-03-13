<?php 
require './db.php';
checkLogin();
$title = $_POST['title'];
$content = $_POST['content'];
$id = $_POST['id'];
$writer = $_SESSION['user']->name;
$today = date("Y-m-d");
$sql = "INSERT INTO `answer`(`id`, `title`, `question_id`, `content`, `day`, `writer`) VALUES (null,?,?,?,?,?)";
$cnt = query($con,$sql,[$title,$id,$content,$today,$writer]);
echo $cnt ? "t" : "f";
exit;
