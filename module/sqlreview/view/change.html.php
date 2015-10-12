<?php
/**
 * The change view file of story module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     story
 * @version     $Id: change.html.php 2605 2012-02-21 07:22:58Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include './header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<form method='post' enctype='multipart/form-data' target='hiddenwin'>
  <table class='table-1'>
    <caption><?php echo $lang->story->change;?></caption>
    <tr>
      <th class='rowhead'><?php echo $lang->story->reviewedBy;?></th>
      <td><?php echo html::select('assignedTo', $users, $sql->assignedTo, 'class="select-3"');?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->sqlreview->title;?></th>
      <td><?php echo html::input('title', $sql->title, 'class="text-1"');?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->sqlreview->content;?></th>
      <td><?php echo html::textarea('content', htmlspecialchars($sql->content), 'rows=8 class="area-1"');?></td>
    </tr>
      <tr>
          <th class='rowhead'><?php echo $lang->sqlreview->host;?></th>
          <td>
              <?php echo html::input('host_alpha', $sql->host_alpha, "class='text-3'");?>
              <?php echo html::input('host_beta', $sql->host_beta, "class='text-3'");?>
              <?php echo html::input('host_online', $sql->host_online, "class='text-3'");?>
              <span>分别填写alpha、beta、线上的host</span>
          </td>
      </tr>
      <tr>
          <th class='rowhead'><?php echo $lang->sqlreview->db;?></th>
          <td>
              <?php echo html::input('db_alpha', $sql->db_alpha, "class='text-3'");?>
              <?php echo html::input('db_beta', $sql->db_beta, "class='text-3'");?>
              <?php echo html::input('db_online', $sql->db_online, "class='text-3'");?>
              <span>分别填写alpha、beta、线上的db</span>
          </td>
      </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->story->comment;?></th>
      <td><?php echo html::textarea('comment', '', 'rows=5 class="area-1"');?></td>
    </tr>
  </table>
  <div class='a-center'>
    <?php 
    echo html::submitButton();
    echo html::linkButton($lang->goback, $app->session->storyList ? $app->session->storyList : inlink('view', "storyID=$story->id"));
    ?>
  </div>
  <?php include '../../common/view/action.html.php';?>
</form>
<?php include '../../common/view/footer.html.php';?>
