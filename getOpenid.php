<?php


function vget($url){
    $info=curl_init();
    curl_setopt($info,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($info,CURLOPT_HEADER,0);
    curl_setopt($info,CURLOPT_NOBODY,0);
    curl_setopt($info,CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($info,CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($info,CURLOPT_URL,$url);
    $output= curl_exec($info);
    curl_close($info);
    return $output;
}

//开发者使用登陆凭证 code 获取 session_key 和 openid
$APPID = '****';
$AppSecret = '****';
$code = $_GET['code'];
//$code = I('get.code'); //thinkphp I方法
$url="https://api.weixin.qq.com/sns/jscode2session?appid=".$APPID."&secret=".$AppSecret."&js_code=".$code."&grant_type=authorization_code";
$arr = vget($url);  // 一个使用curl实现的get方法请求
$arr = json_decode($arr,true);
$openid = $arr['openid'];
$session_key = $arr['session_key'];

//echo "openid:".$openid."\n";
echo $openid;

// 数据签名校验
$signature = $_GET['signature'];
//$signature = I('get.signature'); //thinkphp I方法
$signature2 = sha1($_GET['rawData'].$session_key);  //记住不应该用TP中的I方法，会过滤掉必要的数据
if ($signature != $signature2) {
    echo '数据签名验证失败！';die;
};



//开发者如需要获取敏感数据，需要对接口返回的加密数据( encryptedData )进行对称解密
include 'WXBizDataCrypt.php';
//Vendor("PHP.wxBizDataCrypt");  //加载解密文件，在官方有下载
$encryptedData = $_GET['encryptedData'];
$iv = $_GET['iv'];
$pc = new \WXBizDataCrypt($APPID, $session_key);
$errCode = $pc->decryptData($encryptedData, $iv, $data);  //其中$data包含用户的所有数据
if ($errCode != 0) {
    echo '解密数据失败！';die;
}

//生成第三方3rd_session
$session3rd  = null;
$strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
$max = strlen($strPol)-1;
for($i=0;$i<16;$i++){
    $session3rd .=$strPol[rand(0,$max)];
}
//echo $session3rd;


?>
