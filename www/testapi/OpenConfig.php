<?php

/**
 * app相关配置参数
 */
class OpenConfig {

    const APPID = '200459371';
    const APPSECRET = 'K8cgDdPgZU6Dl6s0';
    //账户中心开通第三方App回调url
    const COMPANY_CALLBACK_URL = 'http://pm.wochacha.cn/';
    //员工登录App回调url
    const USER_CALLBACK_URL = 'http://pm.wochacha.cn/';
    
    //默认是较安全的情形，无法通过php文件查看模拟存储的数据
    const SAFE_MODE = true;
    
    //基于sae storage的特殊性，修改文件读写的api
    const SAE_MODE = false;
    const SAE_DOMAIN = 'test';
}

