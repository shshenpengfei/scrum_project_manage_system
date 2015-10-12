<?php
/**
 * The install module zh-cn file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     install
 * @version     $Id: zh-cn.php 3011 2012-06-07 01:51:05Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
$lang->install->common  = '安装';
$lang->install->next    = '下一步';
$lang->install->pre     = '返回';
$lang->install->reload  = '刷新';
$lang->install->error   = '错误 ';

$lang->install->start            = '开始安装';
$lang->install->keepInstalling   = '继续安装当前版本';
$lang->install->seeLatestRelease = '看看最新的版本';
$lang->install->welcome          = '欢迎使用禅道项目管理软件！';
$lang->install->desc             = <<<EOT
禅道项目管理软件(ZenTaoPMS)是一款国产的，基于LGPL协议，开源免费的项目管理软件，它集产品管理、项目管理、测试管理于一体，同时还包含了事务管理、组织管理等诸多功能，是中小型企业项目管理的首选。

禅道项目管理软件使用PHP + MySQL开发，基于自主的PHP开发框架──ZenTaoPHP而成。第三方开发者或者企业可以非常方便的开发插件或者进行定制。

禅道项目管理软件由<strong><a href='http://www.cnezsoft.com' target='_blank' class='red'>青岛易软天创网络科技有限公司</a>开发</strong>。
官方网站：<a href='http://www.zentao.net' target='_blank'>http://www.zentao.net</a>
技术支持: <a href='http://www.zentao.net/ask/' target='_blank'>http://www.zentao.net/ask/</a>
新浪微博：<a href='http://t.sina.com.cn/zentaopms' target='_blank'>t.sina.com.cn/zentaopms</a>
腾讯微博：<a href='http://t.qq.com/zentaopms/' target='_blank'>t.qq.com/zentaopms</a>

您现在正在安装的版本是 <strong class='red'>%s</strong>。
EOT;

$lang->install->newReleased= "<strong class='red'>提示</strong>：官网网站已有最新版本<strong class='red'>%s</strong>, 发布日期于 %s。";
$lang->install->choice     = '您可以选择：';
$lang->install->checking   = '系统检查';
$lang->install->ok         = '检查通过(√)';
$lang->install->fail       = '检查失败(×)';
$lang->install->loaded     = '已加载';
$lang->install->unloaded   = '未加载';
$lang->install->exists     = '目录存在 ';
$lang->install->notExists  = '目录不存在 ';
$lang->install->writable   = '目录可写 ';
$lang->install->notWritable= '目录不可写 ';
$lang->install->phpINI     = 'PHP配置文件';
$lang->install->checkItem  = '检查项';
$lang->install->current    = '当前配置';
$lang->install->result     = '检查结果';
$lang->install->action     = '如何修改';

$lang->install->phpVersion = 'PHP版本';
$lang->install->phpFail    = 'PHP版本必须大于5.2.0';

$lang->install->pdo          = 'PDO扩展';
$lang->install->pdoFail      = '修改PHP配置文件，加载PDO扩展。';
$lang->install->pdoMySQL     = 'PDO_MySQL扩展';
$lang->install->pdoMySQLFail = '修改PHP配置文件，加载pdo_mysql扩展。';
$lang->install->json         = 'JSON扩展';
$lang->install->jsonFail     = '修改PHP配置文件，加载JSON扩展。';
$lang->install->tmpRoot      = '临时文件目录';
$lang->install->dataRoot     = '上传文件目录';
$lang->install->mkdir        = '<p>需要创建目录%s。<br /> linux下面命令为：<br /> mkdir -p %s</p>';
$lang->install->chmod        = '需要修改目录 "%s" 的权限。<br />linux下面命令为：<br />chmod o=rwx -R %s';

$lang->install->settingDB      = '设置数据库';
$lang->install->webRoot        = 'PMS所在网站目录';
$lang->install->requestType    = 'URL方式';
$lang->install->defaultLang    = '默认语言';
$lang->install->dbHost         = '数据库服务器';
$lang->install->dbHostNote     = '如果localhost无法访问，尝试使用127.0.0.1';
$lang->install->dbPort         = '服务器端口';
$lang->install->dbUser         = '数据库用户名';
$lang->install->dbPassword     = '数据库密码';
$lang->install->dbName         = 'PMS使用的库';
$lang->install->dbPrefix       = '建表使用的前缀';
$lang->install->createDB       = '自动创建数据库';
$lang->install->clearDB        = '清空现有数据';
$lang->install->importDemoData = '导入demo数据';

$lang->install->requestTypes['GET']       = '普通方式';
$lang->install->requestTypes['PATH_INFO'] = '静态友好方式';

$lang->install->errorConnectDB      = '数据库连接失败 ';
$lang->install->errorCreateDB       = '数据库创建失败';
$lang->install->errorDBExists       = '数据库已经存在，继续安装请选择清空数据';
$lang->install->errorCreateTable    = '创建表失败';
$lang->install->errorImportDemoData = '导入demo数据失败';

$lang->install->setConfig  = '生成配置文件';
$lang->install->key        = '配置项';
$lang->install->value      = '值';
$lang->install->saveConfig = '保存配置文件';
$lang->install->save2File  = '<div class="a-center"><span class="fail">尝试写入配置文件，失败！</span></div>拷贝上面文本框中的内容，将其保存到 "<strong> %s </strong>"中。您以后还可继续修改此配置文件。';
$lang->install->saved2File = '配置信息已经成功保存到" <strong>%s</strong> "中。您后面还可继续修改此文件。';
$lang->install->errorNotSaveConfig = '还没有保存配置文件';

$lang->install->getPriv  = '设置帐号';
$lang->install->company  = '公司名称';
$lang->install->pms      = 'PMS地址';
$lang->install->pmsNote  = '即通过什么地址可以访问到禅道项目管理，设置域名或者IP地址即可，不需要http';
$lang->install->account  = '管理员帐号';
$lang->install->password = '管理员密码';
$lang->install->errorEmptyPassword = '密码不能为空';

$lang->install->success = "安装成功";

$lang->install->joinZentao = <<<EOT
您已经成功安装禅道管理系统%s，<strong class='red'>请及时删除install.php</strong>。现在您可以直接<input type='button' value='登录禅道管理系统' onclick='location.href="index.php"'>，设置用户及分组！
<i>友情提示：为了您及时获得禅道的最新动态，请在禅道社区(<a href='http://www.zentao.net' target='_blank'>www.zentao.net</a>)进行登记。</i>
EOT;
