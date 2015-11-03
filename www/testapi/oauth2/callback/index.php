<?php
//sae_debug("in oath2/callback!!!!");
require '../../lib.php';

$ret = array(
    'ret' => 0,
    'msg' => '成功',
);
$oauth = OpenHelper::oauthCompany();
//默认会从Get参数中拿到code去获得companyToken
$result = $oauth->getCompanyToken();


if(OpenConfig::SAE_MODE) {
    $s = new SaeStorage();
    $s -> upload( OpenConfig::SAE_DOMAIN, 'data.dat' , '../../data.dat' );
}

if ($result['ret'] == 0 && !empty($result['data'])) {
    $company_token = $result['data'];
    $company_token['status'] = 0;
    saveToken($company_token);
} else {
    $ret['ret'] = 1;
    $ret['msg'] = '失败';
}

if(OpenConfig::SAE_MODE) {
    ini_set('display_errors',0);
    sae_debug(json_encode($ret));
    ini_set('display_errors',1);
}
OpenUtils::outputJson($ret);
