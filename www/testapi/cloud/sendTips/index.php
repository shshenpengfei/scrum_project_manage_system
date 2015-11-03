<?php

require '../../lib.php';

$openId = TestUser::user()->id();
$companyId = TestUser::user()->companyId();
$model = new CSCorpModel();
$api = OpenHelper::api();

$result = $api->sendTips($companyId, $model->getToken($companyId), getClientIp(), $openId, 'window_title_testapi', 'tips_title_testapi', 'tips_content_testapi,点击查看API文档', 'http://wiki.open.b.qq.com/api:start');
OpenUtils::outputJson($result);
