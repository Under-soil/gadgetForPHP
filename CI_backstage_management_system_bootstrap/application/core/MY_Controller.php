<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
    const STATE_REQUIRE_LOG_IN = 1000;
    const STATE_REQUIRE_ACCESS = 2000;
    const STATE_FAIL = 3000;
    const STATE_SUCCESS = 4000;

    public $menuData;    //菜单数据
    public $userData;    //用户信息
    public $groupData;   //角色信息
    public $navName;     //页面标题
    public $hasRule;     //是否有权限

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
            $this->groupData = $this->group->get_all();
            foreach ($this->groupData as $val)
            {
                if ($val['id'] == $user['level'])
                {
                    $user['groupName'] = $val['title'];
                    $user['type'] = $val['type'];
                    break;
                }
            }
            $this->userData = $user;
            $directory = substr($this->router->fetch_directory(),0,-1); //目录
            $function = $this->router->fetch_method();//方法
            $ruleName = trim(strtolower($directory).'/'.strtolower($controller).'/'.strtolower($function), '/');
            $this->load->library('auth');
            $this->hasRule = TRUE;
            if ( ! $this->auth->check($ruleName, $user['id']))
            {
                if ($this->input->is_ajax_request())
                {
                    $result = ['r' => self::STATE_REQUIRE_ACCESS, 'm' => '暂无权限'];
                    echo json_encode($result, JSON_UNESCAPED_UNICODE);
                    die ;
                }
                $this->hasRule = FALSE;
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
            $navInfo = $this->menu->get_nav_by_rule($ruleName);
            $this->navName = $navInfo ? $navInfo[0]['p_title'] . '&gt;' . $navInfo[0]['title'] : '';
        }
        else
        {
            if ($controller != $this->router->default_controller)
            {
                if ($this->input->is_ajax_request())
                {
                    $result = ['r' => self::STATE_REQUIRE_LOG_IN, 'm' => '请登录'];
                    echo json_encode($result, JSON_UNESCAPED_UNICODE);
                    die ;
                }
                else
                {
                    exit('<script>top.location.href="index.php"</script>');
                }
            }
        }
    }

    protected function check_captcha($captcha)
    {
        $code = $this->session->userdata("captcha");
        if ($captcha != $code)
        {
            return FALSE;
        }
        return TRUE;
    }
}