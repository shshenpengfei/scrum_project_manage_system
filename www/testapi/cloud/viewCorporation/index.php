<?php

require '../../lib.php';

$open_ids = KeyValue::get(KEY_APP_ALL_CORPORATION);
$model = new CSCorpModel();
$data = array();
if (empty($open_ids)) {
    $data = array(
        msg => '还没有任何公司主号开启该app',
    );
} else {
    foreach ($open_ids as $open_id) {
        $a = $model->getCorpInfo($open_id);
        $data[$open_id]['info'] = $a;
        $tokens = $model->getAllToken($open_id);
        $data[$open_id]['tokens'] = $tokens;
    }
}
OpenUtils::outputJson($data);
