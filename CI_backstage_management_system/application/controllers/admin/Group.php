<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Group
 *
 * @description 系统角色CURD
 * @modify 编码规范
 */
class Group extends MY_Controller {
    /**
     * 用户列表
     */
    public function index()
    {
        $this->load->view('group/index');
    }

    /**
     * 获取角色列表
     */
    public function data()
    {
        $result = ['success' => true, 'totalRows' => 0, 'curPage' => 1, 'data' =>[]];
        do 
        {
            $this->load->library('form_validation');
            if (FALSE === $this->form_validation->run('page'))
            {
                log_message('ERROR', validation_errors());
                break;
            }

            $page_size = $this->input->post('pageSize', TRUE);
            $cur_page = $this->input->post('curPage', TRUE);

            $this->load->model('group_model', 'group');
            $data = $this->group->get_page_data(($cur_page - 1) * $page_size, $page_size);
            if ($data && is_array($data))
            {
                $result['data'] = $data;
                $result['totalRows'] = $this->group->get_num();
            }
            $result['curPage'] = $cur_page;
        }
        while(FALSE);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 添加分组
     */
    public function add()
    {
        $result = ['r' => self::STATE_FAIL, 'm' => ''];
        do {
            $this->load->library('form_validation');
            if (FALSE === $this->form_validation->run('group_add'))
            {
                $result['m'] = '请检查分组名';
                log_message('ERROR', validation_errors());
                break;
            }
            $name = $this->input->post('title', TRUE);
            $this->load->model('group_model', 'group');
            $index = $this->group->add($name);
            if ($index > 0)
            {
                $result['r'] = self::STATE_SUCCESS;
                $result['index'] = $index;
            }
        }
        while(FALSE);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 编辑权限
     */
    public function edit()
    {
        $result = ['r' => self::STATE_FAIL, 'm' => ''];
        do {
            $this->load->library('form_validation');
            if (!$this->form_validation->run('group_edit'))
            {
                $result['m'] = '请检查输入项';
                log_message('ERROR', validation_errors());
                break;
            }
            $id = $this->input->post('id', TRUE);
            $name = $this->input->post('title', TRUE);
            $this->load->model('group_model', 'group');
            if (TRUE === $this->group->save($id, $name))
            {
                $result['r'] = self::STATE_SUCCESS;
            }
        }
        while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 分配权限
     * @param $id
     */
    public function rule($id)
    {
        if ( ! (is_integer(intval($id)) && $id >= 0))
        {
            die;
        }
        $this->load->model('group_model', 'group');
        $group_data = $this->group->get_rule_by_id($id);
        if ($group_data && is_array($group_data))
        {
            if ($group_data['rules'])
            {
                $group_data['rules'] = explode(',', $group_data['rules']);
            }
        }
        $rule_data = $this->group->get_tree_data('level', 'id', 'title');
        $data = [
            'group_data' =>$group_data,
            'rule_data'=>$rule_data,
        ];
        $this->load->view('group/rule', $data);
    }

    /**
     * 分配权限处理
     */
    public function deal()
    {
        $result = ['r' => self::STATE_FAIL, 'm' => ''];
        do {
            $this->load->library('form_validation');
            if (FALSE === $this->form_validation->run('id'))
            {
                $result['m'] = '请填写完整信息';
                log_message('ERROR', validation_errors());
                break;
            }
            $id = $this->input->post('id', TRUE);
            $rule_ids = $this->input->post('rule_ids', TRUE);
            if ($rule_ids && is_array($rule_ids))
            {
                $data['rules'] = implode(',', $rule_ids);
            }
            else
            {
                $data['rules'] = '';
            }
            $this->load->model('group_model');
            if ($this->group_model->save_rules($id, $data))
            {
                $result['r'] = self::STATE_SUCCESS;
            }
        }
        while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}