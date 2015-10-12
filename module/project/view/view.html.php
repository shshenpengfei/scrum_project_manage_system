<?php
/**
 * The view method view file of project module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     project
 * @version     $Id: view.html.php 3240 2012-07-02 02:05:23Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<table class='cont-rt5'>
  <caption>
    <?php echo $project->name;?>
    <div class='f-right f-16px strong'>
      <?php
      $browseLink = $this->session->projectList ? $this->session->projectList : inlink('task', "projectID=$project->id");
      if(!$project->deleted)
      {
          common::printLink('project', 'edit',   "projectID=$project->id", $lang->project->edit);
          common::printLink('project', 'delete', "projectID=$project->id", $lang->project->delete, 'hiddenwin');
      }
      echo html::a($browseLink, $lang->goback);
      ?>
    </div>
   </caption>
   <tr valign='top'>
     <td>
       <fieldset>
         <legend><?php echo $lang->project->desc;?></legend>
         <div class='content'><?php echo $project->desc;?></div>
       </fieldset>
       <?php include '../../common/view/action.html.php';?>
       <div class='a-center f-16px strong'>
       <?php 
      $browseLink = $this->session->projectList ? $this->session->projectList : inlink('task', "projectID=$project->id");
      if(!$project->deleted)
      {
          common::printLink('project', 'edit',   "projectID=$project->id", $lang->project->edit);
          common::printLink('project', 'delete', "projectID=$project->id", $lang->project->delete, 'hiddenwin');
      }
      echo html::a($browseLink, $lang->goback);
      ?>
      </div>
    </td>
    <td class="divider"></td>
    <td class="side">
      <fieldset>
        <legend><?php echo $lang->project->basicInfo?></legend>
        <table class='table-1 a-left'>
          <tr>
            <th width='25%' class='a-right'><?php echo $lang->project->name;?></th>
            <td <?php if($project->deleted) echo "class='deleted'";?>><?php echo $project->name;?></td>
          </tr>
          <tr>
            <th class='rowhead'><?php echo $lang->project->code;?></th>
        <td><?php echo $project->code;?></td>
          </tr>
          <tr>
            <th class='rowhead'><?php echo $lang->project->beginAndEnd;?></th>
            <td><?php echo $project->begin . ' ~ ' . $project->end;?></td>
          </tr>
          <tr>
            <th class='rowhead'><?php echo $lang->project->days;?></th>
            <td><?php echo $project->days;?></td>
          </tr>
          <tr>
            <th class='rowhead'><?php echo $lang->project->goal;?></th>
            <td class='content'><?php echo $project->goal;?></td>
          </tr>
         <tr> 
           <th class='rowhead'><?php echo $lang->project->status;?></th>
           <td class='<?php echo $project->status;?>'><?php $lang->show($lang->project->statusList, $project->status);?></td>
        </tr>
        <tr>
          <th class='rowhead'><?php echo $lang->project->PM;?></th>
          <td><?php echo $users[$project->PM];?></td>
       </tr>
       <tr>
         <th class='rowhead'><?php echo $lang->project->PO;?></th>
         <td><?php echo $users[$project->PO];?></td>
      </tr>
      <tr>
        <th class='rowhead'><?php echo $lang->project->QM;?></th>
        <td><?php echo $users[$project->QM];?></td>
     </tr>
     <tr>
       <th class='rowhead'><?php echo $lang->project->RM;?></th>
       <td><?php echo $users[$project->RM];?></td>
    </tr>
    <tr>
      <th  class='rowhead'><?php echo $lang->project->products;?></th>
      <td>
        <?php foreach($products as $productID => $productName) echo html::a($this->createLink('product', 'browse', "productID=$productID"), $productName) . '<br />';?>
      </td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->project->acl;?></th>
      <td><?php echo $lang->project->aclList[$project->acl];?></td>
    </tr>  
    <tr>
      <th class='rowhead'><?php echo $lang->project->whitelist;?></th>
      <td>
        <?php
        $whitelist = explode(',', $project->whitelist);
        foreach($whitelist as $groupID) if(isset($groups[$groupID])) echo $groups[$groupID] . '&nbsp;';
        ?>
     </td>
   </tr>  
 </table>
</fieldset>
<fieldset>
  <legend><?php echo $lang->project->otherInfo?></legend>
  <table class='table-1 a-left'>
    <tr>
      <th class='rowhead'><?php echo $lang->project->lblStats;?></th>
      <td><?php printf($lang->project->stats, $project->totalHours, $project->totalEstimate, $project->totalConsumed, $project->totalLeft, 10)?></td>
   </tr>
  </table>
 </fieldset>
</td>
</tr>
</table>
  <?php include '../../common/view/footer.html.php';?>
