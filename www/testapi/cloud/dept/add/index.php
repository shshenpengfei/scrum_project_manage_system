<?php

require '../../../lib.php';

$openId = TestUser::user()->id();
$companyId = TestUser::user()->companyId();
$model = new CSCorpModel();
$api = OpenHelper::api();

$namerandom = 'testdeptname' . rand(1, 999);
$result = $api->addDept($companyId, $model->getToken($companyId), getClientIp(), $namerandom);
$after = $api->getDeptList($companyId, $model->getToken($companyId), getClientIp());

$result = array(
    '添加结果' => $result,
    '添加后组织架构列表' => $after,
);
OpenUtils::outputJson($result);
