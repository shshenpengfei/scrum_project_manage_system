<?php
define('OAUTH2_TOKEN', 'https://openapi.b.qq.com/oauth2/companyToken');
define('OPEN_CALLBACKURL', 'http://pm.wochacha.cn/open_callback.php'); //此URL需要登记到企业QQ
if (isset($_GET['code'])) {
    $code = $_GET['code'];
	$fb = fopen("1.txt","a");
	fwrite($fb,$code."\n");
	$query = array(
		'grant_type' => 'authorization_code',
		'app_id' => 200459371,
		'app_secret' => 'K8cgDdPgZU6Dl6s0',
		'code' => $code,
		'state' => md5(rand()),
		'redirect_uri' => OPEN_CALLBACKURL,
	);

	$options = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CONNECTTIMEOUT => 10,
		CURLOPT_TIMEOUT => 10,
		CURLOPT_SSL_VERIFYPEER=>0,	//不能发出https的一种解决方式
	);

	$url = OAUTH2_TOKEN . '?' . http_build_query($query);
	$curl = curl_init($url);
	if (curl_setopt_array($curl, $options)) {
		$result = curl_exec($curl);
		fwrite($fb,$result);
	}
    curl_close($curl);

	fclose($fb);
	
    if (false !== $result) {
        //$company_info = json_decode($result);
        //$company_info = json_decode($result, true); //这样子就可以解决  开通代码不允许执行到ret=0的一个问题 

        //$company_id = $company_info['data']['company_id'];
        //$company_token = $company_info['data']['company_token'];
        //$time = time();
        //$expires_in = $company_info['data']['expires_in'];
        //$refresh_token = $company_info['data']['refresh_token'];
        //@todo: 将$company_id, $company_token, $time, $refresh_token, $expires_in存储下来
        
        echo json_encode(array('ret' => 0)); //开放平台读到这个信息，就会开通成功
		//可直接返回$result，因为包含ret=0
        die();
    }
}
//fclose($fb);
echo json_encode(array('ret' => -1)); //读到这个信息，或者没有读到信息，会开通失败
die();
