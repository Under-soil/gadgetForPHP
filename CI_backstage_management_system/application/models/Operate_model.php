<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Operate_model extends MY_Model
{
    const LOGIN_SUCCESS = 1;
    const LOGIN_FAIL = 0;
    const MAX_ERROR_TIMES = 5;

    public function logNum($agentWhere, $map)
    {
        $query = $whereStr = $where = '';
        if ($agentWhere && is_array($agentWhere) && count($agentWhere) > 0) {
            $query = ' agent_code in (select code from '.T_AGENT.' where '.implode(' and ', $agentWhere).') ';
        }
        if ($map && is_array($map) && count($map) > 0)
        {
            $where = implode(' and ', $map);
        }
        if ($query && $where)
        {
            $whereStr = ' where '.$query.' and '.$where;
        } elseif(!$query && !$where) {

        } else {
            $whereStr = ' where '.$query.$where;
        }
        $query = 'select count(1) as num from '.T_AGENT_OPERATE_LOG.$whereStr;
        return $this->db->query($query)->row()->num;
    }

    public function getLog($value, $offset, $agentWhere, $map)
    {
        $query = $whereStr = $where = '';
        if ($agentWhere && is_array($agentWhere) && count($agentWhere) > 0) {
            $query = ' agent_code in (select code from '.T_AGENT.' where '.implode(' and ', $agentWhere).') ';
        }
        if ($map && is_array($map) && count($map) > 0)
        {
            $where = implode(' and ', $map);
        }
        if ($query && $where)
        {
            $whereStr = ' where '.$query.' and '.$where;
        } elseif(!$query && !$where) {

        } else {
            $whereStr = ' where '.$query.$where;
        }
        $field = ' change_item,original_content,new_content,agent_code,operate_code,create_time ';
        $query = 'select '.$field.' from '.T_AGENT_OPERATE_LOG.$whereStr.' order by create_time desc, agent_code asc limit '.$offset.', '.$value;
        return $this->db->query($query)->result_array();
    }

    /**
     * @param $id
     * @param $ip
     * @return mixed
     */
    public function add_login_log($id, $ip)
    {
        $data = [
            'uid' => $id,
            'login_time' => date('Y-m-d H:i:s'),
            'login_ip' => $ip,
            'state' => 1,
        ];
        return $this->db->insert(T_AGENT_LOGIN_LOG, $data);
    }

}