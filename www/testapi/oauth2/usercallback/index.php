<?php

//员工授权回跳
require '../../lib.php';

$ret = array(
    'ret' => 0,
    'msg' => '成功',
);
$oauth = OpenHelper::oauthUser();
//默认会从Get参数中拿到code去获得accesstoken
$result = $oauth->getAccessToken();
if ($result['ret'] == 0 && !empty($result['data'])) {   
    //如果获取accesstoken成功，则对该用户鉴权通过，记下用户在示例app登录信息
    $access_tokens = $result['data'];
    $openId = $access_tokens['open_id'];
    $companyId = '';
    if (isset($access_tokens['company_id'])) {
        $companyId = $access_tokens['company_id'];
    }
    $model = new CSCorpModel();
    $model->saveOpenId($openId, $companyId);
    TestUser::user()->login($openId);
    header('Location:../../');
} else {
    header('Location:../../');
}

