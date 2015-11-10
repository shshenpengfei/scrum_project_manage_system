<?php

require '../../lib.php';

$openId = TestUser::user()->id();
$companyId = TestUser::user()->companyId();
$model = new CSCorpModel();
$api = OpenHelper::api();

$result = $api->pushNotifyCenter2Client($companyId, $model->getToken($companyId), getClientIp(), $openId, array(array('ha', 1), array('fd', 5)));
OpenUtils::outputJson($result);
