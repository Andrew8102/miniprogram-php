<?php

$openid = $_GET['openId'];

//echo "openid:".$openid."/n";

$apply = "openid = '{$openid}' and processstatus = '0' and completestatus = '0'";
$process = "openid = '{$openid}' and processstatus = '1' and completestatus = '0'";
$complete = "openid = '{$openid}' and processstatus = '1' and completestatus = '1'";

$applysql = "SELECT COUNT(*) FROM orders WHERE {$apply}";
$processsql = "SELECT COUNT(*) FROM orders WHERE {$process}";
$completesql = "SELECT COUNT(*) FROM orders WHERE {$complete}";

//拼接语句

$servername = "localhost";
$username = "root";
$password = "";//服务器中连接数据库的密码
$dbname = "test";//使用的数据库名
 
 
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
 
$conn -> set_charset('utf8');


// 检测连接
if ($conn->connect_error) {
    die("connect server fail: " . $conn->connect_error);
	echo "数据库连接失败\n";
} 
//echo "数据库连接成功\n";


$result1 = $conn->query($applysql);
list($applynum) = $result1 -> fetch_row();

$result2 = $conn->query($processsql);
list($processnum) = $result2 -> fetch_row();

$result3 = $conn->query($completesql);
list($completenum) = $result3 -> fetch_row();

$array = ["apply"=>$applynum,"process"=>$processnum,'complete'=>$completenum];

echo json_encode($array);

$conn->close();
//echo "数据库已关闭";


?>