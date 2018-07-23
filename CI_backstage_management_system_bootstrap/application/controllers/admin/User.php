<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends My_Controller {
    /**
     * 用户列表
     */
    public function index()
    {
        $data['gInfo'] = $this->groupData;
        $data['navName'] = $this->navName;
        $this->load->view('user/index', $data);
    }

    public function data()
    {
        $result = ['success' => true, 'totalRows' => 0, 'curPage' => 1, 'data' =>[]];
        do {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('pageSize','每页显示数量','trim|required');
            $this->form_validation->set_rules('curPage','当前页数','trim|required');
            if (!$this->form_validation->run()) {
                break;
            }
            $pageSize = $this->input->post('pageSize', true);
            $curPage = $this->input->post('curPage', true);
            $this->load->model('group_model', 'group');
            $data = $this->group->get_manage_user($pageSize, ($curPage - 1) * $pageSize);
            if ($data && is_array($data))
            {
                $result['data'] = $data;
                $result['totalRows'] = $this->group->get_manage_user_num();
            }
            $result['curPage'] = $curPage;
        } while (false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function view($id)
    {
        if ( ! (is_numeric($id) && $id > 0))
        {
            die;
        }
        $this->load->model('group_model', 'group');
        // 获取用户组数据
        $groupData=$this->group->getOne(Group_model::T_GROUP, ['id' => $id]);
        $data = [
            'group_data'=>$groupData,
            'navName' => $this->navName
        ];
        $this->load->view('user/add', $data);
    }

    public function add()
    {
        $result = ['r' => 0, 'm' => ''];
        do {
            $this->load->library('form_validation');
            $this->load->model('user_model', 'user');
            $this->form_validation->set_rules('level', '用户组', 'trim|required|greater_than[0]|regex_match[/^[1-9][0-9]{0,10}$/]');
            $this->form_validation->set_rules('phone', '手机号', 'trim|required|is_unique[' . User_model::T_USER . '.username]|regex_match[/^1[34578]\d{9}$/]');
            $this->form_validation->set_message('regex_match', '{field}格式不正确');
            $this->form_validation->set_message('required', '{field}不能为空');
            $this->form_validation->set_message('is_unique', '手机号已被注册');
            if (!$this->form_validation->run()) {
                $result['m'] = '请检查参数,' . validation_errors();
                break;
            }
            $data = $this->input->post();

            $insert_data['username'] = $data['phone'];
            $insert_data['level'] = $data['level'];
            $insert_data['passwd'] = md5(mt_rand(10000000, 99999999));
            $insert_data['state'] = 1;
            $insert_data['create_time'] = date('Y-m-d H:i:s');
            $insert_data['create_ip'] = $this->input->ip_address();

            $this->load->model('user_model', 'user');
            if ($this->user->addData(User_model::T_USER, $insert_data)) {
                $result['r'] = 2;
            }
        } while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function setState()
    {
        $ret = null;
        do
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id','id','trim|required');
            $this->form_validation->set_rules('level','level','trim|required');
            $this->form_validation->set_rules('opt','操作','trim|required');
            if ( ! $this->form_validation->run())
            {
                $ret = array('r'=> 1, 'm' => '请填写完整信息');
                break;
            }
            $id = $this->input->post('id', TRUE);
            $opt = $this->input->post('opt', TRUE);
            $level = $this->input->post('level', TRUE);

            if ($id ==  $this->userData['id'])
            {
                $ret = array('r'=> 0, 'm' => '不能对自己进行操作');
                break;
            }
            $this->load->model('user_model','user');
            if ($level == User_model::ROOT_LEVEL)
            {
                $ret = array('r'=> 0, 'm' => '不能对超级管理员进行操作');
                break;
            }
            if ( ! $this->user->set_state($id, $opt))
            {
                $ret = array('r'=> 0, 'm' => '操作失败');
                break;
            }
            $ret = array('r'=> 2);

        } while(false);
        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    }
}