<?php
/**
 * The story view file of project module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     project
 * @version     $Id: story.html.php 3019 2012-06-08 07:00:42Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<form method='post' id='projectStoryForm'>
    <table class='table-1 colored tablesorter datatable'>
        <caption class='caption-tl'>
            <div class='f-left'><?php echo $lang->project->story;?></div>
            <div class='f-right'>
                <?php
                if($productID) common::printLink('sqlreview', 'create', "projectID=$project->id&sqlID=0&moduleID=0", $lang->story->create);
                ?>
            </div>
        </caption>
        <thead>
        <tr class='colhead'>
            <?php $vars = "projectID={$project->id}&orderBy=%s"; ?>
            <th class='w-id  {sorter:false}'>    <?php common::printOrderLink('id',         $orderBy, $vars, $lang->idAB);?></th>
            <th class='w-pri {sorter:false}'>    <?php common::printOrderLink('pri',        $orderBy, $vars, $lang->priAB);?></th>
            <th class='{sorter:false}'>SQL名称</th>
            <th class='{sorter:false}'>          <?php common::printOrderLink('title',      $orderBy, $vars, $lang->story->title);?></th>
            <th class='w-user {sorter:false}'>   <?php common::printOrderLink('openedBy',   $orderBy, $vars, $lang->openedByAB);?></th>
            <th class='w-hour {sorter:false}'>   <?php common::printOrderLink('assignedTo', $orderBy, $vars, $lang->assignedToAB);?></th>
            <th class='w-hour {sorter:false}'>   <?php common::printOrderLink('status',     $orderBy, $vars, $lang->statusAB);?></th>
            <th class='w-status {sorter:false}'> <?php common::printOrderLink('stage',      $orderBy, $vars, $lang->story->stageAB);?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $key => $sql):?>
            <?php
            $sqlLink      = $this->createLink('sqlreview', 'view', "sqlID=$sql->id");
            $storyLink      = $this->createLink('story', 'view', "storyID=$sql->story");
            ?>
            <tr class='a-center'>
                <td>
                    <input type='checkbox' name='storyIDList[<?php echo $sql->id;?>]' value='<?php echo $sql->id;?>' />
                    <?php echo html::a($sqlLink, sprintf('%03d', $sql->id));?>
                </td>
                <td><?php echo $lang->story->priList[$sql->pri];?></td>
                <td class='a-center nobr'><?php echo html::a($sqlLink,$sql->title);?></td>
                <td class='a-center nobr'><?php echo html::a($storyLink,$sql->story_title);?></td>
                <td><?php echo $users[$sql->openedBy];?></td>
                <td><?php echo $users[$sql->assignedTo];?></td>
                <td class='<?php echo $sql->status;?>'><?php echo $lang->story->statusList[$sql->status];?></td>
                <td><?php echo $lang->sqlreview->stageList[$sql->stage];?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan='10'>

            </td>
        </tr>
        </tfoot>
    </table>
</form>
<?php include '../../common/view/footer.html.php';?>
