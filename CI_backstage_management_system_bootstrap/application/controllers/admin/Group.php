<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends My_Controller {

    /**
     * 用户列表
     */
    public function index()
    {
        $this->load->view('group/index');
    }

    /**
     * 获取分页数据
     */
    public function data()
    {
        $result = ['success' => true, 'totalRows' => 0, 'curPage' => 1, 'data' =>[]];
        do
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('pageSize','每页显示数量','trim|required');
            $this->form_validation->set_rules('curPage','当前页数','trim|required');
            if ( ! $this->form_validation->run())
            {
                break;
            }
            $pageSize = $this->input->post('pageSize', true);
            $curPage = $this->input->post('curPage', true);
            $this->load->model('group_model', 'group');
            $data = $this->group->get_by_pages($pageSize, ($curPage - 1) * $pageSize);
            if ($data && is_array($data))
            {
                $result['data'] = $data;
                $result['totalRows'] = $this->group->getNum(Group_model::T_GROUP, []);
            }
            $result['curPage'] = $curPage;
        } while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 添加权限
     */
    public function add()
    {
        $result = ['r' => 0, 'm' => ''];
        do {
            $this->load->library('form_validation');
            // pid >=0 int , name 必须, title 必填
            $this->form_validation->set_rules('title', '分组名', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('type', '角色分类', 'trim|required|in_list[0,1]');
            if ( ! $this->form_validation->run())
            {
                $result['m'] = '参数不正确';
                break;
            }
            $data = $this->input->post();

            $this->load->model('group_model', 'group');
            if ($data['type'] == AGENT_TYPE)
            {
                $data['status'] = Group_model::ENABLE;
                if ( ! (array_key_exists('commission', $data) && array_key_exists('commissionx', $data)) && array_key_exists('commissionthree', $data) && array_key_exists('cumulative_coins', $data))
                {
                    $result['m'] = '参数不正确';
                    break;
                }
                if ($data['commission'] > 100 || $data['commission'] < 1)
                {
                    $result['m'] = '会员返佣参数不正确';
                    break;
                }
                $data['commission'] = $data['commission'] / 100;
                if ($data['commissionx'] > 100 || $data['commissionx'] < 1)
                {
                    $result['m'] = '下级返佣参数不正确';
                    break;
                }
                $data['commissionx'] = $data['commissionx'] / 100;

                if ($data['commissionthree'] > 100 || $data['commissionthree'] < 1)
                {
                    $result['m'] = '下下级返佣参数不正确';
                    break;
                }
                $data['commissionthree'] = $data['commissionthree'] / 100;


                $row = $this->group->get_max_commission();
                $max_one = $row["max_one"] > $data['commission'] ? $row["max_one"] : $data['commission'];
                $max_two = $row["max_two"] > $data['commissionx'] ? $row["max_two"] : $data['commissionx'];
                $max_three = $row["max_three"] > $data['commissionthree'] ? $row["max_three"] : $data['commissionthree'];

                if ($max_one + $max_two + $max_three > 1)
                {
                    $result['m'] = '返佣参数之和不能超过100';
                    break;
                }

                $data["cumulative_coins"] = intval($data["cumulative_coins"]);
            }
            unset($data['id']);
            if ($index = $this->group->addData(Group_model::T_GROUP, $data))
            {
                $result['r'] = 2;
                $result['id'] = $index;
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
            $this->form_validation->set_rules('id', 'id', 'trim|greater_than_equal_to[0]|max_length[11]|regex_match[/^[0-9]+$/]');
            $this->form_validation->set_rules('title', '分组名', 'trim|required|max_length[50]');
            if ( ! $this->form_validation->run())
            {
                $result['m'] = '参数不正确';
                break;
            }
            $data = $this->input->post();
            if ( array_key_exists('commission', $data) && array_key_exists('commissionx', $data) && array_key_exists('commissionthree', $data) && array_key_exists('cumulative_coins', $data))
            {
                if ($data['commission'] > 100 || $data['commission'] < 1)
                {
                    $result['m'] = '会员返佣参数不正确';
                    break;
                }
                $data['commission'] = $data['commission'] / 100;
                if ($data['commissionx'] > 100 || $data['commissionx'] < 1)
                {
                    $result['m'] = '下级返佣参数不正确';
                    break;
                }
                $data['commissionx'] = $data['commissionx'] / 100;

                if ($data['commissionthree'] > 100 || $data['commissionthree'] < 1)
                {
                    $result['m'] = '下下级返佣参数不正确';
                    break;
                }
                $data['commissionthree'] = $data['commissionthree'] / 100;


                $row = $this->group->get_max_commission();
                $max_one = $row["max_one"] > $data['commission'] ? $row["max_one"] : $data['commission'];
                $max_two = $row["max_two"] > $data['commissionx'] ? $row["max_two"] : $data['commissionx'];
                $max_three = $row["max_three"] > $data['commissionthree'] ? $row["max_three"] : $data['commissionthree'];

                if ($max_one + $max_two + $max_three > 1)
                {
                    $result['m'] = '返佣参数之和不能超过100';
                    break;
                }

                $data["cumulative_coins"] = intval($data["cumulative_coins"]);
            }

            $id = $this->input->post('id', TRUE);
            $this->load->model('group_model', 'group');
            if ($this->group->update_by_id($id, $data))
            {
                $result['r'] = 2;
            }
        } while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 删除权限
     */
    private function delete()
    {
        $result = ['r' => 0, 'm' => ''];
        do {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id', 'id', 'trim|greater_than[0]|max_length[11]|regex_match[/^[0-9]*$/]');
            if (!$this->form_validation->run()) {
                $result['m'] = '请填写完整信息';
                break;
            }
            $id = $this->input->post('id', true);
            $this->load->model('group_model', 'group');
            if ($this->group->deleteData(Group_model::T_GROUP, ['id' => $id, 'type !=' => AGENT_TYPE])) {
                $result['r'] = 2;
            }
        } while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 分配权限
     */
    public function rule($id)
    {
        if ( ! (is_numeric($id) && $id >= 0))
        {
            die;
        }
        $this->load->model('group_model', 'group');
        // 获取用户组数据
        $groupData = $this->group->get_by_id($id);
        $groupData['rules'] = explode(',', $groupData['rules']);
        // 获取规则数据
        $rulData = $this->group->getTreeData('level','id','title');
        $data = [
            'group_data'=>$groupData,
            'rule_data'=>$rulData,
            'navName' => $this->navName
        ];
        $this->load->view('group/rule', $data);
    }

    public function deal()
    {
        $result = ['r' => 0, 'm' => ''];
        do {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id', 'id', 'trim|greater_than_equal_to[0]|max_length[11]|regex_match[/^[0-9]+$/]');
            if ( ! $this->form_validation->run())
            {
                $result['m'] = '请填写完整信息';
                break;
            }
            $post = $this->input->post(NULL, TRUE);
            $rules = implode(',', $post['rule_ids']);
            $id = $post['id'];
            $this->load->model('group_model', 'group_model');
            if ($this->group_model->save_rules_by_id($id, $rules))
            {
                $result['r'] = 2;
            }
        } while(false);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}