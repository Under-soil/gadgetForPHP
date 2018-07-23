<?php  $this->_extends('_layouts/default_layout'); ?>
<?php $this->_block('title'); echo $this->config->item('app_name'); ?>后台<?php $this->_endblock(); ?>
<?php  $this->_block('contents'); ?>
<?php  $this->_endblock(); ?>

