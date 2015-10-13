<?php
/**
 * The view of productplan module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     productplan
 * @version     $Id: view.html.php 3341 2012-07-14 07:26:53Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>

<?php

if(!empty($planStories)){
$webRoot      = PM_SITE;
$defaultTheme = $webRoot . 'theme/default/';
css::import($defaultTheme . 'gante_styles/css/screen.css', 2.3);
css::import($defaultTheme . 'gante_styles/css/gantti.css', 2.3);
require('../../m_gante/lib/gantti.php');
date_default_timezone_set('UTC');
setlocale(LC_ALL, 'en_US');
$data = array();
foreach($planStories as $storyID => $story){

foreach($story->tasklist as  $tasklists){
foreach ($tasklists as $key=> $value){

if($value->type == 'test'){
$data[]=  array(
'label'=>$story->id."[".$users[$value->assignedTo]."]".$value->name,
'storyid'=>$story->id,
'start' => $value->estStarted,
'end'   => $value->deadline." 24:00:00",
'class'=>'urgent'
);
}
else{
$data[]=  array(
'label'=>$story->id."[".$users[$value->assignedTo]."]".$value->name,
'storyid'=>$story->id,
'start' => $value->estStarted,
'end'   => $value->deadline." 24:00:00",
);

}

}

}

}

if($data){
    $gantti = new Gantti($data, array(
        'title'      => '需求分解甘特图',
        'cellwidth'  => 60,
        'cellheight' => 33,
    ));
}

echo $gantti;
js::import($webRoot .'js/raphael-min.js');

js::import($webRoot .'js/ganttLine.js');

}


?>
<style>
    .gantt header .gantt-day.today span{color:#f00;}
</style>
<table class='cont-rt5'>
  <caption><?php echo $plan->title . $lang->colon . $lang->productplan->view;?></caption>
  <tr valign='top'>
    <td>
      <fieldset>
        <legend><?php echo $lang->productplan->desc;?></legend>
        <div class='content'><?php echo $product->desc;?></div>
      </fieldset>
      <?php include '../../common/view/action.html.php';?>
      <div class='a-center f-16px strong'>
      <?php
       $browseLink = $this->session->productPlanList ? $this->session->productPlanList : inlink('browse', "planID=$plan->id");
       if(!$plan->deleted)
       {
          common::printLink('productplan', 'edit',     "planID=$plan->id", $lang->edit);
          common::printLink('productplan', 'linkstory',"planID=$plan->id", $lang->productplan->linkStory);
          common::printLink('productplan', 'delete',   "planID=$plan->id", $lang->delete, 'hiddenwin');
       }
       echo html::a($browseLink, $lang->goback);
      ?>
      </div>

    </td>
    <td class="divider"></td>
    <td class="side">
      <fieldset>
        <legend><?php echo $lang->productplan->basicInfo?></legend>
        <table class='table-1 a-left'>
          <tr>
            <th width='25%' class='a-right'><?php echo $lang->productplan->title;?></th>
            <td <?php if($plan->deleted) echo "class='deleted'";?>><?php echo $plan->title;?></td>
          </tr>
          <tr>
            <th class='rowhead'><?php echo $lang->productplan->begin;?></th>
            <td><?php echo $plan->begin;?></td>
          </tr>
          <tr>
            <th class='rowhead'><?php echo $lang->productplan->end;?></th>
            <td><?php echo $plan->end;?></td>
          </tr>
        </table>
      </fieldset>
    </td>
  </tr>
  <tr>
    <td colspan="3">
        <table class='table-1 tablesorter a-center'>
            <caption class='caption-tl'><?php echo $plan->title .$lang->colon . $lang->productplan->linkedStories;?></caption>
            <thead>
            <tr class='colhead'>
                <th class='w-id'><?php echo $lang->idAB;?></th>
                <th class='w-pri'><?php echo $lang->priAB;?></th>
                <th  width='360px'><?php echo $lang->story->title;?></th>
                <th><?php echo $lang->openedByAB;?></th>
                <th><?php echo $lang->assignedToAB;?></th>
                <th>测试</th>
                <th>任务</th>
                <th><?php echo $lang->story->releasedDate;?></th>
                <th><?php echo $lang->story->estimateAB;?></th>
                <th><?php echo $lang->statusAB;?></th>
                <th><?php echo $lang->story->stageAB;?></th>
                <th class='w-p10 {sorter:false}'><?php echo $lang->actions?></th>
            </tr>
            </thead>
            <tbody>
            <?php $totalEstimate = 0.0;?>
            <?php foreach($planStories as $story):?>
                <?php
                $viewLink = $this->createLink('story', 'view', "storyID=$story->id");
                $totalEstimate += $story->estimate;
                ?>
                <tr>
                    <td><?php echo html::a($viewLink, $story->id);?></td>
                    <td><?php echo $story->pri;?></td>
                    <td class='a-left'><?php echo html::a($viewLink , $story->title);?></td>
                    <td><?php echo $users[$story->openedBy];?></td>
                    <td><?php echo $users[$story->assignedTo];?></td>
                    <td><?php echo $users[$story->tester];?></td>
                    <td><?php echo $story->taskCounts;?></td>
                    <td><?php echo $story->releasedDate;?></td>
                    <td><?php echo $story->estimate;?></td>
                    <td><?php echo $lang->story->statusList[$story->status];?></td>
                    <td><?php echo $lang->story->stageList[$story->stage];?></td>
                    <td><?php common::printLink('productplan', 'unlinkStory', "story=$story->id", $lang->productplan->unlinkStory, 'hiddenwin');?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
            <tfoot><tr><td colspan='9' class='a-right'><?php printf($lang->product->storySummary, count($planStories), $totalEstimate);?> </td></tr></tfoot>
        </table>
    </td>
  </tr>
</table>
<?php include '../../common/view/footer.html.php';?>
