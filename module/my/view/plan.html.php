<?php
/**
 * The todo view file of dashboard module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dashboard
 * @version     $Id: todo.html.php 3341 2012-07-14 07:26:53Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<form method='post' id='todoform'>
  <div id='featurebar'>
    <div class='f-left'>
      <?php 
      echo '<span id="today">'    . html::a(inlink('plan', "date=today"),     $lang->todo->todayTodos)    . '</span>';
      echo '<span id="yesterday">'. html::a(inlink('plan', "date=yesterday"), $lang->todo->thisWeekTodos). '</span>';
      echo '<span id="thisweek">' . html::a(inlink('plan', "date=thisweek"),  $lang->todo->thisWeekTodos) . '</span>';
      echo '<span id="lastweek">' . html::a(inlink('plan', "date=lastweek"),  $lang->todo->lastWeekTodos) . '</span>';
      echo '<span id="thismonth">'. html::a(inlink('plan', "date=thismonth"), $lang->todo->thismonthTodos). '</span>';
      echo '<span id="lastmonth">' . html::a(inlink('plan', "date=lastmonth"), $lang->todo->lastmonthTodos). '</span>';
      echo '<span id="thisseason">'. html::a(inlink('plan', "date=thisseason"),$lang->todo->thisseasonTodos).'</span>';
      echo '<span id="thisyear">'  . html::a(inlink('plan', "date=thisyear"),  $lang->todo->thisyearTodos) . '</span>';
      echo '<span id="future">'   . html::a(inlink('plan', "date=future"),    $lang->todo->futureTodos)   . '</span>';
      echo '<span id="all">'      . html::a(inlink('plan', "date=all"),       $lang->todo->allDaysTodos)  . '</span>';
      echo '<span id="before">'   . html::a(inlink('plan', "date=before&account={$app->user->account}&status=undone"), $lang->todo->allUndone) . '</span>';
      echo "<span id='$date'>"    . html::input('date', $date,"class='w-date date' onchange=changeDate(this.value)") . '</span>';
      ?>
      <script>$('#<?php echo $type;?>').addClass('active')</script>
    </div>
    <div class='f-right'>
      <?php 
      common::printIcon('todo', 'export', "account=$account&orderBy=id_desc");
      common::printIcon('todo', 'batchCreatePlan');
      common::printIcon('todo', 'createplan', "date=" . str_replace('-', '', $date));
      ?>
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
      <th class='w-100px {sorter:false}'><?php echo $lang->actions;?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($todos as $todo):?>
    <tr class='a-center'>
      <td class='a-center'>
        <?php if(common::hasPriv('todo', 'import2Today') and $importFuture): ?>  
        <input type='checkbox' name='todoIDList[<?php echo $todo->id;?>]' value='<?php echo $todo->id;?>' />         
        <?php endif;?>  
        <?php echo $todo->id; ?>
      </td>
      <td><?php echo $todo->date == '2030-01-01' ? $lang->todo->dayInFuture : $todo->date;?></td>
      <td><?php echo $lang->todo->typeList->{$todo->type};?></td>
      <td><?php echo $todo->pri;?></td>
      <td class='a-left'><?php echo html::a($this->createLink('todo', 'view', "id=$todo->id&from=my"), $todo->name);?></td>
      <td><?php echo $todo->begin;?></td>
      <td><?php echo $todo->end;?></td>
      <td class='<?php echo $todo->status;?>'><?php echo $lang->todo->statusList[$todo->status];?></td>
      <td class='f-right'>
        <?php 
        echo html::a($this->createLink('todo', 'mark',   "id=$todo->id&status=$todo->status"), $lang->todo->{'mark'.ucfirst($todo->status)}, 'hiddenwin');
        common::printIcon('todo', 'editplan',   "id=$todo->id", '', 'list', 'edit');
        common::printIcon('todo', 'delete', "id=$todo->id", '', 'list', '', 'hiddenwin');
        ?>
      </td>
    </tr>
    <?php endforeach;?>
    </tbody>
    <?php if(count($todos)):?>
    <tfoot>
      <tr>
        <td colspan='9'>
        <div class='f-left'>
        <?php 
        if(common::hasPriv('todo', 'import2Today') and $importFuture)
        {
            echo html::selectAll() . html::selectReverse();
            $actionLink = $this->createLink('todo', 'import2Today');
            echo html::commonButton($lang->todo->import2Today, "onclick=\"changeAction('todoform', 'import2Today', '$actionLink')\"");
        }
        ?>
        </div>
        <?php if($type == 'all') $pager->show();?>
        </td>
      </tr>
    </tfoot>
    <?php endif;?>
  </table>
</form>
<?php include '../../common/view/footer.html.php';?>
