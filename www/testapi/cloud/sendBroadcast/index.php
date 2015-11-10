<?php

require '../../lib.php';

$openId = TestUser::user()->id();
$companyId = TestUser::user()->companyId();
$model = new CSCorpModel();
$api = OpenHelper::api();

$result = $api->sendBroadCast($companyId, $model->getToken($companyId), getClientIp(), 'broadcast_title_testapi', 'broadcast_content_testapi', '1', '');
OpenUtils::outputJson($result);
