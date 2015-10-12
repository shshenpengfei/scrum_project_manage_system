<?php
/**
 * The router file of ZenTaoPMS.
 *
 * All request should be routed by this router.
 *
 * @copyright   Copyright 2009-2012 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ZenTaoPMS
 * @version     $Id: index.php 2802 2012-04-30 01:10:55Z areyou123456 $
 * @link        http://www.zentao.net
 */
/* Set the error reporting. */
error_reporting(0);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//error_reporting(E_ALL);
//ini_set('error_reporting', E_STRICT);
/* Start output buffer. */
ob_start();

/* Load the framework. */
include '../framework/router.class.php';
include '../framework/control.class.php';
include '../framework/model.class.php';
include '../framework/helper.class.php';

/* Log the time and define the run mode. */
$startTime = getTime();
/* Instance the app. */
$app = router::createApp('pms', dirname(dirname(__FILE__)));
/* Check the reqeust is getconfig or not. Check installed or not. */
if(isset($_GET['mode']) and $_GET['mode'] == 'getconfig') die($app->exportConfig());  //
if(!isset($config->installed) or !$config->installed) die(header('location: install.php'));

/* Run the app. */
$common = $app->loadCommon();
$app->parseRequest();
$common->checkPriv();
$app->loadModule();

/* Flush the buffer. */
ob_end_flush();
