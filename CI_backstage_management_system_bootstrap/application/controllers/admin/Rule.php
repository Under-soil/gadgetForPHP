<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rule extends My_Controller {
    /**
     * 权限列表
     */
    public function index()
    {
        $data['navName'] = $this->navName;
        $this->load->view('rule/index', $data);
    }

    /**
     * 获取权限数据
     */
    public function data()
    {
        $result = ['success' => TRUE, 'totalRows' => 0, 'curPage' => 1, 'data' =>[]];
        $this->load->model('rule_model', 'rule');
        $data = $this->rule->get_all_by_pid();
        if ($data && is_array($data))
        {
            $result['data'] = $data;
            $result['totalRows'] = count($data);
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 获取子权限
     */
    public function child()
    {
        $result = ['success' => TRUE, 'totalRows' => 0, 'curPage' => 1, 'data' =>[]];
        $this->load->model('rule_model', 'rule');
        $id = $this->input->post('id', TRUE);
        $data = $this->rule->get_all_by_pid($id);
        if ($data && is_array($data))
        {
            $result['data'] = $data;
            $result['totalRows'] = count($data);
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 设置并获取需要的rules
     * @param array $keys
     * @return array
     */
    private function validation_rule($keys = [])
    {
        $ret_arr = [
            'pid' => [
                'field' => 'pid',
                'label' => 'pid',
                'rules' => 'trim|greater_than_equal_to[0]|regex_match[/^[0-9]{1,11}$/]',
                'errors' => ['regex_match' => '{field}格式不正确', 'greater_than_equal_to' => '{field}必须大于等于{param}']
            ],
            'id' => [
                'field' => 'id',
                'label' => 'id',
                'rules' => 'trim|greater_than[0]|regex_match[/^[0-9]+$/]',
                'errors' => ['regex_match' => '{field}格式不正确', 'greater_than' => '{field}必须大于{param}']
            ],
            'name_add'=> [
                'field' => 'name',
                'label' => '规则',
                'rules' => 'trim|required|regex_match[/^[a-z][a-z_\/]{0,78}[a-z]$/]|is_unique[' . Rule_model::T_RULE . '.name]',
                'errors' => ['is_unique' => '{field}已存在', 'required' => '{field}不能为空', 'regex_match' => '{field}格式不正确']
            ],
            'name_edit'=> [
                'field' => 'name',
                'label' => '规则',
                'rules' => 'trim|required|regex_match[/^[a-z][a-z_\/]{0,78}[a-z]$/]',
                'errors' => ['required' => '{field}不能为空', 'regex_match' => '{field}格式不正确',]
            ],
            'title_add' => [
                'field' => 'title',
                'label' => '规则名',
                'rules' => 'trim|required|max_length[20]|is_unique[' . Rule_model::T_RULE . '.title]',
                'errors' => ['is_unique' => '{field}已存在', 'required' => '{field}不能为空']
            ],
            'title_edit' => [
                'field' => 'title',
                'label' => '规则名',
                'rules' => 'trim|required|max_length[20]',
                'errors' => ['required' => '{field}不能为空', 'max_length' => '{field}最大长度为{param}']
            ],
            'ico' => [
                'field' => 'ico',
                'label' => '图标',
                'rules' => 'trim',
            ],
            'order_number' => [
                'field' => 'order_number',
                'label' => '排序',
                'rules' => 'trim|regex_match[/^[1-9][0-9]*$/]',
                'errors' => ['regex_match' => '{field}格式不正确']
            ]
        ];
        if ( is_array($keys) && count($keys))
        {
            foreach ($keys as $key)
            {
                if (array_key_exists($key, $ret_arr))
                {
                    $data[$key] = $ret_arr[$key];
                }
            }
        }
        else
        {
            $data = $ret_arr;
        }
        return $data;
    }

    /**
     * 添加权限
     */
    public function add()
    {
        $result = ['r' => 0, 'm' => ''];
        do
        {
            $this->load->library('form_validation');
            $this->load->model('rule_model', 'rule');
            $this->form_validation->set_rules($this->validation_rule(['pid', 'name_add', 'title_add','ico','order_number']));
            if ( ! $this->form_validation->run())
            {
                $result['m'] = validation_errors();
                break;
            }
            $data = $this->input->post();
            unset($data['id']);
            if ($this->rule->addData(Rule_model::T_RULE, $data))
            {
                $rule_info = $this->rule->get_rule_info_by_name($data['name']);
                $result['r'] = 2;
                $result['m'] = $rule_info;
            }
        } while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 编辑权限
     */
    public function edit()
    {
        $result = ['r' => 0, 'm' => ''];
        do {
            $this->load->library('form_validation');
            $this->load->model('rule_model', 'rule');
            $this->form_validation->set_rules($this->validation_rule(['id', 'name_edit', 'title_edit','ico','order_number']));
            if ( ! $this->form_validation->run())
            {
                $result['m'] = validation_errors();
                break;
            }
            $data = $this->input->post();
            $id = $data['id'];
            $nameNum = $this->rule->getNum(Rule_model::T_RULE, ['name' => $data['name'], 'id != ' => $id]);
            if ($nameNum > 0)
            {
                $result['m'] = '规则已被使用';
                break;
            }
            $titleNum = $this->rule->getNum(Rule_model::T_RULE, ['title' => $data['title'], 'id != ' => $id]);
            if ($titleNum > 0)
            {
                $result['m'] = '规则名已被使用';
                break;
            }
            unset($data['id']);
            if ($this->rule->update_by_id($data, $id))
            {
                $result['r'] = 2;
            }
        } while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 删除权限
     */
    public function delete()
    {
        $result = ['r' => 0, 'm' => ''];
        do {
            $this->load->library('form_validation');
            $this->form_validation->set_rules($this->validation_rule(['id']));
            if ( ! $this->form_validation->run())
            {
                $result['m'] = '请填写完整信息';
                break;
            }
            $id = $this->input->post('id', true);
            $this->load->model('rule_model', 'rule');
            if ($this->rule->get_child_num($id) > 0)
            {
                $result['m'] = '该权限还有子权限，不能删除';
                break;
            }
            if ($this->rule->deleteData(Rule_model::T_RULE, ['id' => $id]))
            {
                $result['r'] = 2;
            }
        } while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 变更父节点
     */
    public function order()
    {
        $result = ['r' => 0, 'm' => ''];
        do {
            $this->load->library('form_validation');
            $this->form_validation->set_rules($this->validation_rule(['id']));
            $data = $this->input->post();
            if ( ! ($data && is_array($data)))
            {
                break;
            }
            $this->load->model('rule_model', 'rule');
            if ($this->rule->orderData(Rule_model::T_RULE, $data, 'id','pid'))
            {
                $result['r'] = 2;
            }
        } while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }


}