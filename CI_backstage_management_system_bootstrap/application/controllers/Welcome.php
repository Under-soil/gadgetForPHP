<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends My_Controller {
    public function index()
    {
        if ($this->userData)
        {
            $data = ['nav' => $this->menuData, 'user' => $this->userData];
            $this->load->view('main', $data);
        }
        else
        {
            $pu_key = file_get_contents($this->config->item('rsa_public_key_path'));
            $data['pu_key'] = $pu_key;
            $this->load->view('login/index', $data);
        }
    }
}
