<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User
 *
 * @description 系统用户CURD
 * @modify 编码规范
 */
class User extends MY_Controller
{
    /**
     * 用户列表
     */
    public function index()
    {
        $data['gInfo'] = $this->groupData;
        $this->load->view('user/index', $data);
    }

    /**
     * 系统用户列表
     */
    public function data()
    {
        $result = ['success' => true, 'totalRows' => 0, 'curPage' => 1, 'data' =>[]];
        do
        {
            $this->load->library('form_validation');
            if (FALSE === $this->form_validation->run('page'))
            {
                log_message('ERROR', validation_errors());
                break;
            }
            $page_size = $this->input->post('pageSize', TRUE);
            $cur_page = $this->input->post('curPage', TRUE);

            $this->load->model('user_model', 'user');
            $this->load->model('group_model', 'group');

            $data = $this->user->get_sys_user(($cur_page - 1) * $page_size, $page_size);
            if ($data && is_array($data))
            {
                $result['data'] = $data;
                $result['totalRows'] = $this->user->get_sys_user_num();
            }
            $result['curPage'] = $cur_page;
        }
        while (FALSE);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 添加系统用户页面
     * @param $id
     */
    public function view($id)
    {
        if ( ! (is_integer(intval($id)) && $id >= 0))
        {
            die;
        }
        $this->load->model('group_model', 'group');
        $info = $this->group->get_by_id($id);
        if (FALSE === $info)
        {
            die;
        }
        $data['group_data'] = $info;
        $this->load->view('user/add', $data);
    }

    public function add()
    {
        $result = ['r' => self::STATE_FAIL, 'm' => ''];
        do {
            $this->load->library('form_validation');
            $this->load->model('user_model', 'user');
            $this->form_validation->set_rules('level','用户组','trim|required|greater_than[0]|regex_match[/^[1-9][0-9]{0,10}$/]'                              );
            $this->form_validation->set_rules('username', '用户名', 'trim|required|is_unique['.T_USER.'.username]|regex_match[/^[0-9a-zA-Z][0-9a-zA-Z_@.]{2,18}[0-9a-zA-Z]$/]');
            $this->form_validation->set_rules('passwd', '密码', 'trim|required|regex_match[/(?!^\[0-9]+$)(?!^[a-zA-Z]+$)(?!^[_#@]+$).{6,20}/]');
            $this->form_validation->set_message('regex_match', '{field}格式不正确');
            $this->form_validation->set_message('required', '{field}不能为空');
            $this->form_validation->set_message('greater_than', '{field}必须大于{param}');
            $this->form_validation->set_message('is_unique', '用户名已被注册');
            if (!$this->form_validation->run()) {
                $result['m'] = '请检查参数,'.validation_errors();
                break;
            }
            $data = $this->input->post();
            $data['passwd'] = md5($data['passwd']);
            $data['state'] = 1;
            $data['create_time'] = date('Y-m-d H:i:s');
            $data['create_ip'] = $this->input->ip_address();

            $this->load->model('user_model', 'user');
            if ($this->user->addData(T_USER, $data)) {
                $result['r'] = self::STATE_SUCCESS;
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
            if (!$this->form_validation->run())
            {
                $ret = array('r'=> self::STATE_FAIL, 'm' => '请填写完整信息');
                break;
            }
            $id = $this->input->post('id', true);
            $opt = $this->input->post('opt', true);
            $level = $this->input->post('level', true);

            if ($id ==  $this->userData['id'])
            {
                $ret = array('r'=> self::STATE_FAIL, 'm' => '不能对自己进行操作');
                break;
            }
            if ($level == ROOT_LEVEL)
            {
                $ret = array('r'=> self::STATE_FAIL, 'm' => '不能对超级管理员进行操作');
                break;
            }
            $this->load->model('user_model','user');

            if (!$this->user->editData(T_USER, ['id' => $id], ['state' => $opt]))
            {
                $ret = array('r'=> self::STATE_FAIL, 'm' => '操作失败');
                break;
            }
            $ret = array('r'=> self::STATE_SUCCESS);

        } while(false);
        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    }
}