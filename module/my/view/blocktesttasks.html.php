<div class='block linkbox2'>
<table class='table-1 fixed colored'>
  <caption>
    <div class='f-left'><span class='icon-doing'></span><?php echo $lang->my->testTask;?></div>
    <div class='f-right'><?php echo html::a($this->createLink('my', 'testTask'), $lang->more . "<span class='icon-more'></span>");?></div>
  </caption>
  <?php 
  foreach($testtasks as $task)
  {
      echo "<tr><td class='nobr'>" . "#$story->id " . html::a($this->createLink('testtask', 'view', "taskID=$task->id"), $task->name) . "</td><td width='5'></td><td>状态：".$lang->testtask->statusList[$task->status]."｜结束日期：".$task->end."</td></tr>";
  }
  ?>
</table>
</div>
