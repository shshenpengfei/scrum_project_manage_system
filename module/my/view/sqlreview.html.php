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
    echo "<span id='assignedtoTab'>" . html::a(inlink('sqlreview', "type=assignedto"),  $lang->my->storyMenu->assignedToMe) . "</span>";
    echo "<span id='openedbyTab'>"   . html::a(inlink('sqlreview', "type=openedby"),    $lang->my->storyMenu->openedByMe)   . "</span>";
    echo "<span id='reviewedbyTab'>" . html::a(inlink('sqlreview', "type=reviewedby"),  $lang->my->storyMenu->reviewedByMe) . "</span>";
    echo "<span id='closedbyTab'>"   . html::a(inlink('sqlreview', "type=closedby"),    $lang->my->storyMenu->closedByMe)   . "</span>";
    ?>
  </div>
</div>
<table class='table-1 tablesorter fixed'>
  <thead>
    <tr class='colhead'>
      <th class='w-id'><?php echo $lang->idAB;?></th>
      <th class='w-pri'><?php echo $lang->priAB;?></th>
      <th class='w-200px'><?php echo $lang->sqlreview->project;?></th>
      <th class='w-150px'><?php echo $lang->sqlreview->linkStories;?></th>
      <th><?php echo $lang->sqlreview->title;?></th>
      <th class='w-user'><?php echo $lang->openedByAB;?></th>
      <th class='w-status'><?php echo $lang->statusAB;?></th>
      <th class='w-100px'><?php echo $lang->sqlreview->stageAB;?></th>
      <th class='w-80px {sorter:false}'><?php echo $lang->actions;?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($sqls as $key => $sql):?>
      <?php $sqlLink = $this->createLink('sqlreview', 'view', "id=$sql->id");?>
      <tr class='a-center'>
      <td><?php echo html::a($sqlLink, sprintf('%03d', $sql->id));?></td>
      <td><?php echo $sql->pri;?></td>
      <td><?php echo $sql->projectTitle;?></td>
      <td><?php echo $sql->storyTitle;?></td>
      <td class='a-center nobr'><?php echo html::a($sqlLink, $sql->title);?></td>
      <td><?php echo $users[$sql->openedBy];?></td>
      <td class='<?php echo $sql->status;?>'><?php echo $lang->sqlreview->statusList[$sql->status];?></td>
      <td><?php echo $lang->sqlreview->stageList[$sql->stage];?></td>
      <td class='a-right'>
        <?php
        common::printIcon('story', 'change', "storyID=$sql->id", $sql, 'list');
        common::printIcon('story', 'review', "storyID=$sql->id", $sql, 'list');
        common::printIcon('story', 'close', "storyID=$sql->id", $sql, 'list');
        ?>
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>
  <tfoot><tr><td colspan='10'><?php echo $pager->show();?></td></tr></tfoot>
</table>
<script language='javascript'>$("#<?php echo $type;?>Tab").addClass('active');</script>
<?php include '../../common/view/footer.html.php';?>
