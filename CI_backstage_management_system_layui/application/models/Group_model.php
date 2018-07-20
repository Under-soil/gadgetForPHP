<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_model extends MY_Model {
    const DISABLED = 0;
    const ENABLE = 1;

    /**
     * 获取角色信息
     * @param $id
     * @return bool
     */
    public function get_by_id($id)
    {
        $field = 'id,title,status,type';
        $query = $this->db->select($field)->get_where(T_GROUP, ['id' => $id]);
        if (1 != $query->num_rows())
        {
            return FALSE;
        }
        return $query->row_array();
    }

    /**
     * 分页获取分组数据
     * @param $offset
     * @param $page_size
     * @return mixed
     */
    public function get_page_data($offset, $page_size)
    {
        $field = 'id,type,status,title';
        return $this->db->select($field)->offset($offset)->limit($page_size)->order_by('id')->get(T_GROUP)->result_array();
    }

    /**
     * 获取角色记录数
     * @return mixed
     */
    public function get_num()
    {
        return $this->db->count_all_results(T_GROUP);
    }

    public function get_agent_level($has_area = FALSE)
    {
        $map = [
            'type' => AGENT_TYPE, 'status' => self::ENABLE
        ];
        if (FALSE === $has_area)
        {
            $map['id<>'] = AREA_LEVEL;
        }
        return $this->db->select('id, title')->get_where(T_GROUP, $map)->result_array();
    }

    /**
     * 新增角色
     * @param $group_name
     * @return mixed
     */
    public function add($group_name)
    {
        $this->db->set('title', $group_name)->insert(T_GROUP);
        return $this->db->insert_id('title');
    }

    /**
     * 编辑角色名
     * @param $id
     * @param $group_name
     * @return mixed
     */
    public function save($id, $group_name)
    {
        return $this->db->update(T_GROUP, ['title' => $group_name], ['id' => $id]);
    }

    /**
     * 分配权限
     * @param $id
     * @param $data
     * @return mixed
     */
    public function save_rules($id, $data)
    {
        return $this->db->update(T_GROUP, $data, ['id' => $id]);
    }

    /**
     * 根据角色ID获取权限
     * @param $id
     * @return bool
     */
    public function get_rule_by_id($id)
    {
        $query = $this->db->select('id,title,rules')->get_where(T_GROUP, ['id' => $id]);
        if (1 != $query->num_rows())
        {
            return FALSE;
        }
        return $query->row_array();
    }

    /**
     * 获取权限树形结构
     * @param $type
     * @param string $order
     * @param string $name
     * @param string $child
     * @param string $parent
     * @return array
     */
    public function get_tree_data($type, $order = '', $name = 'name', $child = 'id', $parent = 'pid')
    {
        // 判断是否需要排序
        if (empty($order))
        {
            $data = $this->db->from(T_RULE)->get()->result_array();
        }else{
            $data = $this->db->from(T_RULE)->order_by($order)->get()->result_array();
        }
        if ('tree' == $type)
        {
            $data = Data::tree($data, $name, $child, $parent);
        } else {
            $data = Data::channelLevel($data, 0, '&nbsp;', $child);
        }
        return $data;
    }

    public function getRulesByUid($uid)
    {
        return $this->db->select('u.id,g.id,title,rules')
            ->from(T_GROUP . ' as g')
            ->join(T_USER . ' as u', 'u.level = g.id', 'left')
            ->where(['u.id' => $uid, 'g.status' => 1])
            ->get()
            ->result_array();
    }
}