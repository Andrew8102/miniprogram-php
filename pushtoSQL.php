<?php

$nickname = $_POST['nickname'];
$openid = $_POST['openid'];
$truename = $_POST['truename'];
$mobile = $_POST['mobile'];
$QQ = $_POST['QQ'];
$address = $_POST['address'];
$pcmodel = $_POST['pcmodel'];
$problem = $_POST['problem'];
$ps = $_POST['ps'];
$submitTime = $_POST['submitTime'];
//获取jsjformData的json提交数据

echo "\n".'openid：'.$openid."\n";
echo '微信昵称：'.$nickname."\n";
echo '姓名：'.$truename."\n";
echo '手机：'.$mobile."\n";
echo 'QQ：'.$QQ."\n";
echo '宿舍地址：'.$address."\n";
echo '电脑型号：'.$pcmodel."\n";
echo '具体问题：'.$problem."\n";
echo '备注：'.$ps."\n";
echo '提交时间：'.$submitTime."\n";


$servername = "localhost";
$username = "root";
$password = "";//服务器中连接数据库的密码
$dbname = "test";//使用的数据库名
 
 
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
 
// 检测连接
if ($conn->connect_error) {
    die("connect server fail: " . $conn->connect_error);
	echo "数据库连接失败\n";
} 
echo "数据库连接成功\n";

$sql = "INSERT INTO `orders` (`id`, `openid`, `nickname`, `truename`, `mobile`, `QQ`, `problem`, `address`, `pcmodel`, `ps`, `submitTime`) VALUES ('', '$openid', '$nickname', '$truename', '$mobile', '$QQ', '$problem', '$address', '$pcmodel', '$ps', '$submitTime')";

if ($conn->query($sql) === TRUE) {
    echo "insert success\n";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
echo "数据库已关闭";

?>