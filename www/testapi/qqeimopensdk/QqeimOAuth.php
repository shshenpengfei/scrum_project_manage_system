<?php
/**
 * 封装oauth相关api的类
 */
class QqeimOAuth {

    const VERSION = 1.0;
    const AUTHORIZE_URL = 'http://openapi.b.qq.com/oauth2/authorize';
    const TOKEN_URL = 'http://openapi.b.qq.com/oauth2/token';
    
    const COMPANY_TOKEN_URL = 'http://openapi.b.qq.com/oauth2/companyToken';
    const COMPANY_REFRESH_URL = 'http://openapi.b.qq.com/oauth2/companyRefresh';

    private $_appId;
    private $_appSecret;
    private $_redirectUrl;
    private $_state;

    /**
     * 封装oauth相关api的类
     * @param int $app_id app_id
     * @param string $app_secret app_secret
     * @param string $redirect_url_company 企业授权redirect_url（在开放平台注册的url）
     * @param string $redirect_url_user 员工授权redirect_url
     */
    public function __construct($app_id, $app_secret, $redirect_url) {
        $this->_appId = $app_id;
        $this->_appSecret = $app_secret;
        $this->_redirectUrl = $redirect_url;
        $this->_state = md5(time());
    }
    
    /**
     * 根据redirecturl获取授权url
     * @return string
     */
    public function getAuthorizeUrl() {        
        $query = http_build_query(
                array(
                    'response_type' => 'code',
                    'app_id' => $this->_appId,
                    'redirect_uri' => urlencode($this->_redirectUrl),
                    'state' => $this->_state,
                )
        );
        return self::AUTHORIZE_URL . '?' . $query;
    }
   
    /**
     * 根据authcode授权码从开放平台获取accesstoken
     * @return array ('ret' => int	 返回码：0 正常， >0 异常
     *                  'msg' => string	 如果ret不为0，会有相应的错误信息提示，UTF-8编码。
     *                  'data' => object JS对象格式的数据array ('access_token', 'expires_in', 'state', 'open_id', 'refresh_token');  
     *              );
     */
    protected function getToken($authCode = false, $url){
        $authCode = $authCode ? $authCode : $_GET['code'];
        $query = array(
            'grant_type' => 'authorization_code',
            'app_id' => $this->_appId,
            'app_secret' => $this->_appSecret,
            'code' => $authCode,
            'state' => $this->_state,
            'redirect_uri' => $this->_redirectUrl,
        );
        $data = $this->doHttpRequest($url, $query, false);
        return $data === false ? false : @json_decode($data, true);
    }
    
    public function getAccessToken($authCode = false) {
        return $this -> getToken($authCode, self::TOKEN_URL);
    }
    
    public function getCompanyToken($authCode = false) {
       return $this -> getToken($authCode, self::COMPANY_TOKEN_URL);
    }

    /**
     * 刷新access token
     * @param string $refreshToken
     * @return array ('ret' => int	 返回码：0 正常， >0 异常
     *                  'msg' => string	 如果ret不为0，会有相应的错误信息提示，UTF-8编码。
     *                  'data' => object JS对象格式的数据array ('access_token', 'expires_in','refresh_token');  
     *              );
     */
    public function refreshAccessToken($refreshToken) {
        $query = array(
            'app_id' => $this->_appId,
            'app_secret' => $this->_appSecret,
            'refresh_token' => $refreshToken,
        );

        $data = $this->doHttpRequest(self::COMPANY_REFRESH_URL, $query, false);

        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 根据参数发起curl请求
     * @param string $url url
     * @param $array $query 参数array('key' => 'value')
     * @param boolean $usePost 是否使用post请求 默认true使用post方式 
     * @return string result or false
     */
    public function doHttpRequest($url, $query, $usePost = true) {
        $result = false;
        if ($usePost) {
            $options = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($query),
            );
        } else {
            $options = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 10,
            );
            $url = $url . '?' . http_build_query($query);
        }
        $curl = curl_init($url);
        if (curl_setopt_array($curl, $options)) {
            $result = curl_exec($curl);
        }
        curl_close($curl);
        return $result;
    }

}

