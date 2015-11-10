<?php

require '../../../lib.php';

$openId = TestUser::user()->id();
$companyId = TestUser::user()->companyId();
$model = new CSCorpModel();
$api = OpenHelper::api();

$userlist = $model->getUserList($companyId);
$before = array();
if ($userlist !== false) {
    $times = 100;
    do {
        $rand_index = rand(0, count($userlist) - 1);
        $before = $userlist[$rand_index];
    } while ($before['open_id'] == $openId && $times--);
}

if (isset($rand_index) && $before['open_id'] != $openId) {
    $result = $api->delUser($companyId, $model->getToken($companyId), getClientIp(), $before['open_id']);
}

$result = array(
    '删除成员信息' => $before,
    '删除结果' => $result,
);
OpenUtils::outputJson($result);
