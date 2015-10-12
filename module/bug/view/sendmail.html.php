<?php
/**
 * The mail file of bug module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     bug
 * @version     $Id: sendmail.html.php 2963 2012-05-22 01:08:20Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<table width='98%' align='center'>
  <tr class='header'>
    <td>
      BUG #<?php echo $bug->id . "=>$bug->assignedTo " . html::a(common::getSysURL() . $this->createLink('bug', 'view', "bugID=$bug->id"), $bug->title);?>
    </td>
  </tr>
  <tr>
    <td>
    <fieldset>
      <legend><?php echo $lang->bug->legendSteps;?></legend>
      <div class='content'>
      <?php 
      if(strpos($bug->steps, '<img src="data/upload'))
      {
        $bug->steps = str_replace('<img src="', '<img src="http://' . $this->server->http_host . $this->config->webRoot, $bug->steps);
      }
      echo $bug->steps;
      ?>
      </div>
    </fieldset>
    </td>
  </tr>
  <tr>
    <td><?php include '../../common/view/mail.html.php';?></td>
  </tr>
</table>
