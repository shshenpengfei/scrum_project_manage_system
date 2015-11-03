<?php
require '../lib.php';
$url = OpenHelper::oauthUser()->getAuthorizeUrl();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>企业QQ开放平台示例APP</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="./assets/css/testapicss.css" />
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
                <a class="btn-violet btn-login" href="/testapi/cloud/logout.php">退出登录</a>
                <?php
            else:
                ?>
                <span style="margin-left: 20px;vertical-align:middle;">请登录:</span>
                <a href="<?php echo $url ?>" target="_blank"><img style="vertical-align:middle;" src="/testapi/cloud/assets/images/qqeim_login.gif"/></a>
            <?php
            endif;
            ?>
        </div>
        <div class="metro">
            <div class="btn btn-black btn-one" href="javascript:void(0);" url="/testapi/help.php">使用引导</div>
            <div class="btn btn-red btn-one" href="javascript:void(0);" url="/testapi/db.php">查看数据存储</div>
            <div class="btn btn-blue btn-two" href="javascript:void(0);" url="/testapi/oauth2/refreshtoken/" >/oauth2/refresh<br>刷新access_token</div>
            <div class="btn btn-violet btn-two" href="javascript:void(0);" url="/testapi/cloud/viewCorporation/" >/api/corporation/get<br>获取企业的基本资料</div>
            <div class="btn btn-green btn-two" href="javascript:void(0);" url="/testapi/cloud/user/list/">/api/user/list<br>获取员工基本资料列表</div>
            <div class="btn btn-blue btn-two" href="javascript:void(0);" url="/testapi/cloud/sendTips/">/api/tips/send<br>给员工帐号发送客户端tips</div>
            <div class="btn btn-yellow btn-two" href="javascript:void(0);" url="/testapi/cloud/sendBroadcast">/api/broadcast/send<br>给员工帐号发送广播通知消息</div>
            <div class="btn btn-red btn-two" href="javascript:void(0);" url="/testapi/cloud/notifycenter">/api/notifycenter<br>客户端主面板通知中心消息</div>
            <div class="btn btn-black btn-wpa" href="javascript:void(0);" url="/testapi/cloud/wpa">/api/wpa/generate<br>获取wpa</div>
            <div class="btn btn-red btn-two" href="javascript:void(0);" url="/testapi/cloud/user/email">/api/user/email<br>获取邮件信息</div>
            <div class="btn btn-green btn-two" href="javascript:void(0);" url="/testapi/cloud/user/mobile">/api/user/mobile<br>获取手机信息</div>
            <div class="btn btn-violet btn-two" href="javascript:void(0);" url="/testapi/cloud/user/online">/api/user/online<br>获取在线信息</div>
            <div class="btn btn-red btn-two" href="javascript:void(0);" url="/testapi/cloud/user/qq">/api/user/qq<br>获取号码信息</div>
            <div class="btn btn-blue btn-two" href="javascript:void(0);" url="/testapi/cloud/dept/moduser">/api/dept/moduser<br>修改普通员工</div>
            <div class="btn btn-green btn-two" href="javascript:void(0);" url="/testapi/cloud/dept/adduser">/api/dept/adduser<br>新增普通员工</div>
            <div class="btn btn-yellow btn-two" href="javascript:void(0);" url="/testapi/cloud/dept/list">/api/dept/list<br>获取组织架构列表</div>
            <div class="btn btn-violet btn-two" href="javascript:void(0);" url="/testapi/cloud/dept/add">/api/dept/add<br>新增组织</div>
            <div class="btn btn-black btn-two" href="javascript:void(0);" url="/testapi/cloud/longtoshort">/api/url/longtoshort<br>长网址转短网址</div>
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

        <script type="text/javascript" src="./assets/js/jquery-1.4.4.js"></script>  
        <script type="text/javascript" src="./assets/js/mousewheel.js"></script>  
        <script type="text/javascript" src="./assets/js/testapi.js"></script>          
    </body>
</html>