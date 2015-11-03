<?php
require '../../../lib.php';

$openId = TestUser::user()->id();
$companyId = TestUser::user()->companyId();
$model = new CSCorpModel();
$api = OpenHelper::api();
$userlist = $api->getUserList($companyId, $model->getToken($companyId), getClientIp());
OpenUtils::outputJson($userlist);