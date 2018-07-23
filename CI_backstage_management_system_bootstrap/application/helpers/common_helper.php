<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 生成签名
 * @param $args
 * @param $sign
 * @return string
 */
function make_signature($args, $sign)
{
    foreach ($args as $key=>$value)
    {
        $arr[$key] = $key;
    }
    sort($arr);
    $str = '';
    foreach ($arr as $k => $v)
    {
        $str = $str . $args[$v];
    }
    $str .= $sign;
    return  strtoupper(sha1($str));
}

/**
 * 检查密码强度
 * @param $pwd
 * @return int
 */
function check_strength($pwd)
{
    $result = 0;
    do
    {
        if (strlen($pwd) < 8)
        {
            break;
        }
        if (preg_match("/[0-9]/", $pwd))
        {
            $result++;
        }
        if (preg_match("/[a-z]/", $pwd))
        {
            $result++;
        }
        if (preg_match("/[A-Z]/", $pwd))
        {
            $result++;
        }
        if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/", $pwd))
        {
            $result++;
        }
    } while (false);
    return $result;
}

/**
 * 生成唯一编号 如：订单号、兑换码等
 * @return string
 */
function generate_unique_no()
{
    $year = intval(date('Y'));

    //系统启用年限，第1,2,3.. n年
    $age = strval($year - 2017);

    //本年度的已过的小时
    $hour = str_pad(strval(date('z', time()) * 24 + date('H')), 4, 0, STR_PAD_LEFT);

    //$hour = str_pad((time() - mktime(0, 0, 0, 1, 1, $year)) / 3600, 4, 0, STR_PAD_LEFT);

    $min = date('i');

    //生成3位随机数
    $rand = mt_rand(100, 999);

    //伪唯一编号, uniqid() 无法生成真正的唯一编号，存在重复的
    $id = uniqid('', True);

    //id 格式化1，只保留数字
    $id = preg_replace("/[^0-9]+/", '', $id);

    //id 格式化2，取尾部的6位数字
    $id = substr($id, (-7 + ($rand % 2)), 6);

    //id 格式化3，不足6位，右侧补0
    $id = str_pad($id, 6, 0);

    return $age . $hour . $min. $id . $rand;
}

/**
 * 产生随机字符串，不长于32位
 * @param int $length
 * @return string
 */
function get_nonce_str($length = 32)
{
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $str ="";
    for ( $i = 0; $i < $length; $i++ )  {
        $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
    }
    return $str;
}

function post_xml_curl($xml, $url, $host, $port, $useCert = false, $second = 30, $ssl_cert_path = '', $ssl_key_path = '')
{
    $ch = curl_init();
    //设置超时
    curl_setopt($ch, CURLOPT_TIMEOUT, $second);

    //如果有配置代理这里就设置代理
    if($host != "0.0.0.0"
        && $port != 0){
        curl_setopt($ch,CURLOPT_PROXY, $host);
        curl_setopt($ch,CURLOPT_PROXYPORT, $port);
    }
    curl_setopt($ch,CURLOPT_URL, $url);

    //curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
    //curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
    if(stripos($url,"https://") !== FALSE){
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    }
    else
    {
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
    }

    //设置header
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    //要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    if($useCert == TRUE){
        //设置证书
        //使用证书：cert 与 key 分别属于两个.pem文件
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT, $ssl_cert_path);
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY, $ssl_key_path);
    }
    //post提交方式
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    //运行curl
    $data = curl_exec($ch);
    //返回结果
    if( ! $data){
        $data['post_error_no'] = curl_errno($ch);
    }
    curl_close($ch);
    return $data;
}

function curll_get( $url, $timeout=25, $options = array())
{
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT,$timeout);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch,  CURLOPT_FOLLOWLOCATION, 1);//跟踪跳转
    foreach ($options as $k=>$v) {
        curl_setopt($ch, $k, $v);
    }
    $file_contents = curl_exec($ch);
    curl_close($ch);
    return $file_contents;
}


function xmlToArray($xml)
{
    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);
    $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $values;
}


/**
 * 自动为URL追加参数
 * @param array $args
 * @param null $url
 * @return string
 */
function add_args_to_url($args=[],$url=null){
    if(!$url){
        $url=(!empty($_SERVER['HTTPS'])?'https://':'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }
    $parse_result=parse_url($url);

    $get_args=[];
    if(isset($parse_result['query'])){
        parse_str($parse_result['query'],$get_args);
    }elseif($_GET){
        $get_args=$_GET;
    }
    $args=array_merge($get_args,$args);


    $path_info=explode('/',$parse_result['path']);
    foreach($args as $k=>$v){
        if(is_numeric($k) && isset($path_info[$k])){
            if($v===null){
                unset($path_info[$k]);
            }else{
                $path_info[$k]=$v;
            }
            unset($args[$k]);
            continue;
        }

        if($v===null && isset($args[$k])){
            unset($args[$k]);
            continue;
        }
    }
    $parse_result['path']=implode('/',$path_info);


    $parse_result['query']=http_build_query($args);
    if($parse_result['query']){
        $parse_result['query']='?'.$parse_result['query'];
    }
    if(isset($parse_result['port'])){
        $parse_result['port']=':'.$parse_result['port'];
    }
    $parse_result['scheme']=$parse_result['scheme'].'://';
    return implode('',$parse_result);
}

/**
 * 随机数字
 * @param $max    长度
 * @return string
 */
function rand_code($max)
{
    $code = '';
    for ($i = 0 ; $i < (int)$max ; $i++)
    {
        $code .= rand(0,9);
    }
    return $code;
}
