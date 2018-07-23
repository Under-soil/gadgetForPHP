<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Redisoperate{
    private $host;
    private $port;
    private $auth;
    private $db;
    public $redis;
    const USER_PREFIX = 'PO_';
    const IP_BLACK_INFO = 'conf:ip:forbid_info';
    const PWD_CODE_PREFIX = 'sms';                //忘记密码code前缀
    const PWD_CODE_EXPIRE = 600;                  //忘记密码code过期时长
    const PWD_TIME_CODE_PREFIX = 'sms_time';      //一分钟内发送忘记密码code前缀
    const PWD_TIME_CODE_EXPIRE = 60;              //一分钟内发送忘记密码code过期时长

    const MANAGER_LOGIN_CODE_PREFIX = 'sms_manager_login';            //管理登录code前缀
    const MANAGER_LOGIN_CODE_EXPIRE = 600;                            //管理登录code过期时长
    const MANAGER_LOGIN_TIME_CODE_PREFIX = 'sms_manager_login_time';  //一分钟内发送管理登录code前缀
    const MANAGER_LOGIN_TIME_CODE_EXPIRE = 60;                        //一分钟内发送管理登录code过期时长

    public function __construct($config = array())
    {
        if(0 === count($config))
        {
            $CI =& get_instance();
            $config = [
                'host' => $CI->config->item('redis_host'),
                'port' => $CI->config->item('redis_port'),
                'auth' => $CI->config->item('redis_password'),
                'db'   => $CI->config->item('db_index'),
            ];
        }
        if( ! array_key_exists('host', $config))
        {
            return FALSE;
        }
        $this->host = $config['host'];
        if( ! array_key_exists('port', $config))
        {
            return FALSE;
        }
        $this->port = $config['port'];
        if( ! array_key_exists('db', $config))
        {
            return FALSE;
        }
        $this->db = $config['db'];
        if( ! array_key_exists('auth', $config))
        {
            return FALSE;
        }
        $this->auth = $config['auth'];
    }

    public function connect($dbIndex = '')
    {
        $result = ['r' => FALSE, 'm' => ''];
        do
        {
            $index = is_numeric($dbIndex) ? $dbIndex : $this->db;
            if ( ! ($this->host))
            {
                $result['m'] = '请检查redis配置';
                break;
            }
            $this->redis = new Redis();
            if ( ! $this->redis)
            {
                $result['m'] = 'redis实例化失败';
                break;
            }
            if (FALSE === $this->redis->connect($this->host, $this->port))
            {
                $result['m'] = 'Redis连接失败-connect';
                break;
            }
            if ($this->auth && FALSE === $this->redis->auth($this->auth))
            {
                $result['m'] = 'Redis连接失败-auth';
                break;
            }
            if (FALSE === $this->redis->select($index))
            {
                $result['m'] = 'Redis连接失败-select';
                break;
            }
            $result['r'] = TRUE;
        } while(FALSE);
        if ($result['m'])
        {
            log_message('ERROR', $result['m']);
        }
        return $result;
    }

    /**
     * 获取redis中缓存的用户信息
     * @param $redis         redis句柄
     * @param $uid           查询id
     * @param array $fields  查询字段
     * @return array|bool    返回值（输入类型错误返回false）
     */
    public function user_info($redis, $uid, $fields = array())
    {
        $ret = array();
        if(is_object($redis) && is_numeric($uid) && is_array($fields) && $redis->hexists(self::USER_PREFIX . $uid, 'status'))
        {
            if(count($fields))
            {
                foreach ($fields as $field)
                {
                    $ret[$field] = $redis->hget(self::USER_PREFIX . $uid, $field);
                }
            }else{
                $ret = $redis->hgetall(self::USER_PREFIX . $uid);
            }
            return $ret;
        }else{
            return false;
        }
    }

    /**
     * 修改用户信息
     * @param $redis        redis句柄
     * @param $uid          修改id
     * @param array $fields 修改字段 array(field=>value,....)
     * @return bool         是否修改成功
     */
    public function update_user_info($redis, $uid, $fields = array())
    {
        $ret = false;
        if(is_object($redis) && is_numeric($uid) && ! empty($uid) && is_array($fields) && $redis->hexists(self::USER_PREFIX . $uid, 'status'))
        {
            if(count($fields))
            {
                foreach ($fields as $key => $value)
                {
                    $redis->hset(self::USER_PREFIX . $uid, $key, $value);
                }

                $ret = true;
            }else{
                $ret = false;
            }
        }else{
            $ret = false;
        }
        return $ret;
    }

    /**
     * 获取黑名单数组（可以根据ip模糊查询000.000.000.000）
     * @param $redis
     * @param $ip
     * @return bool
     */
    public function get_ip_black_list($redis, $ip = '')
    {
        $ret = false;
        if(is_object($redis))
        {
            if (filter_var($ip, FILTER_VALIDATE_IP))
            {
                //精确查询
                if ($redis->hexists(self::IP_BLACK_INFO .':'. $ip, 'ip'))
                {
                    $ret = [$ip];
                }
            }
            else
            {
                //模糊查询
                $ret = $redis->keys(self::IP_BLACK_INFO .':*'. $ip . '*');
                $ret = array_map(function ($item){
                    return str_replace(self::IP_BLACK_INFO . ':', '', $item);
                }, $ret);
            }
        }
        return $ret;
    }

    /**
     * 获取单个ip详细信息
     * @param $redis
     * @param bool $ip
     * @return bool
     */
    public function get_ip_black_info($redis, $ip = false)
    {
        $ret = false;
        if(is_object($redis) && $ip !== false)
        {
            if (filter_var($ip, FILTER_VALIDATE_IP))
            {
                $ret = $redis->hgetall(self::IP_BLACK_INFO .':'. $ip);
            }
        }
        return $ret;
    }

    /**
     * 新增或修改ip黑名单
     * @param $redis
     * @param $ip
     * @param array $data
     * @param int $expire
     * @return bool
     */
    public function add_or_edit_ip_blacklist($redis, $ip, $data = [], $expire = 0)
    {
        $ret = false;
        if(is_object($redis) && is_array($data) && count($data) && $ip)
        {
            //新增详细信息
            foreach ($data as $field => $value)
            {
                $redis->hset(self::IP_BLACK_INFO.':'.$ip, $field, $value);
            }
            //详细信息过期时间
            if (is_numeric($expire) && $expire > 0)
            {
                $redis->expire(self::IP_BLACK_INFO . ':' . $ip, $expire);
            }

            $ret = true;
        }
        return $ret;
    }

    /**
     * 删除ip黑名单
     * @param $redis
     * @param $ip
     * @return bool
     */
    public function del_ip_black($redis, $ip)
    {
        $ret = false;
        if(is_object($redis) && $ip)
        {
            $redis->del(self::IP_BLACK_INFO . ':' . $ip);
            $ret = true;
        }
        return $ret;
    }

    /**
     * 获取一分钟内的重置密码code
     * @param $redis
     * @param $phone
     * @return mixed
     */
    public function password_find_time_code($redis, $phone)
    {
        $code = $redis->get(self::PWD_TIME_CODE_PREFIX . ':' . $phone);
        return $code;
    }

    /**
     * 获取重置密码code
     * @param $redis
     * @param $phone
     * @return mixed
     */
    public function password_find_code($redis, $phone)
    {
        $code = $redis->get(self::PWD_CODE_PREFIX . ':' . $phone);
        return $code;
    }

    /**
     * 设置重置密码code
     * @param $redis
     * @param $phone
     * @param $code
     */
    public function set_password_find_code($redis, $phone, $code)
    {
        //十分钟过期
        $redis->set(self::PWD_CODE_PREFIX . ':' . $phone, $code);
        $redis->expire(self::PWD_CODE_PREFIX . ':' . $phone, self::PWD_CODE_EXPIRE);

        //一分钟内不重复
        $redis->set(self::PWD_TIME_CODE_PREFIX . ':' . $phone, $code);
        $redis->expire(self::PWD_TIME_CODE_PREFIX . ':' . $phone, self::PWD_TIME_CODE_EXPIRE);
    }

    /**
     * 清除重置密码code
     * @param $redis
     * @param $phone
     */
    public function del_password_find_code($redis, $phone)
    {
        $redis->del(self::PWD_CODE_PREFIX . ':' . $phone);
        $redis->del(self::PWD_TIME_CODE_PREFIX . ':' . $phone);
    }

    /**
     * 获取一分钟内的管理员登录code
     * @param $redis
     * @param $phone
     * @return mixed
     */
    public function manager_login_time_code($redis, $phone)
    {
        $code = $redis->get(self::MANAGER_LOGIN_TIME_CODE_PREFIX . ':' . $phone);
        return $code;
    }

    /**
     * 获取管理员登录code
     * @param $redis
     * @param $phone
     * @return mixed
     */
    public function manager_login_code($redis, $phone)
    {
        $code = $redis->get(self::MANAGER_LOGIN_CODE_PREFIX . ':' . $phone);
        return $code;
    }

    /**
     * 设置管理员登录code
     * @param $redis
     * @param $phone
     * @param $code
     */
    public function set_manager_login_code($redis, $phone, $code)
    {
        //十分钟过期
        $redis->set(self::MANAGER_LOGIN_CODE_PREFIX . ':' . $phone, $code);
        $redis->expire(self::MANAGER_LOGIN_CODE_PREFIX . ':' . $phone, self::MANAGER_LOGIN_CODE_EXPIRE);

        //一分钟内不重复
        $redis->set(self::MANAGER_LOGIN_TIME_CODE_PREFIX . ':' . $phone, $code);
        $redis->expire(self::MANAGER_LOGIN_TIME_CODE_PREFIX . ':' . $phone, self::MANAGER_LOGIN_TIME_CODE_EXPIRE);
    }

    /**
     * 清除管理员登录code
     * @param $redis
     * @param $phone
     */
    public function del_manager_login_code($redis, $phone)
    {
        $redis->del(self::MANAGER_LOGIN_CODE_PREFIX . ':' . $phone);
        $redis->del(self::MANAGER_LOGIN_TIME_CODE_PREFIX . ':' . $phone);
    }

}