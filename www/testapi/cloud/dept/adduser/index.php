<?php

require '../../../lib.php';

$openId = TestUser::user()->id();
$companyId = TestUser::user()->companyId();
$model = new CSCorpModel();
$api = OpenHelper::api();

$accountrandom = 'testaccount' . rand(1, 999);
$namerandom = 'testname' . rand(1, 999);
$result = $api->addUser($companyId, $model->getToken($companyId), getClientIp(), $accountrandom, $namerandom);
$after = array();
if ($result['ret'] == 0) {
    $added_id = $result['data']['open_id'];
    $after = $model->getUserInfo($companyId, $added_id);
}
$result = array(
    '添加结果' => $result,
    '添加成员信息' => $after,
);
OpenUtils::outputJson($result);
