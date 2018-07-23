<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends My_Controller {
    public function __construct()
    {
        parent::__construct(FALSE);
    }
    /**
     * 登录界面
     */
    public function index()
    {
        $this->load->view('login/index');
    }

    /**
     * 设置并获取需要的rules
     * @param array $keys
     * @return array
     */
    private function validation_rule($keys = [])
    {
        $ret_arr = [
            'id' => [
                'field' => 'id',
                'label' => 'id',
                'rules' => 'trim|required|regex_match[/[0-9]+/]',
                'errors' => ['regex_match' => '{field}格式不正确', 'required' => '{field}不能为空']
            ],
            'captcha'=> [
                'field' => 'captcha',
                'label' => '验证码',
                'rules' => 'trim|required|regex_match[/^[0-9]{4}$/]',
                'errors' => ['regex_match' => '{field}格式不正确', 'required' => '{field}不能为空']
            ],
            'username' => [
                'field' => 'username',
                'label' => '用户名',
                'rules' => 'trim|required|max_length[20]',
                'errors' => ['regex_match' => '{field}格式不正确', 'required' => '{field}不能为空']
            ],
            'password' => [
                'field' => 'password',
                'label' => '密码',
                'rules' => 'trim|required|regex_match[/(?!^\[0-9]+$)(?!^[a-zA-Z]+$)(?!^[_#@]+$).{6,20}/]',
                'errors' => ['regex_match' => '{field}格式不正确', 'required' => '{field}不能为空']
            ],
            'newpassword' => [
                'field' => 'newpassword',
                'label' => '新密码',
                'rules' => 'trim|required|regex_match[/(?!^\[0-9]+$)(?!^[a-zA-Z]+$)(?!^[_#@]+$).{6,20}/]',
            'errors' => ['regex_match' => '{field}格式不正确', 'required' => '{field}不能为空']
            ]
        ];
        if ( is_array($keys) && count($keys))
        {
            foreach ($keys as $key)
            {
                if (array_key_exists($key, $ret_arr))
                {
                    $data[$key] = $ret_arr[$key];
                }
            }
        }
        else
        {
            $data = $ret_arr;
        }
        return $data;
    }

    /**
     * 用户登录处理
     */
    public function ajax_login()
    {
        $ret = null;
        do
        {
            $this->load->library('form_validation');
            $rules = $this->validation_rule(['captcha', 'username', 'password']);
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() === FALSE)
            {
                $ret = ['r' => 2, 'm' => validation_errors()];
                break;
            }
            //获取表单数据
            $captcha = strtolower($this->input->post('captcha'));
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            if ($this->check_captcha($captcha) === FALSE)
            {
                $ret= array('r'=>3, 'm'=>'验证码不正确');
                break;
            }
            $this->load->model('user_model', 'user');
            $user = $this->user->get_by_username($username);
            if ( ! $user)
            {
                $ret = array('r' => 4, 'm' => '用户不存在');
                break;
            }
            $pi_key =  openssl_pkey_get_private(file_get_contents($this->config->item('rsa_private_key_path')));//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
            openssl_private_decrypt(base64_decode($password),$str1,$pi_key);//私钥解密
            if (md5($str1) != $user['passwd'])
            {
                $msg = '密码错误';
                $ret = array('r' => 6, 'm' => $msg);
                break;
            }
            if (User_model::ENABLE != $user['state'])
            {
                $ret = array('r'=> 6, 'm'=>'该用户已被禁用');
                break;
            }
            $this->load->model('group_model', 'group');
            $groupInfo = $this->group->get_by_id($user['level']);
            if (Group_model::DISABLED == $groupInfo['status'])
            {
                $ret = array('r'=> 5, 'm'=>'该用户所在用户组已被禁用');
                break;
            }
            $user['type'] = $groupInfo['type'];
            // 清除密码
            unset($user['passwd']);
            if (AGENT_TYPE != $groupInfo['type'])
            {
                $ret = array('r'=> 5, 'm'=>'请使用推广员账号登录');
                break;
            }

            $this->load->model('agent_model', 'agent');
            $agent_info = $this->agent->get_info_by_uid($user['id']);
            if (false == $agent_info)
            {
                $ret = array('r'=> 5, 'm'=>'用户信息错误');
                break;
            }
            if ( ! (Agent_model::APPLY_STATE_NOT_IN == $agent_info['apply'] || Agent_model::APPLY_STATE_PASS == $agent_info['apply']))
            {
                $ret = array('r'=> 5, 'm'=>'用户信息审核中');
                break;
            }
            $user['code'] = $agent_info['code'];
            $user['pcode'] = $agent_info['pcode'];

            if ($this->user->update_login_info($user['id']) === FALSE)
            {
                log_message('ERROR', '用户：' . $user['id'] . '更新登录信息失败');
                $ret = array('r'=> 6, 'm'=>'数据更新失败');
                break;
            }
            if ( ! $this->user->del_session_file($user['id']))
            {
                $ret = array('r'=> 8, 'm'=>'系统错误');
                break;
            }
            $this->load->model('operate_model', 'operate');
            if ( ! $this->operate->update_login_info($user['id']))
            {
                $ret = array('r'=> 8, 'm'=>'系统错误');
                break;
            }
            //将登录信息记录到session
            $this->session->set_userdata('user', $user);
            $ret = array('r'=> 0);
        } while (false);
        $this->session->unset_userdata('captcha');
        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 管理员登录处理
     */
    public function manager_ajax_login()
    {
        $ret = null;
        do
        {
            $result = ['r' => self::STATE_FAIL, 'm' => ''];

            $this->load->library('redisoperate');
            $this->load->library('form_validation');
            $rules = $this->validation_rule(['captcha', 'username']);
            $this->form_validation->set_rules($rules);

            if ($this->form_validation->run() === FALSE)
            {
                $result['m'] = validation_errors();
                break;
            }

            $redis_msg = $this->redisoperate->connect();

            if ( ! $redis_msg['r'])
            {
                $result['m'] = '系统开了小差，请联系管理员';
                break;
            }
            $redis = $this->redisoperate->redis;

            //获取表单数据
            $captcha = strtolower($this->input->post('captcha'));
            $username = $this->input->post('username', TRUE);
            $code = $this->input->post('code', TRUE);
            $redis_code = (int)$this->redisoperate->manager_login_code($redis, $username);

            if ($captcha != $this->session->userdata("manager_captcha"))
            {
                $result['m'] = '验证码不正确';
                break;
            }

            $this->load->model('user_model', 'user');
            $user = $this->user->get_by_username($username);
            if ( ! $user)
            {
                $result['m'] = '用户不存在';
                break;
            }

            $pi_key =  openssl_pkey_get_private(file_get_contents($this->config->item('rsa_private_key_path')));//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
            openssl_private_decrypt(base64_decode($code),$str1,$pi_key);//私钥解密

            if ($str1 && (int)$str1 !== (int)$redis_code)
            {
                $result['m'] = '手机验证码错误';
                break;
            }

            if (User_model::ENABLE != $user['state'])
            {
                $result['m'] = '该用户已被禁用';
                break;
            }
            $this->load->model('group_model', 'group');
            $groupInfo = $this->group->get_by_id($user['level']);
            if (Group_model::DISABLED == $groupInfo['status'])
            {
                $result['m'] = '该用户所在用户组已被禁用';
                break;
            }
            $user['type'] = $groupInfo['type'];

            if (AGENT_TYPE == $groupInfo['type'])
            {
                $result['m'] = '请使用管理员账号登录';
                break;
            }
            if ($this->user->update_login_info($user['id']) === FALSE)
            {
                log_message('ERROR', '用户：' . $user['id'] . '更新登录信息失败');
                $result['m'] = '数据更新失败';
                break;
            }
            if ( ! $this->user->del_session_file($user['id']))
            {
                $result['m'] = '系统错误';
                break;
            }
            $this->load->model('operate_model', 'operate');
            if ( ! $this->operate->update_login_info($user['id']))
            {
                $result['m'] = '系统错误';
                break;
            }
            $result = ['r' => self::STATE_SUCCESS, 'm' => ''];
            //将登录信息记录到session
            $this->session->set_userdata('user', $user);
        } while (false);
        $this->session->unset_userdata('captcha');
        //清除验证码
        $this->redisoperate->del_manager_login_code($redis, $username);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
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

    /**
     * 修改密码
     */
    public function pwdupdate()
    {
        $ret = null;
        do
        {
            $userInfo = $this->session->userdata('user');
            if ( ! $userInfo)
            {
                $ret = array('r'=> self::STATE_REQUIRE_LOG_IN, 'm' => '请登录');
                break;
            }
            //验证
            $this->load->library('form_validation');
            $this->form_validation->set_rules($this->validation_rule(['id', 'password', 'newpassword']));
            if ($this->form_validation->run() === FALSE)
            {
                $ret = ['r' => 1, 'm' => validation_errors()];
                break;
            }
            //获取表单数据
            $id = $this->input->post('id', TRUE);
            $password = $this->input->post('password', TRUE);
            $new_password = $this->input->post('newpassword', TRUE);

            $this->load->model('user_model','user');
            $passwd = $this->user->get_pwd_by_id($id);
            if ($passwd != md5($password))
            {
                $ret = array('r'=> 3, 'm'=>'原始密码不正确');
                break;
            }
            if ($password == $new_password)
            {
                $ret = array('r'=> 3, 'm'=>'新密码不能和原密码相同');
                break;
            }
            $this->load->helper('common');
            $pwd_strength = check_strength($new_password);
            if ($pwd_strength < 2)
            {
                $ret = array('r'=> 4, 'm'=>'密码过于简单');
                break;
            }
            if ( ! $this->user->update_pwd($id, $new_password, $pwd_strength))
            {
                $ret = array('r'=> 2, 'm' => '修改失败');
                break;
            }
            if (AGENT_TYPE == $userInfo['type'])
            {
                //往操作记录表添加记录
                $this->load->model('operate_model');
                $this->operate_model->add_data(Operate_model::T_OPERATE, [
                    'change_item' => 'passwd',
                    'original_content' => $passwd,
                    'new_content' => md5($new_password),
                    'agent_uid' => $userInfo['id'],
                    'operate_id' => $userInfo['id'],
                    'create_time' => date('Y-m-d H:i:s')
                ]);
            }
            $ret = array('r'=> 0);
        } while(false);
        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 重设密码页面
     */
    public function password_find()
    {
        $this->load->view('login/password_find');
    }

    /**
     * 管理员登录发送验证码
     */
    public function manager_send_code(){
        $result = ['r' => self::STATE_FAIL, 'm' => ''];
        do {
            $this->load->model('agent_model', 'agent');
            $this->load->model('group_model', 'group');
            $this->load->model('user_model', 'user');
            $this->load->helper('common');
            $this->load->library('redisoperate');
            $this->load->library('Sms', 'sms');

            $redis_msg = $this->redisoperate->connect();

            $phone = $this->input->post("phone");
            $captcha = $this->input->post("captcha");

            if ( ! $redis_msg['r'])
            {
                $result['m'] = '发送短信失败，请联系管理员';
                break;
            }

            if( ! preg_match('/^1[34578]\d{9}$/', $phone))
            {
                $result['m'] = '手机号格式错误';
                break;
            }

            if ( ! $this->agent->is_exists(Agent_model::T_AGENT_USER, 'username',  $phone))
            {
                $result['m'] = '该手机号尚未注册';
                break;
            }

            if ($captcha != $this->session->userdata("manager_captcha"))
            {
                $result['m'] = '图片验证码不正确';
                break;
            }

            $user = $this->user->get_by_username($phone);
            $groupInfo = $this->group->get_by_id($user['level']);

            if (AGENT_TYPE == $groupInfo['type'])
            {
                $result['m'] = '请使用管理员账号登录';
                break;
            }

            $redis = $this->redisoperate->redis;
//            $code = rand_code(6);
            $code = '111111';

            //判断是否在一分钟内发送
            if ($this->redisoperate->manager_login_time_code($redis, $phone))
            {
                $result['m'] = '短信发送过于频繁，请稍候重试';
                break;
            }
            //保存
            $this->redisoperate->set_manager_login_code($redis, $phone, $code);
            //发送
            if ($this->sms->send_sms('code', $phone, $code))
            {
                $result = ['r' => self::STATE_SUCCESS, 'm' => '验证码发送成功，请注意查收'];
                break;
            }
            else
            {
                $result['m'] = '发送短信失败，请联系管理员';
                break;
            }
        }while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 发送验证码
     */
    public function send_code()
    {
        $result = ['r' => self::STATE_FAIL, 'm' => ''];
        do {
            $this->load->model('agent_model', 'agent');
            $this->load->helper('common');
            $this->load->library('redisoperate');
            $this->load->library('Sms', 'sms');

            $redis_msg = $this->redisoperate->connect();

            $phone = $this->input->post("phone");
            $captcha = $this->input->post("captcha");

            if ( ! $redis_msg['r'])
            {
                $result['m'] = '发送短信失败，请联系管理员';
                break;
            }

            if( ! preg_match('/^1[34578]\d{9}$/', $phone))
            {
                $result['m'] = '手机号格式错误';
                break;
            }

            if ( ! $this->agent->is_exists(Agent_model::T_AGENT_USER, 'username',  $phone))
            {
                $result['m'] = '该手机号尚未注册';
                break;
            }

            if ($captcha != $this->session->userdata("find_pwd_captcha"))
            {
                $result['m'] = '图片验证码不正确';
                break;
            }

            $redis = $this->redisoperate->redis;
            $code = rand_code(6);
            $code_time = '';

            //判断是否在一分钟内发送
            if ($this->redisoperate->password_find_time_code($redis, $phone))
            {
                $result['m'] = '短信发送过于频繁，请稍候重试';
                break;
            }
            //保存
            $this->redisoperate->set_password_find_code($redis, $phone, $code);
            //发送
            if ($this->sms->send_sms('code', $phone, $code))
            {
                $result = ['r' => self::STATE_SUCCESS, 'm' => '验证码发送成功，请注意查收'];
                break;
            }
            else
            {
                $result['m'] = '发送短信失败，请联系管理员';
                break;
            }
        }while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 设置密码
     */
    public function set_password()
    {
        $result = ['r' => self::STATE_FAIL, 'm' => '修改失败'];
        do
        {
            $this->load->library('form_validation');
            $this->load->library('redisoperate');
            $this->load->helper('common');
            $this->load->model('user_model','user');

            $conn = $this->redisoperate->connect();
            if (FALSE === $conn['r'])
            {
                $result['m'] = '系统开了小差，请联系管理员';
                break;
            }
            $redis = $this->redisoperate->redis;

            $this->form_validation->set_rules('phone', '手机号', [
                'trim',
                'required',
                'regex_match[/^1[34578]\d{9}$/]'
            ]);
            $this->form_validation->set_rules('code', '验证码', [
                'trim',
                'required',
                'regex_match[/^\d{6}$/]'
            ]);
            $this->form_validation->set_rules('password', '密码', [
                'trim',
                'required',
                'regex_match[/(?!^\[0-9]+$)(?!^[a-zA-Z]+$)(?!^[_]+$).{6,12}/]'
            ]);
            $this->form_validation->set_rules('repeat_password', '重复密码', [
                'trim',
                'required',
                'matches[password]',
            ]);

            if ( ! $this->form_validation->run())
            {
                $result['m'] = '信息输入有误，请确认后重试';
                break;
            }
            $phone    = $this->input->post('phone', true);
            $code     = $this->input->post('code', true);
            $password = $this->input->post('password', true);
            $user_info = $this->user->get_by_username($phone);
            $redis_code = (int)$this->redisoperate->password_find_code($redis, $phone);

            if ( ! $redis_code)
            {
                $result['m'] = '请先获取验证码';
                break;
            }

            //判断code
            if ((int)$code === $redis_code)
            {
                if (is_array($user_info) && count($user_info))
                {
                    //设置密码
                    $pwd_strength = check_strength($password);
                    if ($pwd_strength < 2)
                    {
                        $result['m'] = '密码过于简单';
                        break;
                    }
                    if ( ! $this->user->update_pwd($user_info['id'], $password, $pwd_strength))
                    {
                        break;
                    }
                    //往操作记录表添加记录
                    if (in_array($user_info['level'], [ONE_AGENT, TWO_AGENT, THREE_AGENT]))
                    {
                        $this->load->model('operate_model');
                        $this->operate_model->add_data(Operate_model::T_OPERATE, [
                            'change_item' => 'sms_pwd',
                            'original_content' => $user_info['passwd'],
                            'new_content' => md5($password),
                            'agent_uid' => $user_info['id'],
                            'operate_id' => $user_info['id'],
                            'create_time' => date('Y-m-d H:i:s')
                        ]);
                    }
                    $result = ['r' => self::STATE_SUCCESS, 'm' => '修改成功'];
                    //清除验证码
                    $this->redisoperate->del_password_find_code($redis, $phone);
                }
                else
                {
                    $result['m'] = '查无此人，请确认后重试';
                    break;
                }

            }
            else
            {
                $result['m'] = '验证码错误，请重新获取';
                //清除验证码
                $this->redisoperate->del_password_find_code($redis, $phone);
                break;
            }

        }while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}