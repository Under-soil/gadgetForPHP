<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        if ($this->userData)
        {
            $this->load->helper('url');
            $this->load->view('common/header');
            $this->load->view('common/top', $data = ['user' => $this->userData]);
            if (!$this->hasRule)
            {
                $data['tips'] = "暂无权限";
                $this->load->view('common/tips', $data);
            } else{
                if ($this->userData['type'] == AGENT_TYPE)
                {
                    if ($this->userData['pwd_strength'] > 1)
                    {
                        $this->load->view('common/menu', $data = ['nav' => $this->menuData]);
                    } else {
                        $data['tips'] = "您的帐号目前的密码过于脆弱，请您修改密码后再进行其他的操作(修改密码请点击页面右上角向下箭头)";
                        $this->load->view('common/tips', $data);
                    }
                } else {
                    $this->load->view('common/menu', $data = ['nav' => $this->menuData]);
                }
            }
            $this->load->view('common/footer');
        } else {
            $pu_key =  file_get_contents($this->config->item('rsa_public_key_path'));
            $data['pu_key'] = $pu_key;
            $this->load->view('login/index', $data);
        }
    }
}
