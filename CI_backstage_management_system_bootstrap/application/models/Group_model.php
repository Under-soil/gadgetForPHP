<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_model extends MY_Model {
    const T_GROUP = 't_agent_group';
    const T_USER = 't_agent_user';
    const DISABLED = 0;
    const ENABLE = 1;

    public function getRulesByUid($uid)
    {
        return $this->db->select('u.id,g.id,title,rules,g.desc')
            ->from(self::T_GROUP . ' as g')
            ->join(self::T_USER . ' as u', 'u.level = g.id', 'left')
            ->where(['u.id' => $uid, 'g.status' => 1])
            ->get()
            ->result_array();
    }

    public function getTreeData($type, $order='', $name='name', $child='id', $parent='pid')
    {
        // 判断是否需要排序
        if (empty($order))
        {
            $data = $this->db->from(Rule_model::T_RULE)->get()->result_array();
        }
        else
        {
            $data = $this->db->from(Rule_model::T_RULE)->order_by($order)->get()->result_array();
        }
        if ('tree' == $type)
        {
            $data = Data::tree($data, $name, $child, $parent);
        }
        else
        {
            $data = Data::channelLevel($data,0,'&nbsp;',$child);
        }
        return $data;
    }

    /**
     * 获取所有角色信息
     * @return mixed
     */
    public function get_all()
    {
        $field = 'id, type, title';
        return $this->db->select($field)->get(self::T_GROUP)->result_array();
    }

    /**
     * 根据ID获取指定角色信息
     * @param $id
     * @return mixed
     */
    public function get_by_id($id)
    {
        $field = 'id,type,title,status,rules';
        return $this->db->select($field)->where(['id' => $id])->get(self::T_GROUP)->row_array();
    }

    /**
     * 根据类型获取制定信息
     * @param $type
     * @return mixed
     *
     */
    public function get_by_type($type)
    {
        $field = 'id,title';
        return $this->db->select($field)->where(['type' => $type,'status'=>1])->get(self::T_GROUP)->result_array();
    }

    /**
     * 获取推广员种类
     * @param int $status
     * @return mixed
     */
    public function get_agent_type($status = 1)
    {
        $field = 'id,title';
        return $this->db->select($field)->where(['type' => AGENT_TYPE, 'status' => $status])->get(self::T_GROUP)->result_array();
    }

    /**
     * 获取分页数据
     * @param $page_size
     * @param $offset
     * @return mixed
     */
    public function get_by_pages($page_size, $offset)
    {
        $field = 'id,type,title,desc,status,commission, commissionx,commissionthree,cumulative_coins';
        return $this->db->select($field)->get(self::T_GROUP, $page_size, $offset)->result_array();
    }

    /**
     * 更新角色名
     * @param $id
     * @param $param
     * @return bool
     */
    public function update_by_id($id, $param)
    {
        if ( ! $id || ! $this->check_need_keys(['title'], $param))
        {
            return false;
        }
        if (array_key_exists('title', $param))
        {
            $data['title'] = $param['title'];
        }
        if (array_key_exists('commission', $param))
        {
            $data['commission'] = $param['commission'];
        }
        if (array_key_exists('commissionx', $param))
        {
            $data['commissionx'] = $param['commissionx'];
        }

        if (array_key_exists('commissionthree', $param))
        {
            $data['commissionthree'] = $param['commissionthree'];
        }

        if (array_key_exists('cumulative_coins', $param))
        {
            $data['cumulative_coins'] = $param['cumulative_coins'];
        }
        return $this->db->update(self::T_GROUP, $data, ['id' => $id]);
    }

    /**
     * 修改指定用户权限
     * @param $id
     * @param $rules
     * @return mixed
     */
    public function save_rules_by_id($id, $rules)
    {
        return $this->db->update(self::T_GROUP, ['rules' => $rules], ['id' => $id]);
    }

    /**
     * 分页获取系统用户信息
     * @param $page_size
     * @param $offset
     * @return mixed
     */
    public function get_manage_user($page_size, $offset)
    {
        $field = 'a.id, username, level, state';
        $map = ['type' => 0];
        return $this->db->select($field)
            ->from(self::T_USER. ' as a')
            ->join(self::T_GROUP . ' as g', 'a.level = g.id', 'left')
            ->where($map)
            ->limit($page_size, $offset)
            ->get()
            ->result_array();
    }

    /**
     * 获取系统用户数量
     * @return mixed
     */
    public function get_manage_user_num()
    {
        $map = ['type' => 0];
        return $this->db->select('count(1) as num')
            ->from(self::T_USER. ' as a')
            ->join(self::T_GROUP . ' as g', 'a.level = g.id', 'left')
            ->where($map)
            ->get()
            ->row()
            ->num;
    }

    /**
     * 获取角色列表
     * @param array $map
     * @return array  array['id' => 'title',....]
     */
    public function get_group($map = array()){
        $tmp = $this->db->select('id, title')->where($map)->get(self::T_GROUP)->result_array();
        $result = array_combine(array_column($tmp, 'id'), array_column($tmp, 'title'));
        return $result;
    }

    /**
     * @return mixed
     * 获取最大返利比例
     */
    public function get_max_commission()
    {
        $field = 'MAX(commission)as max_one, MAX(commissionx) as max_two, MAX(commissionthree) as max_three';
        return $this->db->select($field)
            ->from(self::T_GROUP)
            ->get()
            ->row_array();

    }

    /**
     * @param $id
     * @return mixed
     * 获取当前等级和下一等级
     */
    public function get_level_data($id)
    {
        $field = 'title,desc,commission, commissionx,commissionthree,cumulative_coins';
        $data["this_level"] = $this->db->select($field)
            ->from(self::T_GROUP)
            ->where("status",1)
            ->where("id",$id)
            ->get()
            ->row_array();
        $cumulative_coins = $data["this_level"]["cumulative_coins"];
        $data["next_level"] = $this->db->select($field)
            ->from(self::T_GROUP)
            ->where("cumulative_coins >",$cumulative_coins)
            ->where("status",1)
            ->order_by('cumulative_coins asc')
            ->limit(1, 0)
            ->get()
            ->row_array();

        return $data;

    }
}