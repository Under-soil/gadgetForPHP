<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Operate_model extends MY_Model {
    const T_OPERATE = 't_agent_operate_log';
    const T_AGENT = 't_agent';
    const T_LOGIN_LOG = 't_agent_login_log';
    const T_AGENT_USER = 't_agent_user';

    const LOGIN_SUCCESS = 1;
    const LOGIN_FAIL = 0;
    const MAX_ERROR_TIMES = 5;

    //操作日志 变更项目数组
    private $change_item = [
        'realname'     => ['change_item' => 'realname', 'msg' => '真实姓名'],
        'passwd'       => ['change_item' => 'passwd', 'msg' => '密码修改'],
        'phone'        => ['change_item' => 'phone', 'msg' => '手机号'],
        'wechat'       => ['change_item' => 'wechat', 'msg' => '微信号'],
        'appuid'       => ['change_item' => 'appuid', 'msg' => '游戏用户ID'],
        'level'        => ['change_item' => 'level', 'msg' => '推广员级别'],
        'code'         => ['change_item' => 'code', 'msg' => '推荐码'],
        'pcode'        => ['change_item' => 'pcode', 'msg' => '上级推荐码'],
        'state'        => ['change_item' => 'state', 'msg' => '禁用状态'],
        'username'     => ['change_item' => 'username', 'msg' => '用户名'],
        'sms_pwd'      => ['change_item' => 'sms_pwd', 'msg' => '短信重置密码'],
    ];

    /**
     * 获取操作日志 变更项目数组
     * @return array
     */
    public function get_change_item()
    {
        return $this->change_item;
    }

    /**
     * 添加登录信息
     * @param $id
     * @return mixed
     */
    public function update_login_info($id)
    {
        $data = [
            'uid' => $id,
            'login_time' => date('Y-m-d H:i:s'),
            'login_ip' => $this->input->ip_address(),
            'state' => 1,
        ];
        return $this->db->insert(self::T_LOGIN_LOG, $data, ['id' => $id]);
    }

    /**
     * 分页列表
     * @param $page_size
     * @param $offset
     * @param array $where
     * @return mixed
     */
    public function get_by_pages($page_size, $offset, $where = array())
    {
        $field = [
            'o.*',
            'u.level as operate_level',
            'a.level',
            'a.code',
            'a.realname',
        ];
        $this->db->select($field);
        $this->db->from(self::T_OPERATE. ' as o');
        $this->db->join(self::T_AGENT_USER . ' as u', 'o.operate_id = u.id', 'left');
        $this->db->join(self::T_AGENT . ' as a', 'o.agent_uid = a.uid', 'left');
        $this->_where($where);

        $this->db->order_by('o.id desc');
        $this->db->limit($page_size, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }


    /**
     * 获取记录数量
     * @param array $where  筛选条件
     * @return mixed
     */
    public function get_num($where = array())
    {
        $this->db->select('count(o.id) as count');
        $this->db->from(self::T_OPERATE. ' as o');
        $this->db->join(self::T_AGENT_USER . ' as u', 'o.operate_id = u.id', 'left');
        $this->db->join(self::T_AGENT . ' as a', 'o.agent_uid = a.uid', 'left');
        $this->_where($where);
        $query = $this->db->get()->row_array();
        return $query["count"]?$query["count"]:0;
    }

    /**
     * 查询条件
     * @param $where
     */
    private function _where($where)
    {
        if( ! empty($where['change_item']))
        {
            $this->db->where('change_item', $where['change_item']);
        }

        if( ! empty($where['realname']))
        {
            $this->db->where('realname', $where['realname']);
        }

        if( ! empty($where['appuid']))
        {
            $this->db->where('appuid', $where['appuid']);
        }

        if( ! empty($where['code']))
        {
            $this->db->where('code', $where['code']);
        }

        if( ! empty($where['level']))
        {
            $this->db->where('a.level', $where['level']);
        }

    }
}