<?php
/**
 * The view file of story module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     story
 * @version     $Id: view.html.php 3360 2012-07-16 08:09:51Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>


<div id='titlebar'>
  <div id='main' <?php if($sql->deleted) echo "class='deleted'";?>>SQL #<?php echo $sql->id . $lang->colon . $sql->title;?></div>
    <div>
        <?php
        $browseLink = $app->session->storyList != false ? $app->session->storyList : $this->createLink('product', 'browse', "productID=$sql->product&moduleID=$sql->module");
        if(!$sql->deleted)
        {
            ob_start();

            if($this->sqlreview->isClickable($sql, 'change')) common::printIcon('sqlreview', 'change', "sqlID=$sql->id");
            if($this->sqlreview->isClickable($sql, 'review')) common::printIcon('sqlreview', 'review', "sqlID=$sql->id");
            if($this->sqlreview->isClickable($sql, 'close'))  common::printIcon('sqlreview', 'close',  "sqlID=$sql->id");
            if($this->sqlreview->isClickable($sql, 'activate'))  common::printIcon('sqlreview', 'activate',  "sqlID=$sql->id");
            if($this->sqlreview->isClickable($sql, 'dba'))  common::printIcon('sqlreview', 'dba',  "sqlID=$sql->id");

            common::printDivider();
            common::printIcon('sqlreview', 'edit', "sqlID=$sql->id");
            common::printCommentIcon('sqlreview');
            common::printIcon('sqlreview', 'create', "projectID=$sql->project&sqlID=$sql->id&moduleID=$sql->module", '', 'button', 'copy');
            common::printIcon('sqlreview', 'delete', "sqlID=$sql->id", '', 'button', '', 'hiddenwin');

            common::printDivider();
            common::printRPN($browseLink, $preAndNext);

            $actionLinks = ob_get_contents();
            ob_clean();
            echo $actionLinks;
        }
        ?>
    </div>
</div>

<table class='cont-rt5'>
  <tr valign='top'>
    <td>
      <fieldset>
        <legend><?php echo $lang->sqlreview->content;?></legend>
        <div class='content'><?php echo nl2br($sql->content);?></div>
      </fieldset>
    <fieldset>
        <legend><?php echo $lang->sqlreview->host;?> / <?php echo $lang->sqlreview->db;?></legend>
        <div class='content'>alpha：<?php echo $sql->host_alpha;?> / <?php echo $sql->db_alpha;?></div>
        <div class='content'>beta：<?php echo $sql->host_beta;?> / <?php echo $sql->db_beta;?></div>
        <div class='content'>online：<?php echo $sql->host_online;?> / <?php echo $sql->db_online;?></div>
    </fieldset>
      <?php include '../../common/view/action.html.php';?>
        <div class='a-center actionlink'><?php if(!$sql->deleted) echo $actionLinks;?></div>
      <div id='comment' class='hidden'>
        <fieldset>
          <legend><?php echo $lang->comment;?></legend>
          <form method='post' action='<?php echo inlink('edit', "storyID=$sql->id")?>'>
            <table align='center' class='table-1'>
            <tr><td><?php echo html::textarea('comment', '',"rows='5' class='w-p100'");?></td></tr>
            <tr><td><?php echo html::submitButton() . html::resetButton();?></td></tr>
            </table>
          </form>
        </fieldset>
      </div>
    </td>
    <td class='divider'></td>
    <td class='side'>
      <fieldset>
        <legend><?php echo $lang->story->legendBasicInfo;?></legend>
        <table class='table-1'>

          <tr>
            <td class='rowhead'><?php echo $lang->story->source;?></td>
            <td><?php echo $lang->story->sourceList[$sql->source];?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->status;?></td>
            <td><?php echo $lang->story->statusList[$sql->status];?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->stage;?></td>
            <td><?php echo $lang->sqlreview->stageList[$sql->stage];?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->pri;?></td>
            <td><?php echo $lang->story->priList[$sql->pri];?></td>
          </tr>

          <tr>
            <td class='rowhead'><?php echo $lang->story->keywords;?></td>
            <td><?php echo $sql->keywords;?></td>
          </tr>
        </table>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->story->legendLifeTime;?></legend>
        <table class='table-1'>
          <tr>
            <td class='rowhead w-p20'><?php echo $lang->story->openedBy;?></td>
            <td><?php echo $users[$sql->openedBy] . $lang->at . $sql->openedDate;?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->assignedTo;?></td>
            <td><?php if($sql->assignedTo) echo $users[$sql->assignedTo] . $lang->at . $sql->assignedDate;?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->reviewedBy;?></td>
            <td><?php $reviewedBy = explode(',', $sql->reviewedBy); foreach($reviewedBy as $account) echo ' ' . $users[trim($account)]; ?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->reviewedDate;?></td>
            <td><?php if($sql->reviewedBy) echo $sql->reviewedDate;?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->closedBy;?></td>
            <td><?php if($sql->closedBy) echo $users[$sql->closedBy] . $lang->at . $sql->closedDate;?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->closedReason;?></td>
            <td>
              <?php
              if($sql->closedReason) echo $lang->story->reasonList[$sql->closedReason];
              ?>
            </td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->lastEditedBy;?></td>
            <td><?php if($sql->lastEditedBy) echo $users[$sql->lastEditedBy] . $lang->at . $sql->lastEditedDate;?></td>
          </tr>
        </table>
      </fieldset>




        <legend><?php echo $lang->story->legendMailto;?></legend>
        <div><?php $mailto = explode(',', $sql->mailto); foreach($mailto as $account) echo ' ' . $users[trim($account)]; ?></div>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->story->legendVersion;?></legend>
        <div><?php for($i = $sql->version; $i >= 1; $i --) echo html::a(inlink('view', "storyID=$sql->id&version=$i"), "#$i");?></div>
      </fieldset>
    </td>
  </tr>
</table>
<?php include '../../common/view/footer.html.php';?>
