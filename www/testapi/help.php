<?php
require 'lib.php';
$data = array(
    'title' => '企业QQ开放平台示例APP及sdk须知',
    'step1' => '确认可以使用curl,当前：' . OpenUtils::checkCurlInstalled(),
    'step2' => '确认已注册企业QQ开放平台appid，将appid,appsecret与callbackurl填入OpenConfig文件',
    'step3' => '确认web服务器设置允许读取',
    'step4' => '将示例app部署之后，确认在https://id.b.qq.com/hrtx/app/index 中应用管理界面将企业QQ主号开通该App',
    'step5' => '使用某个员工企业QQ号码登录示例app，所有示例app操作都是针对该工号以及所在企业QQ主号',
    'step6' => '本示例仅供参考，忽略安全防范问题，实际开发过程中开发者需要把握',
);
header('Content-Type: application/json; charset=UTF-8') ;
echo json_encode($data);