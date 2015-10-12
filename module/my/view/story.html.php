<?php
/**
 * The story view file of dashboard module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dashboard
 * @version     $Id: story.html.php 3341 2012-07-14 07:26:53Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<div id='featurebar'>
  <div class='f-left'>
    <?php
    echo "<span id='assignedtoTab'>" . html::a(inlink('story', "type=assignedto"),  $lang->my->storyMenu->assignedToMe) . "</span>";
    echo "<span id='openedbyTab'>"   . html::a(inlink('story', "type=openedby"),    $lang->my->storyMenu->openedByMe)   . "</span>";
    echo "<span id='reviewedbyTab'>" . html::a(inlink('story', "type=reviewedby"),  $lang->my->storyMenu->reviewedByMe) . "</span>";
    echo "<span id='closedbyTab'>"   . html::a(inlink('story', "type=closedby"),    $lang->my->storyMenu->closedByMe)   . "</span>";
    ?>
  </div>
</div>
<table class='table-1 tablesorter fixed'>
  <thead>
    <tr class='colhead'>
      <th class='w-id'><?php echo $lang->idAB;?></th>
      <th class='w-pri'><?php echo $lang->priAB;?></th>
      <th class='w-200px'><?php echo $lang->story->product;?></th>
      <th><?php echo $lang->story->title;?></th>
      <th class='w-150px'><?php echo $lang->story->plan;?></th>
      <th class='w-user'><?php echo $lang->openedByAB;?></th>
      <th class='w-hour'><?php echo $lang->story->estimateAB;?></th>
      <th class='w-status'><?php echo $lang->statusAB;?></th>
      <th class='w-100px'><?php echo $lang->story->stageAB;?></th>
      <th class='w-80px {sorter:false}'><?php echo $lang->actions;?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($stories as $key => $story):?>
      <?php $storyLink = $this->createLink('story', 'view', "id=$story->id");?>
      <tr class='a-center'>
      <td><?php echo html::a($storyLink, sprintf('%03d', $story->id));?></td>
      <td><?php echo $story->pri;?></td>
      <td><?php echo $story->productTitle;?></td>
      <td class='a-left nobr'><?php echo html::a($storyLink, $story->title);?></td>
      <td><?php echo $story->planTitle;?></td>
      <td><?php echo $users[$story->openedBy];?></td>
      <td><?php echo $story->estimate;?></td>
      <td class='<?php echo $story->status;?>'><?php echo $lang->story->statusList[$story->status];?></td>
      <td><?php echo $lang->story->stageList[$story->stage];?></td>
      <td class='a-right'>
        <?php
        common::printIcon('story', 'change', "storyID=$story->id", $story, 'list');
        common::printIcon('story', 'review', "storyID=$story->id", $story, 'list');
        common::printIcon('story', 'close', "storyID=$story->id", $story, 'list');
        ?>
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>
  <tfoot><tr><td colspan='10'><?php echo $pager->show();?></td></tr></tfoot>
</table>
<script language='javascript'>$("#<?php echo $type;?>Tab").addClass('active');</script>
<?php include '../../common/view/footer.html.php';?>
