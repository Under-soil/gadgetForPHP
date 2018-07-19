<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['rsa_private_key_path'] = 'D:/rsa/rsa_private_key.pem';
$config['rsa_public_key_path'] = 'D:/rsa/rsa_public_key.pem';
$config['app_name'] = "烟台麻将";
$config['ban_code_path'] = "";
$config['statics_path'] = "./assets";
$config['min_money'] = 100;
$config['max_money'] = 2000;
$config['sha1_key'] = '';     //微信扫码加密key
$config['redis_host'] = '';
$config['redis_port'] = 6379;
$config['redis_password'] = '';
$config['redis_db'] = '';
$config['redis_isopen']   = true;