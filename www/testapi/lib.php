<?php

//提供了示例app所需要的一些数据存储，以及数据model等
$_SERVER['LIB_FILE'] = dirname(__FILE__);
require_once ($_SERVER['LIB_FILE'] . '/qqeimopensdk/sdkrequire.php');
require_once ($_SERVER['LIB_FILE'] . '/OpenConfig.php');
require_once ($_SERVER['LIB_FILE'] . '/lib/OpenHelper.php');
require_once ($_SERVER['LIB_FILE'] . '/lib/OpenUtils.php');

        const KEY_USER_LIST_BY_COMPANY = 'testapi_userlist_by_company';
        const KEY_ACCESSTOKEN = 'testapi_company_token_';
        const KEY_APP_ALL_CORPORATION = 'testapi_app_all_corporation';
        const KEY_OPEN_ID_MAP_CORPORATION = 'testapi_open_id_map_corporation';

        const SESSION_COMPANY_ID = 'company_id';
        const SESSION_OPEN_ID = 'open_id';

function logapi($log) {
    if (is_array($log)) {
        $log = var_export($log, true);
    }
    file_put_contents($_SERVER['LIB_FILE'] . '/api.log', date('Y-m-d H:i:s ||') . $log . "\n", FILE_APPEND);
}

function getClientIp() {
    return '127.0.0.1';
}

class FileHandler{
    
    public static function getFileContent($filename) {
        if(OpenConfig::SAE_MODE) {
            $s = new SaeStorage();
            $data = $s->read(OpenConfig::SAE_DOMAIN,$filename);
        }else{
            $data = file_get_contents ($filename);
        }
        return $data; 
    }

    public static function putFileContent($filename, $content){
        if(OpenConfig::SAE_MODE) {
            $s = new SaeStorage();
            $s->write(OpenConfig::SAE_DOMAIN, $filename, $content);
        }else{
            $data = file_put_contents ($filename, $content);
        }
    }
}

/**
 * 示例app，将$tokenInfo数组存储
 * @param array $tokenInfo
 */
function saveToken($tokenInfo) {
    $key = KEY_ACCESSTOKEN . $tokenInfo['company_id'];
    KeyValue::hSet($key, 'company_id', $tokenInfo['company_id']);
    KeyValue::hSet($key, 'company_token', $tokenInfo['company_token']);
    KeyValue::hSet($key, 'expires_in', $tokenInfo['expires_in']);
    KeyValue::hSet($key, 'refresh_token', $tokenInfo['refresh_token']);
    KeyValue::hSet($key, 'is_open', '1');
    if (isset($tokenInfo['status'])) {
        KeyValue::hSet($key, 'status', $tokenInfo['status']);
    }
    KeyValue::hSet($key, 'last_modify', time());
    
    $allkey = KEY_APP_ALL_CORPORATION;
    KeyValue::sAdd($allkey, $tokenInfo['company_id']);
}

/**
 * 模拟keyvalue存储
 */
class KeyValue {

    public static function DATA_FILE() {
        //return $_SERVER['LIB_FILE'] . '/data.dat';
        return 'data.dat';
    }

    public static function set($key, $value) {
        $data = FileHandler::getFileContent(self::DATA_FILE());
        
        if ($data) {
            $dataarray = json_decode($data, true);
        } else {
            echo '读取data.dat文件失败';
            exit;
        }
        $dataarray[$key] = $value;
        FileHandler::putFileContent(self::DATA_FILE(), json_encode($dataarray));
        return true;
    }

    public static function hSet($key, $hkey, $value) {
        $data = FileHandler::getFileContent(self::DATA_FILE());
        
        if ($data) {
            $dataarray = json_decode($data, true);
        } else {
            echo '读取data.dat文件失败';
            exit;
        }
        $dataarray[$key][$hkey] = $value;
        FileHandler::putFileContent(self::DATA_FILE(), json_encode($dataarray));
        return true;
    }

    public static function sAdd($key, $value) {
        $data = FileHandler::getFileContent(self::DATA_FILE());
        if ($data) {
            $dataarray = json_decode($data, true);
        } else {
            echo '读取data.dat文件失败';
            exit;
        }
        $dataarray[$key][] = $value;
        $dataarray[$key] = array_unique($dataarray[$key]);
        FileHandler::putFileContent(self::DATA_FILE(), json_encode($dataarray));
        return true;
    }

    public static function get($key) {
        $data = FileHandler::getFileContent(self::DATA_FILE());
        if (!$data) {
            echo '读取data.dat文件失败';
            exit;
        }
        $dataarray = json_decode($data, true);
        if (isset($dataarray[$key])) {
            return $dataarray[$key];
        } else {
            return false;
        }
    }

    public static function hget($key, $hkey) {
        $data = FileHandler::getFileContent(self::DATA_FILE());
        if (!$data) {
            return false;
        }
        $dataarray = json_decode($data, true);
        if (isset($dataarray[$key][$hkey])) {
            return $dataarray[$key][$hkey];
        } else {
            return false;
        }
    }

}

/**
 * 示例app，企业model
 */
class CSCorpModel {

    public $companyId;

    public function __construct($companyId = NULL) {
        $this->companyId = $companyId;
    }

    public function getCorpInfo($companyId = NULL) {
        if (empty($companyId)) {
            $companyId = $this->companyid;
        }

        if (!empty($companyId)) {
            $token = $this->getToken($companyId);
            if ($token !== false) {
                return OpenHelper::api()->getCorporationInfo($companyId, $token, getClientIp());
            }
        }

        return false;
    }

    public function setStatus($companyId, $status) {
        KeyValue::hSet(KEY_ACCESSTOKEN . $companyId, 'status', $status);
    }

    public function getToken($companyId) {
        $tokens = $this->checkToken($companyId);
        return $tokens['company_token'];
    }

    public function getAllToken($companyId) {
        $tokens = $this->checkToken($companyId);
        return $tokens;
    }

    public function getUserList($companyId) {
        $userlist = OpenHelper::api()->getUserList($companyId, $this->getToken($companyId), getClientIp());
        if ($userlist['ret'] == 0) {
            return $userlist['data']['items'];
        } else {
            return false;
        }
    }

    public function getUserInfo($companyId, $openId) {
        $userlist = $this->getUserList($companyId);
        $userinfo = array();
        if ($userlist !== false) {
            foreach ($userlist as $key => $info) {
                if ($info['open_id'] == $openId) {
                    $userinfo = $info;
                    break;
                }
            }
        }
        return $userinfo;
    }

    public function getDeptList($companyId) {
        $result = OpenHelper::api()->getDeptList($companyId, $this->getToken($companyId), getClientIp());
        $deptlist = false;
        if ($result['ret'] == 0) {
            $deptlist = $result['data']['items'];
        }
        return $deptlist;
    }

    public function saveOpenId($openId, $companyId) {
        if (!empty($openId)) {
            KeyValue::set(KEY_OPEN_ID_MAP_CORPORATION . $openId, $companyId);
        }
    }

    public function getCompanyIdByOpenId($openId) {
        return KeyValue::get(KEY_OPEN_ID_MAP_CORPORATION . $openId);
    }

    protected function checkToken($companyId) {
        $tokens = KeyValue::get(KEY_ACCESSTOKEN . $companyId);
        if ($tokens['expires_in'] + $tokens['last_modify'] < time()) {
            $refresh_tokens = $this->refreshToken($tokens['refresh_token']);
            if ($refresh_tokens != false) {
                $refresh_tokens['open_id'] = $tokens['open_id'];
                $refresh_tokens['is_open'] = $tokens['is_open'];
                saveToken($refresh_tokens);
                $tokens = $refresh_tokens;
            }
        }
        return $tokens;
    }

    public function refreshToken($refresh_token) {
        $oauth = OpenHelper::oauthCompany();
        $result = $oauth->refreshAccessToken($refresh_token);
        if ($result['ret'] == 0) {
            $refresh_tokens = $result['data'];
        } else {
            $refresh_tokens = false;
        }
        return $refresh_tokens;
    }

}

/**
 * 示例app中负责用户登录的类
 */
class TestUser {

    const USER_ID = 'user_id';

    private static $_instance = null;

    /**
     * 
     * @return TestUser
     */
    public static function user() {
        if (empty(self::$_instance)) {
            self::$_instance = new TestUser();
        }
        return self::$_instance;
    }

    public function login($open_id) {
        setcookie(self::USER_ID, $open_id, time()+3600, '/');
    }

    public function logout() {
        setcookie(self::USER_ID, 1, time()-3600, '/');
    }

    public function isLogin() {
        return isset($_COOKIE[self::USER_ID]);
    }

    public function id() {
        $id = '';
        if (isset($_COOKIE[self::USER_ID])) {
            $id = $_COOKIE[self::USER_ID];
        }
        return $id;
    }

    public function companyId() {
        $companyId = '';
        if ($this->id() !== '') {
            $model = new CSCorpModel();
            $companyId = $model->getCompanyIdByOpenId($this->id());
        } else {
            $open_ids = KeyValue::get(KEY_APP_ALL_CORPORATION);
            $companyId = $open_ids[0];
        }
        return $companyId;
    }

}
