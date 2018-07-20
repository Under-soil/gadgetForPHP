<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
    const STATE_REQUIRE_LOG_IN = 1000;  //未登录
    const STATE_REQUIRE_ACCESS = 2000;  //暂无权限
    const STATE_FAIL = 3000;              //失败
    const STATE_SUCCESS = 4000;           //成功

    const DISABLED = 0;
    const ENABLE = 1;

    public $menuData;
    public $userData;
    public $groupData;
    public $navName;
    public $hasRule;

    public function __construct($auth = TRUE)
    {
        parent::__construct();
        if ($auth)
        {
            $this->auth();
        }
    }

    private function auth()
    {
        $controller = $this->router->fetch_class();
        $user = $this->session->userdata('user');
        if ($user)
        { 
            $this->load->model('group_model','group');
            $this->groupData = $this->group->getAll(T_GROUP, [], 'id, type, title');

            foreach ($this->groupData as $val)
            {
                if ($val['id'] == $user['level'])
                {
                    $user['groupName'] = $val['title'];
                    $user['type'] = $val['type'];
                }
            }
            $this->userData = $user;

            //目录
            $directory = substr($this->router->fetch_directory(),0,-1);
            //控制器
            $controller = $this->router->fetch_class();
            //方法
            $function = $this->router->fetch_method();
            $ruleName = trim(strtolower($directory).'/'.strtolower($controller).'/'.strtolower($function), '/');
            $this->load->library('auth');
            $this->hasRule = true;
            if (!$this->auth->check($ruleName, $user['id']) && $controller!='welcome')
            {
                if ($this->input->is_ajax_request())
                {
                    $result = ['r' => self::STATE_REQUIRE_ACCESS, 'm' => '暂无权限'];
                    echo json_encode($result, JSON_UNESCAPED_UNICODE);
                    die ;
                }
                $this->hasRule = false;
            }
            $this->load->model('rule_model', 'menu');
            $menuList = $this->menu->getMenuList();
            $menu = [];
            foreach ( $menuList as $key=>$value ) {
                if ($res = $this->auth->check ( $value['name'], $user['id'] ) ) {
                    $menu[] = $value;
                }
            }
            $this->menuData = $this->auth->list_to_tree ($menu);
        } else {
            if ($controller != $this->router->default_controller)
            {
                if ($this->input->is_ajax_request())
                {
                    $result = ['r' => self::STATE_REQUIRE_LOG_IN, 'm' => '请登录'];
                    echo json_encode($result, JSON_UNESCAPED_UNICODE);
                    die ;
                } else {
                    exit('<script>top.location.href="index.php"</script>');
                }
            }
        }

    }

    /**
     * 表单组合验证
     * @param $data
     * @param $rules
     * @param $error
     * @return bool
     */
    protected function form_validation_combine($data, $rules, &$error)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_data($data);
        foreach ($rules as $rule)
        {
            if ( ! $this->form_validation->run($rule))
            {
                $error = validation_errors();
                return FALSE;
            }
            $this->form_validation->reset_validation();
        }
        return TRUE;
    }

    /**
     * 检查密码强度
     * @param $pwd
     * @param $pwd_strength
     * @param $msg
     * @return bool
     */
    protected function check_pwd($pwd, &$pwd_strength, &$msg)
    {
        $this->load->helper('common');
        $pwd_strength = check_strength($pwd);
        if ($pwd_strength < 2)
        {
            $msg = '密码过于简单';
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 比较密码
     * @param $password
     * @param $origin_pwd
     * @return bool
     */
    protected function check_ssl_pwd($password, $origin_pwd)
    {
        $pi_key =  openssl_pkey_get_private(file_get_contents($this->config->item('rsa_private_key_path')));//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
        openssl_private_decrypt(base64_decode($password), $str1, $pi_key);//私钥解密
        if(md5($str1) != $origin_pwd)
        {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 角色是否被禁用
     * @param $group
     * @param $id
     * @return bool
     */
    protected function is_group_lock(&$group, $id)
    {
        $group = $this->group->get_by_id($id);
        if ( ! $group)
        {
            return TRUE;
        }
        if (self::DISABLED  == $group['status'])
        {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * 获取下级推广级别
     * @param $level
     * @return mixed
     */
    protected function get_follow_level($level)
    {
        $map = ['type' => AGENT_TYPE, 'status' => Group_model::ENABLE];
        if (AGENT_TYPE == $this->userData['type'])
        {
            $map['id !='] = AREA_LEVEL;
            switch ($level)
            {
                case ONE_AGENT:
                    $map['id <='] = THREE_AGENT;
                    $map['id >='] = TWO_AGENT;
                    break;
                case TWO_AGENT:
                    $map['id'] = THREE_AGENT;
                    break;
                case THREE_AGENT:
                    $map['id'] = null;
                    break;
                default;
            }
        }
        $this->load->model('group_model','group');
        return $this->group->getAll(T_GROUP, $map, 'id, title');
    }

    /**
     * 敏感信息脱敏处理
     * @param $data
     */
    protected function information_desensitization(&$data)
    {
        if ($data && is_array($data))
        {
            foreach ($data as $key => &$val)
            {
                if (array_key_exists('wechat', $val))
                {
                    $val['wechat'] = substr_replace($val['wechat'],'***', -3, 3);
                }
                if (array_key_exists('phone', $val))
                {
                    $val['phone'] = substr_replace($val['phone'],'****', 3, 4);
                }
            }
        }
    }
}