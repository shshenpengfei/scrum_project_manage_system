<?php
/**
 * The edit view file of story module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     story
 * @version     $Id: edit.html.php 3257 2012-07-02 06:25:41Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include './header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<form method='post' enctype='multipart/form-data' target='hiddenwin' id='dataform'>
<div id='titlebar'>
  <div id='main'>SQL #<?php echo $sql->id . $lang->colon . $sql->title;?></div>
  <div><?php echo html::submitButton()?></div>
</div>
    <style>
        .content img{max-width:1054px;}
    </style>
<table class='cont-rt5'>
  <tr valign='top'>
    <td>
      <fieldset>
        <legend><?php echo $lang->sqlreview->content;?></legend>
        <div class='content'><?php echo $sql->content;?></div>
      </fieldset>
        <fieldset>
            <legend><?php echo $lang->sqlreview->host;?> / <?php echo $lang->sqlreview->db;?></legend>
            <div class='content'>alpha：<?php echo $sql->host_alpha;?> / <?php echo $sql->db_alpha;?></div>
            <div class='content'>beta：<?php echo $sql->host_beta;?> / <?php echo $sql->db_beta;?></div>
            <div class='content'>online：<?php echo $sql->host_online;?> / <?php echo $sql->db_online;?></div>
        </fieldset>
      <fieldset>
        <legend><?php echo $lang->story->comment;?></legend>
        <?php echo html::textarea('comment', '', "rows='5' class='area-1'");?>
      </fieldset>
      <div class='a-center'>
        <?php 
        echo html::submitButton();
        echo html::linkButton($lang->goback, $app->session->storyList ? $app->session->storyList : inlink('view', "sqlID=$sql->id"));
        ?>
      </div>
      <?php include '../../common/view/action.html.php';?>
    </td>
    <td class='divider'></td>
    <td class='side'>
      <fieldset>
        <legend><?php echo $lang->story->legendBasicInfo;?></legend>
        <table class='table-1'>
          <tr>
            <td class='rowhead w-p20'><?php echo $lang->story->product;?></td>
            <td><?php echo html::select('product', $products, $sql->product, 'class="select-1" onchange="loadProduct(this.value)";');?></td>
          </tr>

          <tr>
            <th class='rowhead'><?php echo $lang->story->source;?></th>
            <td><?php echo html::select('source', $lang->story->sourceList, $sql->source, 'class=select-1');?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->status;?></td>
            <td><?php echo $lang->story->statusList[$sql->status];?></td>
          </tr>
          <?php if($sql->status != 'draft'):?>
          <tr>
            <td class='rowhead'><?php echo $lang->story->stage;?></td>
            <td><?php echo html::select('stage', $lang->sqlreview->stageList, $sql->stage, 'class=select-1');?></td>
          </tr>
          <?php endif;?>
          <tr>
            <td class='rowhead'><?php echo $lang->story->pri;?></td>
            <td><?php echo html::select('pri', $lang->story->priList, $sql->pri, 'class=select-1');?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->keywords;?></td>
            <td><?php echo html::input('keywords', $sql->keywords, 'class=text-1');?></td>
          </tr>
        </table>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->story->legendLifeTime;?></legend>
        <table class='table-1'>
          <tr>
            <td class='rowhead w-p20'><?php echo $lang->story->openedBy;?></td>
            <td><?php echo $users[$sql->openedBy];?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->assignedTo;?></td>
            <td><?php echo html::select('assignedTo', $users, $sql->assignedTo, 'class="select-1"');?></td>
          </tr>
          <?php if($sql->reviewedBy):?>
          <tr>
            <td class='rowhead'><?php echo $lang->story->reviewedBy;?></td>
            <td><?php echo html::textarea('reviewedBy', $sql->reviewedBy, 'class="area-1"');?></td>
          </tr>
          <?php endif;?>
          <?php if($sql->status == 'closed'):?>
          <tr>
            <td class='rowhead'><?php echo $lang->story->closedBy;?></td>
            <td><?php echo html::select('closedBy', $users, $sql->closedBy, 'class="select-1"');?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->closedReason;?></td>
            <td><?php echo html::select('closedReason', $lang->story->reasonList, $sql->closedReason, 'class="select-1"');?></td>
          </tr>
          <?php endif;?>
        </table>
      </fieldset>


    </td>
  </tr>
</table>
</form>
<script type="text/javascript">

</script>
<?php include '../../common/view/footer.html.php';?>
