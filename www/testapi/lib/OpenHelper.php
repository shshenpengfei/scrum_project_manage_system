<?php

/**
 * 提供openapi相关oauth和api的单例方法
 */
class OpenHelper {

    /**
     * 返回企业授权QqeimOAuth单例对象
     * @return QqeimOAuth
     */
    public static function oauthCompany() {
        if (empty(self::$_oauthCompany)) {
            self::$_oauthCompany = new QqeimOAuth(OpenConfig::APPID, OpenConfig::APPSECRET, OpenConfig::COMPANY_CALLBACK_URL);
        }
        return self::$_oauthCompany;
    }
    
    /**
     * 返回员工授权QqeimOAuth单例对象
     * @return QqeimOAuth
     */
    public static function oauthUser() {
        if (empty(self::$_oauthUser)) {
            self::$_oauthUser = new QqeimOAuth(OpenConfig::APPID, OpenConfig::APPSECRET, OpenConfig::USER_CALLBACK_URL);
        }
        return self::$_oauthUser;
    }

    /**
     * 返回QqeimApi单例对象
     * @return QqeimApi
     */
    public static function api() {
        if (empty(self::$_api)) {
            self::$_api = new QqeimApi(OpenConfig::APPID, OpenConfig::APPSECRET);
        }
        return self::$_api;
    }

    private static $_oauthCompany;
    private static $_oauthUser;
    private static $_api;

    private function __construct() {
        ;
    }

    private function __clone() {
        ;
    }

}

