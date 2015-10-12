<?php
/**
 * The build view file of project module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     project
 * @version     $Id: build.html.php 3179 2012-07-01 01:25:16Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<table class='table-1 tablesorter fixed'>
  <caption class='caption-tl'>
    <div class='f-left'><?php echo $lang->project->build;?></div>
    <div class='f-right'><?php common::printLink('build', 'create', "project=$project->id", $lang->build->create);?></div>
  </caption>
  <thead>
  <tr class='colhead'>
    <th class='w-id'><?php echo $lang->build->id;?></th>
    <th class='w-120px'><?php echo $lang->build->product;?></th>
    <th><?php echo $lang->build->name;?></th>
    <th><?php echo $lang->build->scmPath;?></th>
    <th><?php echo $lang->build->filePath;?></th>
    <th class='w-date'><?php echo $lang->build->date;?></th>
    <th class='w-user'><?php echo $lang->build->builder;?></th>
    <th class='w-150px'><?php echo $lang->actions;?></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($builds as $build):?>
  <tr class='a-center'>
    <td><?php echo $build->id;?></td>
    <td><?php echo $build->productName;?></td>
    <td class='a-left'><?php echo html::a($this->createLink('build', 'view', "build=$build->id"), $build->name);?></td>
    <td class='a-left nobr'><?php strpos($build->scmPath,  'http') === 0 ? printf(html::a($build->scmPath))  : printf($build->scmPath);?></td>
    <td class='a-left nobr'><?php strpos($build->filePath, 'http') === 0 ? printf(html::a($build->filePath)) : printf($build->filePath);?></td>
    <td><?php echo $build->date?></td>
    <td><?php echo $users[$build->builder]?></td>
    <td class='a-right'>
      <?php 
      common::printLink('testtask', 'create', "product=0&project=$project->id&build=$build->id", $lang->testtask->create);
      common::printLink('project', 'bug', "project=$project->id&orderBy=status&build=$build->id", $lang->project->viewBug);
      common::printLink('build', 'edit',   "buildID=$build->id", '&nbsp;', '', "class='icon-green-small-edit' title='{$lang->edit}'", false);
      common::printLink('build', 'delete', "buildID=$build->id", '&nbsp;', 'hiddenwin', "class='icon-green-small-delete' title='{$lang->delete}'", false);
      ?>
    </td>
  </tr>
  <?php endforeach;?>
  </tbody>
</table>
<?php include '../../common/view/footer.html.php';?>
