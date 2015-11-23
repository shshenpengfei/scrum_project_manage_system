<?php
/**
 * The batch edit view of task module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Congzhi Chen <congzhi@cnezsoft.com>
 * @package     task
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<form method='post' target='hiddenwin' action="<?php echo $this->inLink('batchStandChoose', "projectID=$projectID&from=taskbatchStandChoose")?>">
  <table class='table-1 fixed'>
    <caption><?php echo $lang->task->common . $lang->colon . $lang->task->batchEdit;?></caption>
    <tr>
      <th class='w-20px'><?php echo $lang->idAB;?></th>
      <th class='w-200px'> <?php echo $lang->task->name;?></th>
      <th class='w-100px'><?php echo $lang->task->assignedTo;?></th>
      <th class='w-100px'><?php echo $lang->typeAB;?></th>
      <th class='w-100px'><?php echo $lang->task->status;?></th>
      <th class='w-100px'><?php echo $lang->task->pri;?></th>
      <th class='w-150px'><?php echo $lang->task->standmeeting;?></th>

    </tr>
    <?php foreach($editedTasks as $task):?>
    <tr class='a-center'>
      <td><?php echo $task->id . html::hidden("taskIDList[$task->id]", $task->id);?></td>
      <td><?php echo html::input("names[$task->id]",          $task->name, 'class=text-1 disabled=disabled readonly=readonly'); echo "<span class='star'>*</span>";?></td>
      <td><?php echo html::input("assignedTos[$task->id]",   $members[$task->assignedTo], 'class=select-1 disabled=disabled readonly=readonly');?></td>
      <td><?php echo html::input("types[$task->id]",         $lang->task->typeList[$task->type], 'class=select-1 disabled=disabled readonly=readonly');?></td>
      <td><?php echo html::input("statuses[$task->id]",      $lang->task->statusList[$task->status], 'class=select-1 disabled=disabled readonly=readonly');?></td>
      <td><?php echo html::input("pris[$task->id]",          $lang->task->priList[$task->pri], 'class=select-1 disabled=disabled readonly=readonly');?></td>
      <td>

          <div class="choose-date mb-10px f-left">
              <?php $show = $this->loadModel('task')->getStandDateByTaskid($task->id)? " disabled=disabled readonly=readonly":"" ?>
              <?php echo html::input("standdate[$task->id]", $this->loadModel('task')->getStandDateByTaskid($task->id)?$this->loadModel('task')->getStandDateByTaskid($task->id):date("Y-m-d",time()), "class='select-7 date' ".$show." onchange='changeDate(this.value, \"$end\")'");?>
          </div>
      </td>
    </tr>
    <?php endforeach;?>
    <?php if(isset($suhosinInfo)):?>
    <tr><td colspan='7'><div class='f-left blue'><?php echo $suhosinInfo;?></div></td></tr>
    <?php endif;?>
    <tr><td colspan='7' class='a-center'><?php echo html::submitButton();?></td></tr>
  </table>
</form>
<?php include '../../common/view/footer.html.php';?>
