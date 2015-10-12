<?php
/**
 * The mail file of story module of ZenTaoPMS.
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
      SQL #<?php echo $sql->id . "=>$sql->assignedTo " . html::a(common::getSysURL() . $this->createLink('sqlreview', 'view', "sqlID=$sql->id"), $sql->title);?>
    </td>
  </tr>
  <tr>
    <td>
    <fieldset>
      <legend><?php echo $lang->sqlreview->content;?></legend>
      <div class='content'>
      <?php
      echo $sql->content;
      ?>
      </div>
    </fieldset>
    </td>
  </tr>
  <tr>
    <td><?php include '../../common/view/mail.html.php';?></td>
  </tr>
</table>
