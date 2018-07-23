<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agent_model extends MY_Model {
    const T_TABLE = 't_agent';
    const T_AGENT_USER = 't_agent_user';
    const DEFAULT_PWD = 'baqi123123';
    const APPLY_STATE_NOT_IN = 0;
    const APPLY_STATE_ON = 1;
    const APPLY_STATE_PASS = 2;
    const APPLY_STATE_FAIL = 3;

    const AGENT_STATE_NORMAL = 1;  //正常
    const AGENT_STATE_FORBID = 2;  //禁止
    const AGENT_STATE_DEL = 3;     //删除
    const AGENT_STATE_CHECK = 4;   //审核

    //根据邀请码获取用户名
    public function get_info_by_code($code)
    {
        $condition = array(
            'code' => $code,
        );

        $query = $this->db->select('uid, username,realname,level,area_code,pcode,code,agent_num,appuid')
            ->from(self::T_TABLE)
            ->where($condition)
            ->get();

        if ($query->num_rows() == 1)
        {
            return $query->row_array();
        }

        return false;
    }

    //获取当前代理用户的下级代理用户信息
    public function get_my_agentuser($map, $value, $offset, $like = '', $order = 'code', $sort = 'asc')
    {
        $field = 'a.uid, a.username, a.realname, a.phone, a.appuid, a.level, a.code, a.pcode, a.balance, a.total, a.member_num, a.agent_num, a.state, a.address, a.wechat, a.apply, a.qq, a.explain, a.explain_time, a.check_time, u.create_time, u.login_time';

        $this->db->select($field);
        $this->db->from(self::T_TABLE . ' as a ');
        $this->db->join(self::T_AGENT_USER . ' as u ', 'a.uid = u.id', 'left');
        $this->_my_agentuser_where($map);
        if ($like)
        {
            $this->db->like('phone', $like, 'both');
        }
        $this->db->limit(min($value, 20), $offset);
        $query = $this->db->order_by($order, $sort)->get();
        return $query->result_array();
    }

    //获取当前代理用户的下级代理用户数量
    public function get_my_agentuser_num($map, $like = '')
    {
        $this->db->select('count(1) as num');
        $this->db->from(self::T_TABLE . ' as a ');
        $this->_my_agentuser_where($map);
        if ($like)
        {
            $this->db->like('phone', $like, 'both');
        }
        $query = $this->db->get();

        return $query->row()->num;
    }

    public function _my_agentuser_where($where)
    {
        if ( ! empty($where['level']))
        {
            $this->db->where('a.level', $where['level']);
        }

        if ( ! empty($where['pcode']))
        {
            $this->db->where('pcode', $where['pcode']);
        }

        if ( ! empty($where['appuid']))
        {
            $this->db->where('appuid', $where['appuid']);
        }

        if ( ! empty($where['code']))
        {
            $this->db->where('code', $where['code']);
        }

        if ( ! empty($where['real_name']))
        {
            $this->db->where('realname', $where['real_name']);
        }

        if ( ! empty($where['apply']))
        {
            $this->db->where_in('apply', $where['apply']);
        }
    }

    //根据uid获取用户信息
    public function get_info_by_uid($uid)
    {
        $query = $this->db->select('realname, code, level, area_code,wechat,phone,balance,pcode,agent_num,apply')
            ->from(self::T_TABLE)
            ->where('uid', $uid)
            ->get();

        if ($query->num_rows() == 1)
        {
            return $query->row_array();
        }
        return false;
    }

    //获取所有用户信息
    public function get_all_user()
    {
        return $this->db->select('uid,code,pcode,agent_num,member_num,area_code')
            ->from(self::T_TABLE)
            ->get()
            ->result_array();
    }

    //获取当前代理所有树形下级代理用户信息
    public function get_follow_agent($map, $codeArr, $value, $offset, $like = '')
    {
        if($like){
            $query = $this->db->select('uid, username, realname, phone, wechat, appuid, level, code,pcode, total, member_num, agent_num, create_time,login_time, state, address')
                ->from(self::T_TABLE)
                ->where($map)
                ->where_in('code', $codeArr)
                ->like('phone', $like, 'both')
                ->limit(min($value, 20), $offset)
                ->order_by('uid', 'DESC')
                ->get();
        }else{
            $query = $this->db->select('uid, username, realname, phone, wechat, appuid, level, code, pcode,total, member_num, agent_num, create_time,login_time, state, address')
                ->from(self::T_TABLE)
                ->where($map)
                ->where_in('code', $codeArr)
                ->limit(min($value, 20), $offset)
                ->order_by('uid', 'DESC')
                ->get();
        }
        return $query->result_array();
    }

    //获取当前代理所有树形下级代理数
    public function get_follow_agent_num($map, $codeArr,$like = '')
    {
        if($like){
            $query = $this->db->select('count(1) as num')
                ->from(self::T_TABLE)
                ->where($map)
                ->where_in('code', $codeArr)
                ->like('phone', $like, 'both')
                ->get();
        }else{
            $query = $this->db->select('count(1) as num')
                ->from(self::T_TABLE)
                ->where($map)
                ->where_in('code', $codeArr)
                ->get();
        }
        return $query->row()->num;
    }

    //更新用户信息
    public function update_user($uid, $data)
    {
        $this->db->set($data);
        $this->db->where('uid', $uid);
        return $this->db->update(self::T_TABLE);
    }

    //更新用户余额
    public function update_money($uid, $amount, $data)
    {
        if($data && is_array($data))
        {
            foreach ($data as $k=>$v)
            {
                $this->db->set($k,$k.$v.$amount,false);
            }

            $this->db->where('uid', $uid);
            return $this->db->update(self::T_TABLE);
        }
        return false;
    }


    /**
     * 根据appuid获取代理信息
     * @param $appuid
     * @return mixed
     */
	public function get_agent_by_appuid($appuid)
    {
        $query = $this->db->select('uid, username')
            ->from(self::T_TABLE)
            ->where('appuid', $appuid)
            ->get();

        return $query->row_array();
    }

    /**
     * 获取信息
     * @param $id
     * @return bool
     */
    public function get_info_by_id($id)
    {
        $field = 'uid,username,realname,phone,wechat,appuid,code,pcode,balance,member_num,agent_num,address,level,total,money_sum_ing,money_sum_frozen';
        $query = $this->db->select($field)->get_where(self::T_TABLE, ['uid' => $id]);
        if ($query->num_rows() == 1)
        {
            return $query->row_array();
        }
        return false;
    }

    /**
     * 获取所有已使用code
     * @param $where
     * @return bool
     */
    public function get_agent_all_code($where){
        $result = $this->db->select('code')
            ->where($where)
            ->get(self::T_TABLE)
            ->result_array();
        if (is_array($result) && count($result))
        {
            return $result;
        }
        return false;
    }

    /**
     * 修改单个字段用户信息
     * @param $where
     * @param $update_key
     * @param $update_value
     * @param $escape
     * @return mixed
     */
    public function update_agent_info($where, $update_key, $update_value, $escape = true)
    {
        $this->db->set($update_key, $update_value, $escape);
        $this->db->where($where);
        return $this->db->update(self::T_TABLE);
    }
}