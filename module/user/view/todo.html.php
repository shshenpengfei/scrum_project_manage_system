<?php
/**
 * The todo view file of dashboard module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dashboard
 * @version     $Id: todo.html.php 2937 2012-05-14 06:59:24Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<script language='Javascript'>var account='<?php echo $account;?>'</script>
<form method='post' target='hiddenwin' action='<?php echo $this->createLink('todo', 'import2Today');?>' id='todoform'>
   <div id='featurebar'>
     <div class='f-left'>
       <?php 
       echo '<span id="today">'    . html::a(inlink('todo', "account=$account&date=today"),     $lang->todo->todayTodos)    . '</span>';
       echo '<span id="thisweek">' . html::a(inlink('todo', "account=$account&date=thisweek"),  $lang->todo->thisWeekTodos) . '</span>';
       echo '<span id="lastweek">' . html::a(inlink('todo', "account=$account&date=lastweek"),  $lang->todo->lastWeekTodos) . '</span>';
      echo '<span id="future" >'   . html::a(inlink('todo', "account=$account&date=future"),    $lang->todo->futureTodos)   . '</span>';
       echo '<span id="all">'      . html::a(inlink('todo', "account=$account&date=all"),       $lang->todo->allDaysTodos)  . '</span>';
       echo '<span id="before">'   . html::a(inlink('todo', "account=$account&date=before&status=undone"), $lang->todo->allUndone) . '</span>';
       echo "<span id='$date'>"    . html::select('date', $dates, $date, 'onchange=changeDate(this.value)') . '</span>';
       ?>
       <script>$('#<?php echo $type;?>').addClass('active')</script>
    </div>
  </div>
  <table class='table-1 tablesorter'>
    <thead>
    <tr class='colhead'>
	  <th class='w-id'><?php echo $lang->idAB;?></th>
      <th class='w-date'><?php echo $lang->todo->date;?></th>
      <th class='w-type'><?php echo $lang->todo->type;?></th>
      <th class='w-pri'><?php echo $lang->priAB;?></th>
      <th><?php echo $lang->todo->name;?></th>
      <th class='w-hour'><?php echo $lang->todo->beginAB;?></th>
      <th class='w-hour'><?php echo $lang->todo->endAB;?></th>
      <th class='w-status'><?php echo $lang->todo->status;?></th>
    </tr>
    </thead>

    <tbody>
    <?php foreach($todos as $todo):?>
    <tr class='a-center'>
      <td><?php echo $todo->id;?></td>
      <td><?php echo $todo->date == '2030-01-01' ? $lang->todo->dayInFuture : $todo->date;?></td>
      <td><?php echo $lang->todo->typeList->{$todo->type};?></td>
      <td><?php echo $todo->pri;?></td>
      <td class='a-left'><?php if(!common::printLink('todo', 'view', "todo=$todo->id", $todo->name)) echo $todo->name;?></td>
      <td><?php echo $todo->begin;?></td>
      <td><?php echo $todo->end;?></td>
      <td class='<?php echo $todo->status;?>'><?php echo $lang->todo->statusList[$todo->status];?></td>
    </tr>
    <?php endforeach;?>
    </tbody>
    <?php if($type == 'all'):?><tfoot><tr><td colspan='8'><?php $pager->show();?></td></tr></tfoot><?php endif;?>
  </table>
</form>
<?php include '../../common/view/footer.html.php';?>
