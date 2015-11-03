<?php
require './lib.php';

if (OpenConfig::APPID == '' || OpenConfig::APPSECRET == '' || OpenConfig::COMPANY_CALLBACK_URL == '' || OpenConfig::USER_CALLBACK_URL == '') {
    header("Content-type: text/html; charset=utf-8");
    echo '请先修改OpenConfig文件，填好APPID, APPSECRET, COMPANY_CALLBACK_URL, USER_CALLBACK_URL~有不理解之处请查看<a href="http://wiki.open.b.qq.com/api:start#api%E8%B0%83%E7%94%A8%E8%8C%83%E4%BE%8B%E4%BB%A3%E7%A0%81">开放平台示例使用说明.pptx</a>';
    exit;
}

$url = OpenHelper::oauthUser()->getAuthorizeUrl();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>企业QQ开放平台示例APP</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="./cloud/assets/css/testapicss.css" />
    </head>
    <body>
        <div class="banner">
            <a class="btn-brand" style="vertical-align:middle;" href='http://wiki.open.b.qq.com/start' target="_blank" title="API文档">企业QQ开放平台</a>
            <?php
            if (TestUser::user()->isLogin()):
                ?>
                <label for="openid">当前登录open_id:</label>
                <span><?php echo TestUser::user()->id(); ?></span> 
                <label for="companyid" >company_id:</label>
                <span><?php echo TestUser::user()->companyId(); ?></span>
                <a class="btn-violet btn-login" href="./cloud/logout.php">退出登录</a>
                <?php
            else:
                ?>
                <span style="margin-left: 20px;vertical-align:middle;">请登录:</span>
                <a href="<?php echo $url ?>" target="_blank"><img style="vertical-align:middle;" src="./cloud/assets/images/qqeim_login.gif"/></a>
                <span class="hintlogin"><==&nbsp;使用示例APP请先登录</span>
            <?php
            endif;
            ?>
        </div>
        <div class="metro">
            <div class="btn btn-black btn-one" href="javascript:void(0);" url="./help.php">使用引导</div>
            <div class="btn btn-red btn-one" href="javascript:void(0);" url="./db.php">查看数据存储</div>
            <div class="btn btn-blue btn-two" href="javascript:void(0);" url="./oauth2/refreshtoken/" >/oauth2/refresh<br>刷新access_token</div>
            <div class="btn btn-violet btn-two" href="javascript:void(0);" url="./cloud/viewCorporation/" >/api/corporation/get<br>获取企业的基本资料</div>
            <div class="btn btn-green btn-two" href="javascript:void(0);" url="./cloud/user/list/">/api/user/list<br>获取员工基本资料列表</div>
            <div class="btn btn-blue btn-two" href="javascript:void(0);" url="./cloud/sendTips/">/api/tips/send<br>给员工帐号发送客户端tips</div>
            <div class="btn btn-yellow btn-two" href="javascript:void(0);" url="./cloud/sendBroadcast">/api/broadcast/send<br>给员工帐号发送广播通知消息</div>
            <div class="btn btn-red btn-two" href="javascript:void(0);" url="./cloud/notifycenter">/api/notifycenter<br>客户端主面板通知中心消息</div>
            <div class="btn btn-black btn-wpa" href="javascript:void(0);" url="./cloud/wpa">/api/wpa/generate<br>获取wpa</div>
            <div class="btn btn-red btn-two" href="javascript:void(0);" url="./cloud/user/email">/api/user/email<br>获取邮件信息</div>
            <div class="btn btn-green btn-two" href="javascript:void(0);" url="./cloud/user/mobile">/api/user/mobile<br>获取手机信息</div>
            <div class="btn btn-violet btn-two" href="javascript:void(0);" url="./cloud/user/online">/api/user/online<br>获取在线信息</div>
            <div class="btn btn-red btn-two" href="javascript:void(0);" url="./cloud/user/qq">/api/user/qq<br>获取号码信息</div>
            <div class="btn btn-blue btn-two" href="javascript:void(0);" url="./cloud/dept/moduser">/api/dept/moduser<br>修改普通员工</div>
            <div class="btn btn-green btn-two" href="javascript:void(0);" url="./cloud/dept/adduser">/api/dept/adduser<br>新增普通员工</div>
            <div class="btn btn-yellow btn-two" href="javascript:void(0);" url="./cloud/dept/list">/api/dept/list<br>获取组织架构列表</div>
            <div class="btn btn-violet btn-two" href="javascript:void(0);" url="./cloud/dept/add">/api/dept/add<br>新增组织</div>
            <div class="btn btn-black btn-two" href="javascript:void(0);" url="./cloud/longtoshort">/api/url/longtoshort<br>长网址转短网址</div>
        </div>
        <div class="frame">
            <div class="btn btn-back btn-gray hide" >Back</div>
            <div id='out_msg' name="out_msg" class="hide" style="margin-left: 10%;">
                <div><label style="color:white;">返回内容</label></div>
                <div><textarea readonly="readonly" id="text_ret_msg" rows="30"  cols="70" style="resize:none;width:70%;"> 

                    </textarea>
                </div>
            </div>
            <div id="extradiv" class="hide" name="extradiv" style="position: absolute;left:20px;top: 110px;width: 150px;height: 150px;background-color: white;"></div>
        </div>

        <script type="text/javascript" src="./cloud/assets/js/jquery-1.4.4.js"></script>  
        <script type="text/javascript" src="./cloud/assets/js/mousewheel.js"></script>  
        <script type="text/javascript" src="./cloud/assets/js/testapi.js"></script>          
    </body>
</html>