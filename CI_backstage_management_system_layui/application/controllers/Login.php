<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
    public function __construct()
    {
        parent::__construct(FALSE);
    }

    public function index()
    {
        $this->load->view('login/index');
    }

    public function ajax_login()
    {
        $ret = ['r' => self::STATE_FAIL, 'm' => ''];
        do
        {
            $data = $this->input->post(NULL, TRUE);
            if ( ! $this->form_validation_combine($data, ['captcha', 'username'], $ret['m']))
            {
                break;
            }

            //获取表单数据
            $captcha = $data['captcha'];
            $username = $data['username'];
            $password = $data['password'];

            //获取session中保存的验证码
             $code = $this->session->userdata("captcha");
            if ($captcha != $code)
            {
                $ret['m'] = '验证码不正确';
                break;
            }

            $this->load->model('user_model', 'user');
            $this->load->model('group_model', 'group');
            $user = $this->user->get_info_by_username($username);
            if ( ! $user)
            {
                $ret['m'] = '用户不存在';
                break;
            }
            if ($this->is_lock($user, $ret['m']))
            {
                break;
            }

            if ( ! $this->check_ssl_pwd($password, $user['passwd']))
            {
                $ret['m'] = '密码错误';
                $this->set_lock($user, $ret['m']);
                break;
            }
            $group_info = [];
            if ( $this->is_group_lock($group_info, $user['level']))
            {
                $ret['m'] = '该用户所在用户组已被禁用';
                break;
            }
            if (User_model::ENABLE != $user['state'])
            {
                $ret = array('r'=> 6, 'm'=>'该用户已被禁用');
                break;
            }
            if ($group_info['type'] != AGENT_TYPE)
            {
                $user['yunying'] = 0;
                $user['code'] = 0;
            }

            // 清除密码
            unset($user['passwd']);

            $ip = $this->input->ip_address();
            if ( ! $this->user->force_down_line($user['id']) || ! $this->user->update_login_info($user['id'], $ip))
            {
                $ret['m'] = '系统错误';
                break;
            }
            $this->load->model('operate_model', 'operate');
            if ( ! $this->operate->add_login_log($user['id'], $ip))
            {
                $ret['m'] = '系统错误';
                break;
            }
            //将登录信息记录到session
            $this->session->set_userdata('user', $user);
            $ret['r'] = self::STATE_SUCCESS;
        }
        while (false);
        $this->session->unset_userdata('captcha');
        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 自动禁用处理
     * @param $user
     * @param $msg
     */
    private function set_lock($user, &$msg)
    {
        if ($user['level'] == OPERATOR_LEVEL || $user['level'] == AREA_LEVEL)
        {
            if ($user['login_failed_num'] >= 4)
            {
                $msg = '该账号连续5次输入密码错误，已被禁用';
                if ( ! $this->user->set_lock($user['id']))
                {
                    log_message('ERROR', 'SET_LOCK FAILED,ID=' . $user['id']);
                }
            } else {
                $msg = '密码错误次数达5次将锁定，您已错误' . $user['login_failed_num'] . '次';
                if ( ! $this->user->add_fail_num($user['id']))
                {
                    log_message('ERROR', 'ADD_FAIL_NUM FAILED,ID=' . $user['id']);
                }
            }
        }
    }

    /**
     * 账户是否已被锁定
     * @param $user
     * @param $msg
     * @return bool
     */
    private function is_lock($user, &$msg)
    {
        if ($user['level'] == OPERATOR_LEVEL || $user['level'] == AREA_LEVEL)
        {
            if ($user['state'] != User_model::ENABLE && $user['can_login_time'] > 0 && $user['can_login_time'] < time())
            {
                $msg = '该帐号由于24小时内密码错误次数过多已被锁定，请寻找管理人员手动解锁并留意近期登录情况';
                return TRUE;
            }
        }
        return FALSE;
    }
    /**
     * 退出登录
     */
    public function logout()
    {
        $user = $this->session->userdata('user');
        if ($user)
        {
            $this->session->unset_userdata('user');
            $this->session->sess_destroy();
        }
        redirect('/welcome');
    }

    //修改密码
    public function pwdupdate()
    {
        $ret = ['r' => self::STATE_FAIL, 'm' => ''];
        do
        {
            $userInfo = $this->session->userdata('user');
            if (!$userInfo)
            {
                $ret['r'] = self::STATE_REQUIRE_LOG_IN;
                break;
            }
            //验证
            $this->load->library('form_validation');

            $this->form_validation->set_rules('id','id','trim|required|regex_match[/[0-9]+/]');
            $this->form_validation->set_rules('password','原始密码','trim|required|regex_match[/(?!^\[0-9]+$)(?!^[a-zA-Z]+$)(?!^[_#@]+$).{6,20}/]');
            $this->form_validation->set_rules('newpassword','新密码','trim|required|regex_match[/(?!^\[0-9]+$)(?!^[a-zA-Z]+$)(?!^[_#@]+$).{6,20}/]');
            $this->form_validation->set_message('regex_match', '{field}格式不正确');
            $this->form_validation->set_message('required', '{field}不能为空');


            if ( ! $this->form_validation->run())
            {
                $ret['m'] = validation_errors();
                break;
            }

            //获取表单数据
            $id = $this->input->post('id', true);
            $password = $this->input->post('password', true);
            $new_password = $this->input->post('newpassword', true);

            $this->load->model('user_model','user');
            $origin_password = $this->user->get_password_by_id($id);
            if ($origin_password != md5($password))
            {
                $ret['m'] = '原始密码不正确';
                break;
            }
            if ($password == $new_password)
            {
                $ret['m'] = '新密码不能和原密码相同';
                break;
            }
            $pwdStrength = 0;
            if (FALSE === $this->check_pwd($new_password, $pwdStrength, $ret['m']))
            {
                break;
            }
            $this->load->model('agent_model','agent');

            $this->db->trans_start();
            $this->user->set_pwd($id, $new_password);
            $this->agent->set_pwd($id, $new_password, $this->userData['id']);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE)
            {
                $ret['m'] = '修改失败';
                break;
            }
            $ret['r'] = self::STATE_SUCCESS;
        } while(false);
        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    }
}