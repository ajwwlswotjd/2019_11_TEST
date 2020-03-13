<?php
require_once './fx/db.php';

// $name = $_POST['name'];
// $sale = $_POST['sale'];
// $leftCnt = $_POST['leftCnt'];
// $soldCnt = $_POST['soldCnt'];
// $price = $_POST['price'];
// $date = $_POST['date'];
// $kate = $_POST['kate'];
// $info = $_POST['info'];
// $file = null;

// if($_FILES['img']['name']!=""){
// 	$file = $_FILES['img'];
// }

// $sql = "INSERT INTO `item`(`id`, `name`, `leftCnt`, `soldCnt`, `sale`, `price`, `info`, `kate`, `img`, `date`) VALUES (null,?,?,?,?,?,?,?,?,?)";
// move_uploaded_file($file['tmp_name'], "item_imgs/" . $file['name']);
// $imgDir = "/item_imgs/".$file['name'];
// $result = query($con,$sql,[$name,$leftCnt,$soldCnt,$sale,$price,$info,$kate,$imgDir,$date]);
// if($result){
// 	msgAndBack("성공");exit;
// }else {
// 	msgAndBack("실패");exit;
// }

$sql = "SELECT * FROM `item` WHERE 1";
$list = fetchAll($con,$sql,[]);	
echo "<pre>";
// var_dump($list);
foreach ($list as $item) {
	$sale = floor($item->sale/10)*10;
	$rand = rand(0,2);
	if($rand==0) $sale+=5;
	$sql = "UPDATE `item` SET `sale` = ? WHERE `id` = ?";
	$cnt = query($con,$sql,[$sale,$item->id]);
	echo $cnt;
}
echo "</pre>";