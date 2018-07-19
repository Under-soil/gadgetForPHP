<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model {
    const DISABLED = 0;
    const ENABLE = 1;

    const TYPE_SYS = 0;
    const TYPE_AGENT = 1;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 分页获取系统用户
     * @param $offset
     * @param $page_size
     * @return mixed
     */
    public function get_sys_user($offset, $page_size)
    {
        $field = 'u.id, username, u.level, u.state';
        return $this->db->select($field)
            ->from(T_USER . ' as u')
            ->join(T_GROUP . ' as g', 'u.level = g.id', 'left')
            ->where('type', self::TYPE_SYS)
            ->offset($offset)
            ->limit($page_size)
            ->order_by('create_time', 'DESC')
            ->get()
            ->result_array();
    }

    /**
     * 获取系统用户数
     * @return mixed
     */
    public function get_sys_user_num()
    {
        return $this->db
            ->from(T_USER . ' as u')
            ->join(T_GROUP . ' as g', 'u.level = g.id', 'left')
            ->where('type', self::TYPE_SYS)
            ->count_all_results();
    }

    /**
     * 获取包含推广信息的用户信息
     * @param $id
     * @return bool
     */
    public function get_info_by_id($id)
    {
        $field = 'id,u.username as username,u.level as level,u.login_time as login_time,u.login_ip as login_ip,u.create_time as create_time,realname,phone,wechat,appuid,code,agent_num,member_num,pcode,balance,address';
        $query = $this->db->select($field)->from(T_USER . ' as u')
            ->join(T_AGENT . ' as a', 'u.id = a.uid', 'left')
            ->where('u.id', $id)
            ->get();
        if (1 != $query->num_rows())
        {
            return FALSE;
        }
        return $query->row_array();
    }

    public function get_password_by_id($id)
    {
        $query = $this->db->select('passwd')->where('id', $id)->get(T_USER);
        if (1 != $query->num_rows())
        {
            return FALSE;
        }
        return $query->row()->passwd;
    }

    /**
     * 获取包含推广信息的用户信息(包含密码)
     * @param $username
     * @return bool
     */
    public function get_info_by_username($username)
    {
        $field = 'id,u.username as username,u.passwd as passwd,u.level as level,u.login_time as login_time,u.login_ip as login_ip,u.create_time as create_time,u.state as state,u.can_login_time as can_login_time,
        realname,phone,wechat,appuid,code,area_code,agent_num,member_num,pcode,balance,address,yunying,u.login_failed_num as login_failed_num,u.pwd_strength as pwd_strength';
        $query = $this->db->select($field)->from(T_USER . ' as u')
            ->join(T_AGENT . ' as a', 'u.id = a.uid', 'left')
            ->where('u.username', $username)
            ->get();
        if (1 != $query->num_rows())
        {
            return FALSE;
        }
        return $query->row_array();
    }

    /**
     * 新增用户
     * @param $data
     * @return mixed
     */
    public function add_user($data)
    {
        $user = array(
            'username' => $data['username'],
            'passwd' => MD5($data['passwd']),
            'level' => $data['level'],
            'create_time' => date('Y-m-d H:i:s'),
            'create_ip' => $data['ip'],
            'pwd_strength' => $data['pwd_strength'],
        );
        $this->db->insert(T_USER, $user);
        return $this->db->insert_id();
    }

    /**
     * 自动封号
     * @param $id
     * @return mixed
     */
    public function set_lock($id)
    {
        $data = ['state' => self::DISABLED, 'can_login_time' => time()+3600*24];
        return $this->db->update(T_USER, $data, ['id' => $id]);
    }

    /**
     * 增加登录失败次数
     * @param $id
     */
    public function add_fail_num($id)
    {
        $this->db->set('login_failed_num', 'login_failed_num + 1', FALSE)->where('id', $id)->update(T_USER);
    }

    /**
     * 更新登录信息
     * @param $id
     * @param $ip
     * @return mixed
     */
    public function update_login_info($id, $ip)
    {
        $data = [
            'login_failed_num' => 0,
            'can_login_time' => 0,
            'login_time' => date('Y-m-d H:i:s'),
            'login_ip' => $ip,
            'session_id' => session_id()
        ];
        return $this->db->update(T_USER, $data, ['id' => $id]);
    }

    /**
     * 禁用/启用
     * @param $id
     * @param $state
     * @return bool
     */
    public function set_state($id, $state)
    {
        if (self::DISABLED == $state || self::ENABLE == $state)
        {
            $data = ['state' => $state];
            if ($state == self::ENABLE)
            {
                $data['login_failed_num'] = 0;
                $data['can_login_time'] = 0;
            }
            return $this->db->update(T_USER, $data, ['id' => $id]);
        }
        return FALSE;
    }

    /**
     * 设置密码
     * @param $id
     * @param $pwd
     * @param bool $pwd_strength
     * @return mixed
     */
    public function set_pwd($id, $pwd, $pwd_strength = TRUE)
    {
        $data = ['passwd' => md5($pwd)];
        if ( ! $pwd_strength)
        {
            $data['pwd_strength'] = 0;
        }
        return $this->db->update(T_USER, $data, ['id' => $id]);
    }

    /**
     * 获取session_id
     * @param $id
     * @return bool
     */
    private function get_session_id_by_id($id)
    {
        $query = $this->db->select('session_id')->where('id', $id)->get(T_USER);
        if (1 != $query->num_rows())
        {
            return FALSE;
        }
        return $query->row()->session_id;
    }



    public function getUserInfo($uid)
    {
        return $this->db->from(T_USER)->where('uid', $uid)->get()->result_array();
    }

    /**
     * 强制下线
     * @param $id
     * @return bool
     */
    public function force_down_line($id)
    {
        $session_id = $this->get_session_id_by_id($id);
        if ( ! $session_id)
        {
            return FALSE;
        }
        $file_name = $this->config->item('sess_save_path') . '/ci_session' . $session_id;
        log_message('debug', 'filename:' . $file_name);
        if (($session_id != session_id()) && file_exists($file_name))
        {
            if ( ! unlink($file_name))
            {
                log_message('debug', '删除失败:'.$file_name);
                return FALSE;
            }
        }
        return TRUE;
    }
}