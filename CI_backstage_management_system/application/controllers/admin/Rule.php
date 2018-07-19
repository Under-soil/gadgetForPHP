<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Rule
 *
 * @description 系统权限CURD
 * @modify 编码规范
 */
class Rule extends MY_Controller {
    /**
     * 权限列表
     */
    public function index()
    {
        $this->load->view('rule/index');
    }

    /**
     * 获取权限数据
     */
    public function data()
    {
        $result = ['success' => true, 'totalRows' => 0, 'curPage' => 1, 'data' =>[]];
        $this->load->model('rule_model', 'rule');
        $data = $this->rule->get_tree_data('tree', 'id', 'title');
        if ($data && is_array($data))
        {
            $result['data'] = $data;
            $result['totalRows'] = count($data);
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 添加权限
     */
    public function add()
    {

        $result = ['r' => self::STATE_FAIL, 'm' => '添加失败'];
        do {
            $this->load->library('form_validation');
            // pid >=0 int , name 必须, title 必填
            $this->load->model('rule_model', 'rule');
            if (!$this->form_validation->run('rule_add'))
            {
                $result['m'] = validation_errors();
                break;
            }
            $data = $this->input->post();
            unset($data['id']);
            if ($this->rule->addData(T_RULE, $data))
            {
                $result['r'] = self::STATE_SUCCESS;
            }
        }
        while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 编辑权限
     */
    public function edit()
    {
        $result = ['r' => self::STATE_FAIL, 'm' => '编辑失败'];
        do {
            $this->load->library('form_validation');
            $this->load->model('rule_model', 'rule');
            if (!$this->form_validation->run('rule_edit'))
            {
                $result['m'] = validation_errors();
                break;
            }
            $data = $this->input->post();
            $id = $data['id'];
            $nameNum = $this->rule->getNum(T_RULE, ['name' => $data['name'], 'id != ' => $id]);
            $titleNum = $this->rule->getNum(T_RULE, ['title' => $data['title'], 'id != ' => $id]);
            if ($nameNum > 0)
            {
                $result['m'] = '规则已被使用';
                break;
            }
            if ($titleNum > 0)
            {
                $result['m'] = '规则名已被使用';
                break;
            }
            unset($data['id']);
            if ($this->rule->editData(T_RULE, ['id' => $id], $data)) {
                $result['r'] = self::STATE_SUCCESS;
            }
        } while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 删除权限
     */
    public function delete()
    {
        $result = ['r' => self::STATE_FAIL, 'm' => '删除失败'];
        do {
            $this->load->library('form_validation');
            if (!$this->form_validation->run('rule_id'))
            {
                $result['m'] = validation_errors();
                break;
            }
            $id = $this->input->post('id', true);
            $this->load->model('rule_model', 'rule');
            if ($this->rule->deleteData(T_RULE, ['id' => $id])) {
                $result['r'] = self::STATE_SUCCESS;
            }
        } while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function order()
    {
        $result = ['r' => self::STATE_FAIL, 'm' => ''];
        do {
            $this->load->library('form_validation');

            if (!$this->form_validation->run('rule_id'))
            {
                $result['m'] = validation_errors();
                break;
            }
            $data = $this->input->post();
            if (!($data && is_array($data))) {
                break;
            }
            $this->load->model('rule_model', 'rule');
            if ($this->rule->orderData(T_RULE, $data, 'id','pid')) {
                $result['r'] = self::STATE_SUCCESS;
            }
        } while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }


}