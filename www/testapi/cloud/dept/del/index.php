<?php

require '../../../lib.php';

$openId = TestUser::user()->id();
$companyId = TestUser::user()->companyId();
$model = new CSCorpModel();
$api = OpenHelper::api();

$deptlist = $model->getDeptList($companyId);
$before = array();
if ($deptlist !== false) {
    $times = 10;
    do {
        $rand_index = rand(0, count($deptlist) - 1);
        $before = $deptlist[$rand_index];
    } while ($before['dept_id'] == 1 && $times--);
}

if (isset($rand_index) && $before['dept_id'] != 1) {
    $result = $api->delDept($companyId, $model->getToken($companyId), getClientIp(), $before['dept_id']);
}

$result = array(
    '删除组织架构信息' => $before,
    '删除结果' => $result,
);
OpenUtils::outputJson($result);
