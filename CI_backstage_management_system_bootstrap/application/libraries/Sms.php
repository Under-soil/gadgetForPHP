<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms{
    private $sms_config = []; //sms配置
    private $template_arr = [];//短信模版id

    public function __construct()
    {
        $CI = &get_instance();
        $CI->load->helper('common');

        $this->sms_config = $CI->config->item('sms');

        $this->template_arr = [
            'code' => '4514',
            'apply_pass' => '4897'
        ];
    }

    /**
     * 发送短信
     * @param $template_type  模版名称对应 $this->template_arr
     * @param $phone          发送手机
     * @param $content        内容（为空不发送）
     * @return bool           是否成功
     */
    function send_sms($template_type, $phone, $content = '')
    {
        return true;
        if (is_array($this->sms_config) && count($this->sms_config) && isset($this->template_arr[$template_type]))
        {
            $post_arr = [
                'accesskey'  => $this->sms_config['accesskey'],
                'secret' => $this->sms_config['secret'],
                'sign' => $this->sms_config['sign'],
                'templateId' => $this->template_arr[$template_type],
                'mobile' => $phone,
            ];

            if ($content)
            {
                $post_arr['content'] = urlencode($content);
            }

            $result = post_xml_curl(http_build_query($post_arr), $this->sms_config['send_url'], '', '', false, 30, '', '');

            $output = json_decode($result, true);
            if (is_array($output) && isset($output['code']) && $output['code'] == 0)
            {
                return true;
            }
            else
            {
                log_message("error", "sendSMS error -> output:".$result);
                return false;
            }
        }
        else
        {
            log_message("error", "sendSMS error -> post_arr:" . json_encode($this->sms_config).'  template_type:' . $template_type);
            return false;
        }
    }
}