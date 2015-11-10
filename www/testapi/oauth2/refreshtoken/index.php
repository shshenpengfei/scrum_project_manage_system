<?php

require '../../lib.php';

$company_ids = KeyValue::get(KEY_APP_ALL_CORPORATION);

$model = new CSCorpModel();
$data = array();
foreach ($company_ids as $company_id) {
    $tokens = KeyValue::get(KEY_ACCESSTOKEN. $company_id);
    
    $result = $model->refreshToken($tokens['refresh_token']);
    
  
    if ($result != false) {
        $refresh_tokens = $result;
        $refresh_tokens['company_id'] = $tokens['company_id'];
        $refresh_tokens['is_open'] = $tokens['is_open'];
        saveToken($refresh_tokens);
    }
    $tokens_after = KeyValue::get(KEY_ACCESSTOKEN. $company_id);
    $data[$company_id]['刷新前'] = $tokens;
    $data[$company_id]['刷新结果'] = $result;
    $data[$company_id]['刷新后'] = $tokens_after;
}
OpenUtils::outputJson($data);



