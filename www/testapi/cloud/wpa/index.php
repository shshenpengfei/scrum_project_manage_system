<?php

require '../../lib.php';

$openId = TestUser::user()->id();
$companyId = TestUser::user()->companyId();
$model = new CSCorpModel();
$api = OpenHelper::api();

$result = $api->getWpaButton($companyId, $model->getToken($companyId),getClientIp(), $openId, 'rich', 'wpatitle', 'wpadesc富文本上下文', 'http://b.qq.com/', 'http://combo.b.qq.com/bqq/v4/images/logo.png',1);
OpenUtils::outputJson($result);

