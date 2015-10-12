<?php
/**
 * The action->dynamic view file of dashboard module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dashboard
 * @version     $Id: action->dynamic.html.php 1477 2011-03-01 15:25:50Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<div id='featurebar' style="display: none">
  <?php 
  echo '<span id="today">'      . html::a(inlink('dynamic', "type=today"),      $lang->action->dynamic->today)      . '</span>';
  echo '<span id="yesterday">'  . html::a(inlink('dynamic', "type=yesterday"),  $lang->action->dynamic->yesterday)  . '</span>';
  echo '<span id="twodaysago">' . html::a(inlink('dynamic', "type=twodaysago"), $lang->action->dynamic->twoDaysAgo) . '</span>';
  echo '<span id="thisweek">'   . html::a(inlink('dynamic', "type=thisweek"),   $lang->action->dynamic->thisWeek)   . '</span>';
  echo '<span id="lastweek">'   . html::a(inlink('dynamic', "type=lastweek"),   $lang->action->dynamic->lastWeek)   . '</span>';
  echo '<span id="thismonth">'  . html::a(inlink('dynamic', "type=thismonth"),  $lang->action->dynamic->thisMonth)  . '</span>';
  echo '<span id="lastmonth">'  . html::a(inlink('dynamic', "type=lastmonth"),  $lang->action->dynamic->lastMonth)  . '</span>';
  echo '<span id="all">'        . html::a(inlink('dynamic', "type=all"),        $lang->action->dynamic->all)        . '</span>';
  ?>
</div>

<table class='table-1 colored tablesorter'>
  <thead>
  <tr class='colhead'>
    <th class='w-150px'>姓名</th>
    <th class='w-200px'> 开始工作时间</th>
    <th class='w-200px'>结束工作时间</th>
    <th class='w-200px'> 工作时长</th>
    <th class='w-100px'>   状态</th>
    <th>IP</th>
  </tr>
  </thead>
  <tbody>

  <?php foreach($myworktimelist as $item):?>
  <tr class='a-center' <?php if($item->status==2) { ?> style="background-color:#ffcc00; " <?php } ?> >
    <td>
        <?php echo $app->user->realname;?>
    </td>
    <td>
        <?php echo date("Y-m-d H:i:s",$item->begintime);?>
    </td>
    <td>
        <?php echo $item->endtime == 0 ? "" : date("Y-m-d  H:i:s",$item->endtime);?>
    </td>
    <td>
        <?php

        if($item->endtime <> 0){
            $lasttime=html::calculateWorktime($item->begintime,$item->endtime);
            $hours=number_format($lasttime,1);
            if($hours<1){
                $minute=number_format($hours*60,0);
                echo $minute."分钟";
            }
            else{
                echo $hours."小时";
            }
        }

        ?>
    </td>
    <td>
        <?php echo html::statusName($item->status);?>
    </td>
    <td class='a-center'>
        <?php echo $item->ip;?>
    </td>
  </tr>
  <?php endforeach;?>

  </tbody>
  <tfoot><tr><td colspan='6'><?php $pager->show();?></td></tr></tfoot>
</table>
<script>$('#<?php echo $type;?>').addClass('active')</script>
<?php include '../../common/view/footer.html.php';?>
