<?php

//负责接收 设置第三方应用的开通状态 http://第三方应用/api/corporation/statuschange 的开启关闭状态
require '../../lib.php';

$companyId = $_GET['company_id'];
$hashkey = $_GET['hashkey'];
$status = $_GET['status'];

if ($hashkey == md5($companyId . OpenConfig::APPID . OpenConfig::APPSECRET)) {
    $model = new CSCorpModel();
    $model->setStatus($companyId, $status);
    $data = array(
        'ret' => 0,
        'msg' => "关闭成功,({$status})",
    );
} else {
    $data = array(
        'ret' => 1,
        'msg' => "关闭失败,({$status})",
    );
}

OpenUtils::outputJson($data);