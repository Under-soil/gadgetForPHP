<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/24
 * Time: 10:12
 */
class Captcha extends CI_Controller {
    public function gen()
    {
        $config = [
            'path' => $this->config->item('statics_path'),
            'height' => 28,
            'charset' => '1234567890'
        ];
        ob_clean();
        $this->load->library('verify', $config);
        $this->verify->doimg();
        $code = $this->verify->getCode();
        $this->session->set_userdata('captcha', strtolower($code));
    }

    /**
     * 找回密码
     */
    public function find_pwd_captcha_img()
    {
        $this->set_captcha('find_pwd_captcha');
    }

    /**
     * 管理员登录
     */
    public function manager_login()
    {
        $this->set_captcha('manager_captcha');
    }

    /**
     * 输出图片验证码
     * @param $key
     */
    private function set_captcha($key)
    {
        $config = [
            'path' => $this->config->item('statics_path'),
            'height' => 28,
            'charset' => '1234567890'
        ];
        ob_clean();
        $this->load->library('verify', $config);
        $this->verify->doimg();
        $code = $this->verify->getCode();
        $this->session->set_userdata($key, strtolower($code));
    }
}