<?php

require '../../../lib.php';

$openId = TestUser::user()->id();
$companyId = TestUser::user()->companyId();
$model = new CSCorpModel();
$api = OpenHelper::api();
$before = $model->getUserInfo($companyId, $openId);
$name = 'testrandom'. rand(1, 100);
@$result = $api->modUser($companyId, $model->getToken($companyId), getClientIp(), $openId, $before['account'], $name, null, null);
$after = $model->getUserInfo($companyId, $openId);
$result = array(
    '修改前' => $before,
    '修改结果' => $result,
    '修改后' => $after,
);
OpenUtils::outputJson($result);
