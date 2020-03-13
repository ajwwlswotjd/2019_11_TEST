<?php

require './db.php';

if(!isset($_POST['id'])){
	echo "f";
	exit;
}

$sql = "SELECT * FROM `answer` WHERE `question_id` = ?";
$cnt = fetch($con,$sql,[$_POST['id']]);
echo json_encode($cnt);