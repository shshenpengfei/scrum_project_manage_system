<?php
/**
 * The create view of task module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     task
 * @version     $Id: create.html.php 3333 2012-07-09 01:35:36Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/autocomplete.html.php';?>
<?php include '../../common/view/chosen.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<script> var holders = <?php echo json_encode($lang->task->placeholder);?></script>
<script language='javascript'> var userList = "<?php echo join(',', array_keys($users));?>".split(',');</script>
<script language='Javascript'>
$(function()
{
     $("#preview").colorbox({width:960, height:500, iframe:true, transition:'elastic', speed:350, scrolling:true});
})
</script>

<?php if($story && $story->stage=='released'){
    echo "该需求已经上线，不能再分解任务。";exit;
} ?>
<form method='post' enctype='multipart/form-data' target='hiddenwin' id='dataform'>
  <table align='center' class='table-1 a-left'>
    <caption>
      <?php echo $lang->task->create;?>
      <div class='f-right'>
      <?php
      common::printLink('project', 'importTask', "project=$project->id", $lang->project->importTask);
      common::printLink('project', 'importBug', "projectID=$project->id", $lang->project->importBug);
      ?>
      </div>
    </caption>
    <tr>
      <th class='rowhead'><?php echo $lang->task->project;?></th>
      <td><?php echo $project->name;?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->task->module;?></th>
      <td><span id='moduleIdBox'><?php echo html::select('module', $moduleOptionMenu, $moduleID, "class='select-3'");?></span></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->task->assignedTo;?></th>
      <td><?php echo html::select('assignedTo[]', $members, '', 'class=select-3');?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->task->story;?></th>
      <td>
        <?php echo html::select('story', $stories, $storyID, 'class=select-1 disabled=disabled ');?>
        <a href='' id='preview' class='iframe'><?php echo $lang->preview;?></a>
      </td>
    </tr>
      <tr>
          <th class='rowhead'><span style='color: #ff0000'>总计<?php echo $lang->story->value;?></span></th>
          <td>
          <?php echo $story->creditvalue?$story->creditvalue:0;?>分
          </td>
      </tr>
      <tr>
          <th class='rowhead'><span style='color: #ff0000'><?php echo $lang->task->value;?></span></th>
          <td>
              <?php echo html::input('creditvalue', '', 'class="w-80px" ');?>分
          </td>
      </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->task->name;?></th>
      <td>
      <?php
      echo html::input('name', '', "class='text-1'");
      echo html::commonButton($lang->task->copyStoryTitle, 'onclick=copyStoryTitle()');?>
      </td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->task->desc;?></th>
      <td><?php echo html::textarea('desc', '', "rows='7' class='area-1'");?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->task->pri;?></th>
      <td><?php echo html::select('pri', $lang->task->priList, '', 'class=select-3');?>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->task->estimate;?></th>
      <td><?php echo html::input('estimate', '', "class='text-3'") . $lang->task->hour;?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->task->estStarted;?></th>
      <td><?php echo html::input('estStarted', '', "class='text-3 date'");?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->task->deadline;?></th>
      <td><?php echo html::input('deadline', '', "class='text-3 date'");?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->task->type;?></th>
      <td><?php echo html::select('type', $lang->task->typeList, '', 'class=select-3 onchange="setOwners(this.value)"');?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->task->mailto;?></th>
      <td> <?php echo html::input('mailto', '', 'class=text-1');?> </td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->files;?></th>
      <td class='a-left'><?php echo $this->fetch('file', 'buildform');?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->task->afterSubmit;?></th>
      <td><?php echo html::radio('after', $lang->task->afterChoices, 'continueAdding');?></td>
    </tr>
    <tr>
      <td colspan='2' class='a-center'><?php echo html::submitButton() . html::resetButton();?></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
    $("#estStarted").attr("readonly","readonly");
    $("#deadline").attr("readonly","readonly");
</script>
<?php include '../../common/view/footer.html.php';?>
