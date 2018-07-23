<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 权限认证类
 * 功能特性：
 * 1，是对规则进行认证，不是对节点进行认证。用户可以把节点当作规则名称实现对节点进行认证。
 *      $auth=new Auth();  $auth->check('规则名称','用户id')
 * 2，可以同时对多条规则进行认证，并设置多条规则的关系（or或者and）
 *      $auth=new Auth();  $auth->check('规则1,规则2','用户id','and')
 *      第三个参数为and时表示，用户需要同时具有规则1和规则2的权限。 当第三个参数为or时，表示用户值需要具备其中一个条件即可。默认为or
 * 3，一个用户可以属于多个用户组(think_auth_group_access表 定义了用户所属用户组)。我们需要设置每个用户组拥有哪些规则(think_auth_group 定义了用户组权限)
 *
 * 4，支持规则表达式。
 *      在think_auth_rule 表中定义一条规则时，如果type为1， condition字段就可以定义规则表达式。 如定义{score}>5  and {score}<100  表示用户的分数在5-100之间时这条规则才会通过。
 */
class Auth
{
    //默认配置
    protected $_config = array(
        'AUTH_ON'           => true, // 认证开关
        'AUTH_TYPE'         => 1, // 认证方式，1为实时认证；2为登录认证。
    );

    protected $CI;

    public function __construct($authConfig = [])
    {
        $this->CI =& get_instance();
        if ($authConfig)
        {
            //可设置配置项 AUTH_CONFIG, 此配置项为数组。
            $this->_config = array_merge($this->_config, $authConfig);
        }
    }

    /**
     * 检查权限
     * @param string|array $name  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
     * @param int $uid            认证用户的id
     * @param int $type
     * @param string $mode        执行check的模式
     * @param string $relation    如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
     * @return bool               通过验证返回true;失败返回false
     */
    public function check($name, $uid, $type = 1, $mode = 'url', $relation = 'or')
    {
        if ( ! $this->_config['AUTH_ON'])
        {
            return true;
        }
        $authList = $this->getAuthList($uid, $type); //获取用户需要验证的所有有效规则列表

        if (is_string($name))
        {
            $name = strtolower($name);
            if (strpos($name, ',') !== false)
            {
                $name = explode(',', $name);
            }
            else
            {
                $name = array($name);
            }
        }
        $list = array(); //保存验证通过的规则名
        if ('url' == $mode)
        {
            $REQUEST = unserialize(strtolower(serialize($_REQUEST)));
        }
        foreach ($authList as $auth)
        {
            $query = preg_replace('/^.+\?/U', '', $auth);
            if ('url' == $mode && $query != $auth)
            {
                parse_str($query, $param); //解析规则中的param
                $intersect = array_intersect_assoc($REQUEST, $param);
                $auth      = preg_replace('/\?.*$/U', '', $auth);
                if (in_array($auth, $name) && $intersect == $param)
                {
                    //如果节点相符且url参数满足
                    $list[] = $auth;
                }
            }
            elseif (in_array($auth, $name))
            {
                $list[] = $auth;
            }
        }
        if ('or' == $relation and !empty($list))
        {
            return true;
        }
        $diff = array_diff($name, $list);
        if ('and' == $relation and empty($diff))
        {
            return true;
        }
        return false;
    }

    /**
     * 根据用户id获取用户组,返回值为数组
     * @param  $uid int     用户id
     * @return array       用户所属的用户组 array(
     *     array('uid'=>'用户id','group_id'=>'用户组id','title'=>'用户组名称','rules'=>'用户组拥有的规则id,多个,号隔开'),
     *     ...)
     */
    public function getGroups($uid)
    {
        static $groups = array();
        if (isset($groups[$uid]))
        {
            return $groups[$uid];
        }
        $this->CI->load->model('group_model', 'group');
        $user_groups = $this->CI->group->getRulesByUid($uid);
        $groups[$uid] = $user_groups ?: array();
        return $groups[$uid];
    }

    /**
     * 获得权限列表
     * @param integer $uid 用户id
     * @param integer $type
     * @return array|mixed
     */
    protected function getAuthList($uid, $type)
    {
        static $_authList = array(); //保存用户验证通过的权限列表
        $t                = implode(',', (array) $type);
        if (isset($_authList[$uid . $t]))
        {
            return $_authList[$uid . $t];
        }
        if (2 == $this->_config['AUTH_TYPE'] && isset($_SESSION['_AUTH_LIST_' . $uid . $t]))
        {
            return $_SESSION['_AUTH_LIST_' . $uid . $t];
        }

        //读取用户所属用户组
        $groups = $this->getGroups($uid);
        $ids    = array(); //保存用户所属用户组设置的所有权限规则id
        foreach ($groups as $g)
        {
            $ids = array_merge($ids, explode(',', trim($g['rules'], ',')));
        }
        $ids = array_unique($ids);
        if (empty($ids))
        {
            $_authList[$uid . $t] = array();
            return array();
        }

        $this->CI->load->model('rule_model', 'rule');
        //读取用户组所有权限规则
        $rules = $this->CI->rule->getRulesByIds($ids, $type);

        //循环规则，判断结果。
        $authList = array(); //
        foreach ($rules as $rule)
        {
            if ( ! empty($rule['condition']))
            {
                //根据condition进行验证
                $user = $this->getUserInfo($uid); //获取用户信息,一维数组

                $command = preg_replace('/\{(\w*?)\}/', '$user[\'\\1\']', $rule['condition']);
                //dump($command);//debug
                @(eval('$condition=(' . $command . ');'));
                if ($condition)
                {
                    $authList[] = strtolower($rule['name']);
                }
            }
            else
            {
                //只要存在就记录
                $authList[] = strtolower($rule['name']);
            }
        }
        $_authList[$uid . $t] = $authList;
        if (2 == $this->_config['AUTH_TYPE'])
        {
            //规则列表结果保存到session
            $_SESSION['_AUTH_LIST_' . $uid . $t] = $authList;
        }
        return array_unique($authList);
    }

    /**
     * 获得用户资料,根据自己的情况读取数据库
     */
    protected function getUserInfo($uid)
    {
        static $userinfo = array();
        if ( ! isset($userinfo[$uid]))
        {
            $this->CI->load->model('user_model', 'user');
            $userinfo[$uid] = $this->CI->user->getUserInfo($uid);
        }
        return $userinfo[$uid];
    }

    /**
     * @param $list
     * @param string $pk
     * @param string $pid
     * @param string $child
     * @param int $root
     * @return array
     * @author : storm
     */

    public function list_to_tree( $list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0 ){
        // 创建Tree
        $tree = array ();
        if ( is_array ( $list ) ) {

            // 创建基于主键的数组引用
            $refer = array ();
            foreach ( $list as $key => $data ) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ( $list as $key => $data ) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ( $root == $parentId ) {
                    $tree[] =& $list[$key];
                } else {
                    if ( isset( $refer[$parentId] ) ) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }

}