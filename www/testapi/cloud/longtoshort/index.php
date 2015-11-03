<?php

require '../../lib.php';

$openId = TestUser::user()->id();
$companyId = TestUser::user()->companyId();
$model = new CSCorpModel();
$api = OpenHelper::api();

$result = $api->urlLong2Short($companyId, $model->getToken($companyId), getClientIp(), array("http://wiki.open.b.qq.com", "http://b.qq.com"));
OpenUtils::outputJson($result);
