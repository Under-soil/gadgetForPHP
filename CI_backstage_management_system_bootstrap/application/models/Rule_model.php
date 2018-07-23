<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rule_model extends MY_Model {
    const T_RULE = 't_agent_rule';

    public function getTreeData($type, $order='', $name='name', $child='id', $parent='pid')
    {
        // 判断是否需要排序
        if (empty($order))
        {
            $data = $this->db->from(self::T_RULE)->get()->result_array();
        }
        else
        {
            $data = $this->db->from(self::T_RULE)->order_by($order)->get()->result_array();
        }
        if ('tree' == $type)
        {
            $data = Data::tree($data, $name, $child, $parent);
        }
        else
        {
            $data = Data::channelLevel($data,0,'&nbsp;', $child);
        }
        return $data;
    }

    //读取用户组所有权限规则
    public function getRulesByIds($ids, $type)
    {
        $map = array(
            'type'   => $type,
            'status' => 1,
        );
        return $this->db->select('condition,name')
            ->from(self::T_RULE)
            ->where($map)
            ->where_in('id', $ids)
            ->get()
            ->result_array();
    }

    /**
     * 获取全部权限
     * @param int $pid
     * @return mixed
     */
    public function get_all_by_pid($pid = 0)
    {
        $field = 'id, pid, name, title, order_number, ico';
        return $this->db->select($field)->where(['pid' => $pid])->order_by('order_number asc')->get(self::T_RULE)->result_array();
    }

    /**
     * 获取子项数量
     * @param $pid
     * @return mixed
     */
    public function get_child_num($pid)
    {
        return $this->db->where('pid', $pid)->count_all_results(self::T_RULE);
    }

    /**
     * 更新菜单信息
     * @param $data
     * @param $id
     * @return bool
     */
    public function update_by_id($data, $id)
    {
        if ( ! is_array($data) && count($data))
        {
            return false;
        }
        if (array_key_exists('name', $data))
        {
            $update['name'] = $data['name'];
        }
        if (array_key_exists('title', $data))
        {
            $update['title'] = $data['title'];
        }
        if (array_key_exists('order_number', $data))
        {
            $update['order_number'] = $data['order_number'];
        }
        if (array_key_exists('ico', $data))
        {
            $update['ico'] = $data['ico'];
        }
        return $this->db->update(self::T_RULE, $update, ['id' => $id]);
    }

    /**
     * 根据权限获取权限信息
     * @param $name
     * @return mixed
     */
    public function get_rule_info_by_name($name)
    {
        $field = 'id, pid, name, title';
        return $this->db->select($field)->where(['name' => $name])->get(self::T_RULE)->row_array();
    }

    /**
     * 获取菜单列表
     * @param $order
     * @return mixed
     */

    public function getMenuList($order='order_number asc'){
        $this->db->select('*');
        $this->db->from(self::T_RULE);
        $this->db->order_by($order);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_nav_by_rule($ruleName)
    {
        $field = 'c.title, p.title as p_title';
        $map = ['lower(c.name)' => $ruleName];
        return $this->db->select($field)
            ->from(self::T_RULE . ' as c')
            ->join(self::T_RULE . ' as p', 'c.pid = p.id', 'left')
            ->where($map)
            ->limit(1)
            ->get()
            ->result_array();
    }

}