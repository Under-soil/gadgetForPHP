<?php
require_once  __DIR__ . '/qiniu_sdk/autoload.php';

use Qiniu\Auth;
// 用于签名的公钥和私钥
$accessKey = 'pQPWgUDSsTxNgATuKXtfaprhZKbCoaWjRphK5bRU';
$secretKey = 'YJtO0Nn7rIsKt0rKfN_ggcuyWYhp460TH3p4_DXf';

// 初始化签权对象
$auth = new Auth($accessKey, $secretKey);

$bucket = 'edit-img-name';
// 生成上传Token
$token = $auth->uploadToken($bucket);
echo $token;