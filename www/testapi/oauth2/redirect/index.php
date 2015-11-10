<?php

//单点登录，客户端点击第三方icon调转
require '../../lib.php';

$companyId = $_GET['company_id'];
$hashkey = $_GET['hashkey'];
$openId = $_GET['open_id'];
$to_open_id = $_GET['to_open_id'];
$hashskey = $_GET['hashskey'];
$returnurl = $_GET['returnurl'];

if ($hashkey == md5($companyId . OpenConfig::APPID . OpenConfig::APPSECRET) && $returnurl == 1) {
    $model = new CSCorpModel();
    $api = OpenHelper::api();
    $result = $api->verifyLoginHashskey($companyId, $model->getToken($companyId), getClientIp(), $openId, $hashskey);
    if($result['ret'] == 0){
        $api->pushNotifyCenter2Client($companyId, $model->getToken($companyId), getClientIp(), $openId);
        TestUser::user()->login($openId);
        header('Location:../../');
    }else{
        echo $result['msg'];
    }
} else {
    echo "单点登录失败,hashkey失效";
}

