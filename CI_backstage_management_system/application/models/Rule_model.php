<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rule_model extends MY_Model
{
    public function get_tree_data($type, $order = '', $name = 'name', $child = 'id', $parent = 'pid')
    {
        // 判断是否需要排序
        $query = $this->db;
        if ( ! empty($order))
        {
            $query->order_by($order);
        }
        $data = $query->get(T_RULE)->result_array();
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

    //读取用户组所有权限规则
    public function getRulesByIds($ids, $type)
    {
        $map = array(
            'type'   => $type,
            'status' => 1,
        );
        return $this->db->select('condition,name')
            ->from(T_RULE)
            ->where($map)
            ->where_in('id', $ids)
            ->get()
            ->result_array();
    }


    /**
     * 获取菜单列表
     * @param $order
     * @return mixed
     */

    public function getMenuList($order='order_number asc'){
        $this->db->select('*');
        $this->db->from(T_RULE);
        $this->db->order_by($order);
        $query = $this->db->get();
        return $query->result_array();
    }
}