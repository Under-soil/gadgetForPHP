<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__file__).'/../libraries/Data.php';
class MY_Model extends CI_Model {
    /**
     * 添加数据
     * @param $tableName string      表名
     * @param $data      array       添加的数据
     * @return mixed     boolean     操作是否成功
     */
    public function addData($tableName, $data)
    {
        foreach ($data as $k => $v)
        {
            $data[$k] = trim($v);
        }
        $this->db->insert($tableName, $data);
        return $this->db->insert_id();
    }

    /**
     * 添加数据
     * @param $tableName string      表名
     * @param $data      array       添加的数据
     * @return mixed     boolean     操作是否成功
     */
    public function add_data($tableName, $data)
    {
        foreach ($data as $k => $v)
        {
            $data[$k] = trim($v);
        }
        $this->db->insert($tableName, $data);

        return $this->db->insert_id();
    }

    /**
     * 删除数据
     * @param $tableName string      表名
     * @param $map       array       where语句数组形式
     * @return           boolean     操作是否成功
     */
    public function deleteData($tableName, $map)
    {
        if (empty($map))
        {
            die('where为空的危险操作');
        }
        return $this->db->delete($tableName, $map);
    }

    /**
     * 获取记录数
     * @param $tableName string      表名
     * @param $map       array       where语句数组形式
     * @return mixed
     */
    public function getNum($tableName, $map)
    {
        return $this->db->select('count(1) as num')->where($map)->get($tableName)->row()->num;
    }

    /**
     * 数据排序
     * @param string $tableName     表名
     * @param  array $data   数据源
     * @param  string $id    主键
     * @param  string $order 排序字段
     * @return boolean       操作是否成功
     */
    public function orderData($tableName, $data,$id='id',$order='order_number')
    {
        foreach ($data as $k => $v)
        {
            $v=empty($v) ? null : $v;
            $this->db->where([$id => $k])->update($tableName, [$order=>$v]);
        }
        return true;
    }

    /**
     * 指定字段是否存在某个值
     * @param $tableName
     * @param $key
     * @param $value
     * @return bool
     */
    public function is_exists($tableName, $key, $value)
    {
        $query = $this->db->select('1')
            ->from($tableName)
            ->where($key, $value)
            ->limit(1)
            ->get();

        return ($query->num_rows() == 1);
    }

    /**
     * 修改字段
     * @param $tableName   表名
     * @param $set         设置字段
     * @param $where       筛选条件
     * @param int $limit   修改条数
     * @return bool        是否成功
     */
    public function update_data($tableName, $set, $where, $limit = 1)
    {
        if( ! empty($tableName) && count($set) >= 0 &&  ! empty($where))
        {
            if (is_numeric($limit))
            {
                return $this->db->update($tableName, $set, $where, $limit);
            }
            else if(empty($limit))
            {
                return $this->db->update($tableName, $set, $where);
            }
            return false;
        }
        return false;
    }

    /**
     * 检查是否包含必须的键
     * @param $need_keys
     * @param $data
     * @return bool
     */
    protected function check_need_keys($need_keys, $data)
    {
        if ($need_keys && is_array($need_keys) && $data && is_array($data))
        {
            foreach ($need_keys as $val)
            {
                if ( ! array_key_exists($val, $data))
                {
                    return FALSE;
                    break;
                }
            }
            return TRUE;
        }
        return FALSE;
    }

    /**
     * 新增或修改一条信息
     * @param $table_name
     * @param $data
     * @return mixed
     */
    public function insert_or_update($table_name, $data){
        $set = '';
        foreach ($data as $k => $v){
            $set .= $k.' = \''.$v.'\',';
        }

        $set = substr($set,0,strlen($set)-1);

        $sql = 'insert into ' . $table_name . ' ('.implode(',', array_keys($data)).')  values(\''.implode('\',\'', array_values($data)).'\') on  DUPLICATE key update ' . $set;
        $this->db->query($sql);
        $ret = $this->db->affected_rows();

        return $ret;
    }
}