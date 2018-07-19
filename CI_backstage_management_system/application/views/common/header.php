<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>
        <?php echo $this->config->item('app_name'); ?>- 管理后台
    </title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="<?php echo $this->config->item('statics_path'); ?>/aceadmin/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo $this->config->item('statics_path'); ?>/aceadmin/css/ace-skins.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/font-awesome-4.7.0/css/font-awesome.min.css"/>
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/aceadmin/css/font-awesome-ie7.min.css"/><![endif]-->
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/aceadmin/css/ace.min.css"/>
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/aceadmin/css/ace-ie.min.css"/><![endif]--><!--[if lt IE 9]>
    <script src="<?php echo $this->config->item('statics_path'); ?>/aceadmin/js/html5shiv.js"></script>
    <script src="<?php echo $this->config->item('statics_path'); ?>/aceadmin/js/respond.min.js"></script><![endif]-->
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/bsgrid/merged/bsgrid.all.min.css"/>
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/public/css/base.css"/>
    <link rel="stylesheet" href="<?php echo $this->config->item('statics_path'); ?>/layui/css/layui.css"/>
    <!--[if !IE]> -->
    <script src="<?php echo $this->config->item('statics_path'); ?>/js/jquery-1.10.2.min.js"></script><![endif]--><!--[if !IE]> -->
    <!-- <![endif]--><!--[if IE]>
    <script type="text/javascript">
        window.jQuery || document.write("<script src='<?php echo $this->config->item('statics_path'); ?>/js/jquery-1.10.2.min.js'>" + "<" + "script>");
    </script><![endif]-->
    <script src="<?php echo $this->config->item('statics_path'); ?>/layui/layui.js"></script>
    <script type="text/javascript">
        if ("ontouchend" in document) document.write("<script src='<?php echo $this->config->item('statics_path'); ?>/aceadmin/js/jquery.mobile.custom.min.js'>" + "</" + "script>");
    </script>

    <style type="text/css">
        #sidebar .nav-list {
            overflow-y: auto;
        }
        .b-nav-li {
            padding: 5px 0;
        }
        .layui-form{
            float: left;
            padding: 20px;
        }
        @media (max-width: 767px){
            .layui-form{
                float: left;
                padding: 5px;
            }
        }
        .layui-form-pane .layui-form-label{
            width: 95px;
        }
        @media screen and (max-width: 320px){
            .layui-form-pane .layui-form-label{
                width: 85px;
            }
            .layui-layer{
                width: 300px;
                left: 10px;
            }
            .layui-layer .layui-form-label{
                padding-left: 5px;
                padding-right: 5px;
                width: 80px;
            }
            .layui-layer .layui-input{
                width;200px;!important;
                margin-left: 0px;
            }
        }
        .main-content .bsgrid{
            margin: 20px;
        }
        .bsgridPagingOutTab{
            margin-left: 20px;
        }
        .page-header h1{
            font-size: 18px;
        }
        #searchTable_pt_outTab{
            margin-top: -20px;
        }
        .user-info{
            line-height: 18px;
        }
        .layui-input{
            width: 140px;
        }
        .layui-unselect ,.layui-form-select{
            width: 140px;
        }
        .layui-btn {
            margin-top: -5px;
        }

        ::-ms-clear,::-ms-reveal{display:none;}
        .dropdown-modal{
            float: right;!important;
        }
    </style>
</head>
