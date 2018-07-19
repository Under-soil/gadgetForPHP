<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__file__).'/../libraries/Data.php';
class MY_Model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 判断指定字段的指定值是否存在
     * @param $table
     * @param $key
     * @param $value
     * @return bool
     */
    public function exist($table, $key, $value)
    {
        $query = $this->db->select('1')
            ->where($key, $value)
            ->limit(1)
            ->get($table);
        return ($query->num_rows() == 1);
    }

    /**
     * 添加数据
     * @param $tableName string      表名
     * @param $data      array       添加的数据
     * @return mixed     boolean     操作是否成功
     */
    public function addData($tableName, $data) {
        foreach ($data as $k => $v) {
            $data[$k]=trim($v);
        }
        $this->db->insert($tableName, $data);
        return $this->db->insert_id();
    }

    /**
     * @param $tableName string      表名
     * @param $map       array       where语句数组形式
     * @param $field     string
     * @param $order     string
     * @return mixed
     */
    public function getOne($tableName, $map = [], $field = "*", $order = '')
    {
        $query = $this->db->select($field)->where($map);
        if ($order)
        {
            $query->order_by($order);
        }
        return $query->get($tableName)->row_array();
    }

    /**
     * 修改数据
     * @param $tableName string      表名
     * @param $map       array       where语句数组形式
     * @param $data      array       添加的数据
     * @return mixed
     */
    public function editData($tableName, $map, $data){
        foreach ($data as $k => $v) {
            $data[$k]=trim($v);
        }
        $this->db->where($map);
        return $this->db->update($tableName, $data);
    }

    /**
     * 删除数据
     * @param $tableName string      表名
     * @param $map       array       where语句数组形式
     * @return           boolean     操作是否成功
     */
    public function deleteData($tableName, $map){
        if (empty($map)) {
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
     * @param string $tableName     表名
     * @param array  $map           where语句数组形式
     * @param string $field
     * @param int    $offset
     * @param int    $pageSize
     * @param string $order
     * @return mixed
     */
    public function getPage($tableName, $map, $field = '*', $offset = 0, $pageSize = 20, $order = '')
    {
        return $this->db->select($field)->where($map)->order_by($order)->limit($pageSize, $offset)->get($tableName)->result_array();
    }

    public function getAll($tableName, $map, $field = '*', $order = '')
    {
        return $this->db->select($field)->where($map)->order_by($order)->get($tableName)->result_array();
    }

    /**
     * 数据排序
     * @param string $tableName     表名
     * @param  array $data   数据源
     * @param  string $id    主键
     * @param  string $order 排序字段
     * @return boolean       操作是否成功
     */
    public function orderData($tableName, $data,$id='id',$order='order_number'){
        foreach ($data as $k => $v) {
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
    public function isExist($tableName, $key, $value)
    {
        $query = $this->db->select('1')
            ->from($tableName)
            ->where($key, $value)
            ->limit(1)
            ->get();

        return ($query->num_rows() == 1);
    }

    public function getJoin($join, $map = [], $offset = 0, $pageSize = 20)
    {
        return $this->db->select($join['field'])
            ->from($join['mainTable'])
            ->join($join['joinTable'], $join['on'], $join['joinType'])
            ->where($map)
            ->limit($pageSize, $offset)
            ->get()
            ->result_array();
    }

    public function getJoinNum($join, $map = [])
    {
        return $this->db->select($join['field'])
            ->from($join['mainTable'])
            ->join($join['joinTable'], $join['on'], $join['joinType'])
            ->where($map)
            ->get()
            ->num_rows();
    }
}