<?php

require '../../../lib.php';

$openId = TestUser::user()->id();
$companyId = TestUser::user()->companyId();
$model = new CSCorpModel();
$api = OpenHelper::api();

$result = $api->getUserQq($companyId, $model->getToken($companyId), getClientIp(), $openId);
OpenUtils::outputJson($result);