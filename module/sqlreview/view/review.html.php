<?php
/**
 * The view file of review method of story module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     story
 * @version     $Id: review.html.php 2605 2012-02-21 07:22:58Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include './header.html.php';?>
<script language='Javascript'>
var assignedTo = '<?php $sql->lastEditedBy ? print($sql->lastEditedBy) : print($sql->openedBy);?>';
</script>
<form method='post' target='hiddenwin'>
  <table class='table-1'>
    <caption><?php echo $sql->title;?></caption>
    <tr>
      <th class='w-100px rowhead'><?php echo $lang->story->reviewedDate;?></th>
      <td><?php echo html::input('reviewedDate', helper::today(), 'class=text-3');?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->story->reviewResult;?></th>
      <td><?php echo html::select('result', $lang->story->reviewResultList, '', 'class=select-3 onchange="switchShow(this.value)"');?></td>
    </tr>
    <tr id='rejectedReasonBox' class='hidden'>
      <th class='rowhead'><?php echo $lang->story->rejectedReason;?></th>
      <td><?php echo html::select('closedReason', $lang->story->reasonList, '', 'class=select-3 onchange="setStory(this.value)"');?></td>
    </tr>
    <?php if($sql->status == 'changed' or ($sql->status == 'draft' and $sql->version > 1)):?>
    <tr id='preVersionBox' class='hidden'>
      <th class='rowhead'><?php echo $lang->story->preVersion;?></th>
      <td><?php echo html::radio('preVersion', array_combine(range($sql->version - 1, 1), range($sql->version - 1, 1)), $sql->version - 1);?></td>
    </tr>
    <?php endif;?>
    <tr>
      <th class='rowhead'><?php echo $lang->story->assignedTo;?></th>
      <td><?php echo html::select('assignedTo', $users, $sql->lastEditedBy ? $sql->lastEditedBy : $sql->openedBy, 'class=select-3');?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->story->reviewedBy;?></th>
      <td><?php echo html::input('reviewedBy', $app->user->account . ', ', 'class=text-1');?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->story->comment;?></th>
      <td><?php echo html::textarea('comment', '', "rows='8' class='area-1'");?></td>
    </tr>
    <tr>
      <td colspan='2' class='a-center'>
      <?php echo html::submitButton();?>
      <?php echo html::linkButton($lang->goback, $app->session->storyList ? $app->session->storyList : inlink('view', "storyID=$story->id"));?>
      </td>
    </tr>
  </table>
</form>
<?php include '../../common/view/action.html.php';?>
<?php include '../../common/view/footer.html.php';?>
