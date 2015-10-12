<?php
/**
 * The burn view file of project module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     project
 * @version     $Id: burn.html.php 2605 2012-02-21 07:22:58Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='a-center'>
  <?php
  echo $charts; 
  common::printLink('project', 'computeBurn', 'reload=yes', $lang->project->computeBurn, 'hiddenwin');
  printf($lang->project->howToUpdateBurn, $this->createLink('help', 'field', 'module=project&method-burn&field=updateburn'));
  ?>
</div>
<?php include '../../common/view/footer.html.php';?>
