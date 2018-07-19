<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	//生成验证码
	public function gen()
	{
        $config = array(
            'seKey' => 'ThinkPHP.CN',   // 验证码加密密钥
            'codeSet' => '1234567890',             // 验证码字符集合
            'expire' => 7200,            // 验证码过期时间（s）
            'fontSize' => 25,              // 验证码字体大小(px)
            'useCurve' => true,            // 是否画混淆曲线
            'useNoise' => true,            // 是否添加杂点
            'imageH' => 40,               // 验证码图片高度
            'imageW' => 250,               // 验证码图片宽度
            'length' => 4,               // 验证码位数
            //'path' => $this->config->item('statics_path'),
            'path' => './assets/',
        );
        $this->load->library('verify', $config);
        ob_clean();
        $code = $this->verify->entry();
        $this->session->set_userdata('captcha', strtolower($code));
        echo $this->verify->show();

        /*ob_clean();
        //调用函数生成验证码
        $captcha = create_captcha();

        #将验证码字符串保存到session中
        $this->session->set_userdata('captcha', $captcha);*/
	}
}