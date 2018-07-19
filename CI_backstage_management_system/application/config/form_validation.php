<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config = array(
    'username' => array(
        array(
            'field' => 'username',
            'label' => '用户名',
            'rules' => 'trim|required|max_length[20]'
        ),
    ),
    'passwd' => array(
        array(
            'field' => 'passwd',
            'label' => '密码',
            'rules' => 'trim|required'
        ),
    ),
    'captcha' => array(
        array(
            'field' => 'captcha',
            'label' => '验证码',
            'rules' => 'strtolower|trim|required|regex_match[/^[0-9]{4}$/]'
        ),
    ),
    'realname' => array(
        array(
            'field' => 'realname',
            'label' => '真实姓名',
            'rules' => 'trim|required|max_length[4]'  //todo 正则校验
        ),
    ),
    'phone' => array(
        array(
            'field' => 'phone',
            'label' => '手机号',
            'rules' => 'rim|required|regex_match[/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/]'
        ),
    ),
    'wechat' => array(
        array(
            'field' => 'wechat',
            'label' => '微信',
            'rules' => 'rim|required|regex_match[/^[a-zA-Z1-9]{1}[-_a-zA-Z0-9]{5,19}$/]'
        ),
    ),
    'appuid' => array(
        array(
            'field' => 'appuid',
            'label' => '游戏用户ID',
            'rules' => 'trim|required|max_length[8]'  //todo 正则
        ),
    ),
    'level' => array(
        array(
            'field' => 'level',
            'label' => '推广员级别',
            'rules' => 'trim|required|in_list[0,1,2,3]'
        ),
    ),
    'address' => array(
        array(
            'field' => 'address',
            'label' => '地址',
            'rules' => 'trim|max_length[128]'
        ),
    ),
    'id' => array(
        array(
            'field' => 'id',
            'label' => 'ID',
            'rules' => 'trim|required|is_natural_no_zero'
        ),
    ),
    'uid' => array(
        array(
            'field' => 'uid',
            'label' => '用户ID',
            'rules' => 'trim|required|is_natural_no_zero'
        ),
    ),
	'code' => array(
        array(
            'field' => 'code',
            'label' => '推广码',
            'rules' => 'trim|regex_match[/^[1-9][0-9]{3,4}$/]'
        ),
    ),
    'pcode' => array(
        array(
            'field' => 'pcode',
            'label' => '上级推广码',
            'rules' => 'trim|regex_match[/^[1-9][0-9]{3,4}$/]'
        ),
    ),
	'page' => array(
		array(
			'field' => 'pageSize',
			'label' => '每页显示数量',
			'rules' => 'trim|required|is_natural_no_zero'
		),
		array(
			'field' => 'curPage',
			'label' => '当前页数',
			'rules' => 'trim|required|is_natural_no_zero'
		),
	),
    'date' => array(
        array(
            'field' => 'range_s',
            'label' => '开始时间',
            'rules' => 'trim|regex_match[/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/]'
        ),
        array(
            'field' => 'range_e',
            'label' => '结束时间',
            'rules' => 'trim|regex_match[/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/]'
        ),
    ),
    'datetime' => array(
        array(
            'field' => 'range_s',
            'label' => '开始时间',
            'rules' => 'trim'
        ),
        array(
            'field' => 'range_e',
            'label' => '结束时间',
            'rules' => 'trim'
        ),
    ),
    'group_add' => array(
        array(
            'field' => 'title',
            'label' => '分组名',
            'rules' => 'trim|required|max_length[50]|regex_match[/^[A-Za-z\d\x{4e00}-\x{9fa5}]{2,15}$/u]', //只允许 汉字 大小写字母 数字 2-15
        ),
    ),
    'group_edit' => array(
        array(
            'field' => 'id',
            'label' => 'ID',
            'rules' => 'trim|required|is_natural_no_zero'
        ),
        array(
            'field' => 'title',
            'label' => '分组名',
            'rules' => 'trim|required|max_length[50]|regex_match[/^[A-Za-z\d\x{4e00}-\x{9fa5}]{2,15}$/u]',
        ),
    ),
    'rule_add' => array(
        array(
            'field' => 'pid',
            'label' => 'pid',
            'rules' => 'trim|greater_than_equal_to[0]|regex_match[/^[0-9]{1,11}$/]',
            'errors' => ['regex_match' => '{field}格式不正确','greater_than_equal_to'=>'{field}必须大于等于{param}']
        ),
        array(
            'field' => 'name',
            'label' => '权限',
            'rules' => 'trim|required|regex_match[/^[a-z][a-z_\/]{0,78}[a-z]$/]|is_unique['.T_RULE.'.name]',
            'errors' => ['required'=>'{field}不能为空','regex_match' => '{field}格式不正确','is_unique'=>'{field}已存在']
        ),
        array(
            'field' => 'title',
            'label' => '权限名',
            'rules' => 'trim|required|max_length[20]|is_unique['.T_RULE.'.title]',
            'errors' => ['required'=>'{field}不能为空','is_unique'=>'{field}已存在','max_length'=>'{field}最大长度为{param}']
        ),
        array(
            'field' => 'ico',
            'label' => '图标',
            'rules' => 'trim',
        ),
        array(
            'field' => 'order_number',
            'label' => '排序',
            'rules' => 'trim|regex_match[/^[0-9]*$/]',
            'errors' => ['regex_match'=>'{field}格式不正确']
        ),
    ),
    'rule_edit' => array(
        array(
            'field' => 'id',
            'label' => 'id',
            'rules' => 'trim|greater_than_equal_to[0]|regex_match[/^[0-9]+$/]',
            'errors' => ['regex_match' => '{field}格式不正确','greater_than_equal_to'=>'{field}必须大于等于{param}']
        ),
        array(
            'field' => 'name',
            'label' => '规则',
            'rules' => 'trim|required|regex_match[/^[a-z][a-z_\/]{0,78}[a-z]$/]',
            'errors' => ['required'=>'{field}不能为空','regex_match' => '{field}格式不正确']
        ),
        array(
            'field' => 'title',
            'label' => '权限名',
            'rules' => 'trim|required|max_length[20]',
            'errors' => ['required'=>'{field}不能为空','max_length'=>'{field}最大长度为{param}']
        ),
        array(
            'field' => 'ico',
            'label' => '图标',
            'rules' => 'trim',
        ),
        array(
            'field' => 'order_number',
            'label' => '排序',
            'rules' => 'trim|regex_match[/^[0-9]*$/]',
            'errors' => ['regex_match'=>'{field}格式不正确']
        ),
    ),
    'rule_id' => array(
        array(
            'field' => 'id',
            'label' => 'ID',
            'rules' => 'trim|greater_than[0]|max_length[11]|regex_match[/^[0-9]*$/]',
            'errors' => ['regex_match' => '{field}格式不正确','greater_than_equal_to'=>'{field}必须大于等于{param}','max_length'=>'{field}最大长度为{param}']
        ),
    ),
    'game' => array(
        array(
            'field' => 'game_type',
            'label' => '游戏类型',
            'rules' => 'numeric'
        ),
    ),
    'diamond' => array(
        array(
            'field' => 'num',
            'label' => '加钻数量',
            'rules' => 'trim|required|integer|greater_than[0]|less_than_equal_to[1000]',
            'errors' => ['less_than_equal_to' => '{field}必须要小于{param}个']
        ),
        array(
            'field' => 'desc',
            'label' => '加钻原因',
            'rules' => 'trim|required|max_length[200]|regex_match[/^[a-zA-Z0-9\x{4e00}-\x{9fa5}]+$/u]',
            'errors' => ['regex_match' => '{field}格式不正确','max_length'=>'{field}最大长度为{param}']
        ),
    ),
    'withdraw_state' => array(
        array(
            'field' => 'state',
            'label' => '取款状态',
            'rules' => 'trim|in_list[0,1,2]'
        ),
    ),
    'query_appuid' => array(
        array(
            'field' => 'appuid',
            'label' => '游戏用户ID',
            'rules' => 'trim|max_length[8]|regex_match[/^\d{8}$/]'
        ),
    ),
    'query_realname' => array(
        array(
            'field' => 'realname',
            'label' => '真实姓名',
            'rules' => 'trim|max_length[4]'  //todo 正则校验
        ),
    ),
    'query_agent_code' => array(
        array(
            'field' => 'agent_code',
            'label' => '邀请码',
            'rules' => 'trim|integer'
        ),
    ),
    'query_f_code' => array(
        array(
            'field' => 'f_code',
            'label' => '返佣邀请码',
            'rules' => 'trim|integer'
        ),
    ),
    'notice' => array(
        array(
            'field' => 'type',
            'label' => '公告类型',
            'rules' => 'trim|required|in_list[-1,0]',
            'errors' => ['in_list' => '{field}数值不正确']
        ),
        array(
            'field' => 'color',
            'label' => '播放范围',
            'rules' => 'trim|required|in_list[1,2]',
            'errors' => ['in_list' => '{field}数值不正确']
        ),
        array(
            'field' => 'msg',
            'label' => '公告内容',
            'rules' => 'trim|required',
            'errors' => ['required' => '{field}不能为空']
        ),
        array(
            'field' => 'msg_id',
            'label' => '公告ID',
            'rules' => 'trim|required|integer',
            'errors' => ['integer' => '{field}不是整数']
        ),
        array(
            'field' => 'pid',
            'label' => '区域ID',
            'rules' => 'trim|required',
            'errors' => ['required' => '{field}不能为空']
        ),
        array(
            'field' => 'id',
            'label' => '公告ID',
            'rules' => 'trim|required|integer',
            'errors' => ['required' => '{field}不能为空', 'integer' => '{field}不是整数']
        ),
        array(
            'field' => 'opt',
            'label' => '操作',
            'rules' => 'trim|required',
            'errors' => ['required' => '{field}不能为空']
        ),
    ),
);