<?php

/**
 * 提供json格式化输出以及检测curl是否安装
 */
class OpenUtils {
    /**
     * 提供json格式化输出
     * @param string $json_data
     */
    public static function outputJson($json_data = array()) {
        @header("Cache-Control: no-cache, must-revalidate");
        @header("Pragma: no-cache");
        @header("Content-Type:application/json");      
        
        echo @json_encode($json_data);
    }

    /**
     * 检测curl是否安装
     * @return string
     */
    public static function checkCurlInstalled() {
        if (function_exists('curl_init')) {
            return '支持curl';
        } else {
            return '不支持curl';
        }
    }

}
