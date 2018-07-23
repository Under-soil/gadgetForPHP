<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nav extends My_Controller {
    /**
     * 菜单显示
     */
    public function index()
    {
        $data['navName'] = $this->navName;
        $this->load->view('nav/index', $data);
    }

    /**
     * 获取菜单数据
     */
    public function data()
    {
        $result = ['success' => true, 'totalRows' => 0, 'curPage' => 1, 'data' =>[]];
        $this->load->model('menu_model', 'menu');
        $data = $this->menu->get_all_by_pid();
        if ($data && is_array($data))
        {
            $result['data'] = $data;
            $result['totalRows'] = count($data);
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 获取子菜单数据
     */
    public function child()
    {
        $result = ['success' => true, 'totalRows' => 0, 'curPage' => 1, 'data' =>[]];
        $this->load->model('menu_model', 'menu');
        $id = $this->input->post('id', true);
        $data = $this->menu->get_all_by_pid($id);
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
                'rules' => 'trim|greater_than_equal_to[0]|regex_match[/^[0-9]+$/]',
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
                'label' => '菜单名',
                'rules' => 'trim|required|is_unique[' . Menu_model::T_MENU . '.name]',
                'errors' => ['is_unique' => '{field}已存在', 'required' => '{field}不能为空']
            ],
            'name_edit'=> [
                'field' => 'name',
                'label' => '菜单名',
                'rules' => 'trim|required',
                'errors' => ['required' => '{field}不能为空']
            ],
            'mca_add' => [
                'field' => 'mca',
                'label' => '链接',
                'rules' => 'trim|required|is_unique[' . Menu_model::T_MENU . '.mca]',
                'errors' => ['is_unique' => '{field}已存在', 'required' => '{field}不能为空']
            ],
            'mca_edit' => [
                'field' => 'mca',
                'label' => '链接',
                'rules' => 'trim|required',
                'errors' => ['required' => '{field}不能为空']
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
     * 添加菜单逻辑
     */
    public function add()
    {
        $result = ['r' => 0, 'm' => ''];
        do
        {
            $this->load->library('form_validation');
            $this->load->model('menu_model', 'nav');
            // pid >=0 int , name 必须, mca 非必填, ico 非必填, order_number 非必填
            $this->form_validation->set_rules($this->validation_rule(['id', 'name_add', 'mca_add', 'ico', 'order_number']));
            if ( ! $this->form_validation->run())
            {
                $result['m'] = validation_errors();
                break;
            }
            $data = $this->input->post();
            unset($data['id']);
            if ($index = $this->nav->addData(Menu_model::T_MENU, $data))
            {
                $result['r'] = 2;
                $result['id'] = $index;
            }
        } while (false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 编辑菜单逻辑
     */
    public function edit()
    {
        $result = ['r' => 0, 'm' => ''];
        do
        {
            $this->load->library('form_validation');
            $this->load->model('menu_model', 'nav');
            $this->form_validation->set_rules($this->validation_rule(['id', 'name_edit', 'mca_edit', 'ico']));
            if ( ! $this->form_validation->run())
            {
                $result['m'] = validation_errors();
                break;
            }
            $data = $this->input->post();
            $id = $data['id'];
            $nameNum = $this->rule->getNum(Menu_model::T_MENU, ['name' => $data['name'], 'id != ' => $id]);
            if ($nameNum > 0)
            {
                $result['m'] = '菜单名已被使用';
                break;
            }
            $titleNum = $this->rule->getNum(Menu_model::T_MENU, ['mca' => $data['mca'], 'id != ' => $id]);
            if ($titleNum > 0)
            {
                $result['m'] = '链接已被使用';
                break;
            }
            unset($data['id']);
            $this->load->model('menu_model', 'nav');
            if ($this->nav->update_by_id($data, $id))
            {
                $result['r'] = 2;
            }
        } while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 删除菜单
     */
    public function delete()
    {
        $result = ['r' => 0, 'm' => ''];
        do
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules($this->validation_rule(['id']));
            if ( ! $this->form_validation->run())
            {
                $result['m'] = '请填写完整信息';
                break;
            }
            $id = $this->input->post('id', TRUE);
            $this->load->model('menu_model', 'nav');
            if ($this->nav->get_child_num($id) > 0)
            {
                $result['m'] = '该菜单还有子菜单，不能删除';
                break;
            }
            if ($this->nav->deleteData(Menu_model::T_MENU, ['id' => $id]))
            {
                $result['r'] = 2;
            }
        } while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 菜单排序
     */
    public function order()
    {
        $result = ['r' => 0, 'm' => ''];
        do
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules($this->validation_rule(['id']));
            if ( ! $this->form_validation->run())
            {
                $result['m'] = '请填写完整信息';
                break;
            }
            $data = $this->input->post();
            if ( ! ($data && is_array($data))) {
                break;
            }
            $this->load->model('menu_model', 'nav');
            if ($this->nav->orderData(Menu_model::T_MENU, $data)) {
                $result['r'] = 2;
            }
        } while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}