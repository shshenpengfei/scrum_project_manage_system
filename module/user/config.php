<?php
$config->user=new stdClass();
$config->user->create = new stdClass();
$config->user->edit = new stdClass();
$config->user->create->requiredFields = 'account,realname,password,password1,password2';
$config->user->edit->requiredFields   = 'account,realname';
