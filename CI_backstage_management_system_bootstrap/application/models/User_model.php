<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model {
    const T_USER = 't_agent_user';
    const DISABLED = 0;
    const ENABLE = 1;
    const ROOT_LEVEL = 1000;

    /**
     * 根据id获取用户信息，不包含密码
     * @param $id
     * @return mixed
     */
    public function get_by_id($id)
    {
        $field = 'create_time,login_time,login_ip,session_id,level';
        $query = $this->db->select($field)->where('id', $id)->get(self::T_USER);
        if ($query->num_rows() == 1)
        {
            return $query->row_array();
        }
        return false;
    }

    /**
     * 获取用户密码，慎用
     * @param $id
     * @return mixed
     */
    public function get_pwd_by_id($id)
    {
        return $this->db->select('passwd')->where('id', $id)->get(self::T_USER)->row()->passwd;
    }

    /**
     * 根据用户名获取用户信息，包括密码，慎用
     * @param $username
     * @return mixed
     */
    public function get_by_username($username)
    {
        $field = 'id,username,passwd,level,state,pwd_strength';
        return $this->db->select($field)->where('username', $username)->get(self::T_USER)->row_array();
    }

    /**
     * 更新用户的登录信息
     * @param $id
     * @return mixed
     */
    public function update_login_info($id)
    {
        $loginInfo = [
            'login_time' => date('Y-m-d H:i:s'),
            'login_ip' => $this->input->ip_address(),
            'login_failed_num' => 0,
            'can_login_time' => 0,
        ];
        return $this->db->update(self::T_USER, $loginInfo, ['id' => $id]);
    }

    /**
     * 修改密码
     * @param $id
     * @param $new_password
     * @param $pwd_strength
     * @return mixed
     */
    public function update_pwd($id, $new_password, $pwd_strength)
    {
        $data = [
            'passwd' => md5($new_password),
            'pwd_strength' => $pwd_strength
        ];
        return $this->db->update(self::T_USER, $data, ['id' => $id]);
    }

    /**
     * 更新session信息
     * @param $id
     * @return mixed
     */
    private function update_session_info($id)
    {
        return $this->db->update(self::T_USER, ['session_id' => session_id()], ['id' => $id]);
    }

    /**
     * 保持唯一登录
     * @param $id
     * @return bool|mixed
     */
    public function del_session_file($id)
    {
        $data = $this->get_by_id($id);
        if ($data && is_array($data))
        {
            if ($data['session_id'])
            {
                $fileName = $this->config->item('sess_save_path') . '/ci_session' . $data['session_id'];
                if (file_exists($fileName) && ($data['session_id'] != session_id()))
                {
                    if ( ! unlink($fileName))
                    {
                        log_message('debug', '删除失败:'.$fileName);
                        return FALSE;
                    }
                }
            }
        }
        return $this->update_session_info($id);
    }

    /**
     * 启用/禁用系统用户
     * @param $id
     * @param $state
     * @return mixed
     */
    public function set_state($id, $state)
    {
        if ($state != self::ENABLE && $state != self::DISABLED)
        {
            return FALSE;
        }
        return $this->db->update(self::T_USER, ['state' => $state], ['id' => $id]);
    }

    /**
     * 更新用户信息
     * @param $uid
     * @param $data
     * @return mixed
     */
    public function update_user($uid, $data)
    {
        $this->db->set($data);
        $this->db->where('id', $uid);
        return $this->db->update(self::T_USER);
    }


}