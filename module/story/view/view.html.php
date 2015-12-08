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

<?php
//if(isset($_GET['gante']) && $_GET['gante']=='story'){

if(!empty($story->tasks) && true == false ){
$webRoot      = PM_SITE;
$defaultTheme = $webRoot . 'theme/default/';
css::import($defaultTheme . 'gante_styles/css/screen.css', 2.3);
css::import($defaultTheme . 'gante_styles/css/gantti.css', 2.3);
require('../../m_gante/lib/gantti.php');
date_default_timezone_set('UTC');
setlocale(LC_ALL, 'en_US');
$data = array();

              foreach($story->tasks as $projectTasks)
              {
                  foreach($projectTasks as $task)
                  {
                      if($task->type == 'test'){
                        $data[]=  array(
                            'label'=>"[".$users[$task->assignedTo]."]".$task->name,
                            'start' => $task->estStarted,
                            'end'   => $task->deadline." 24:00:00",
                            'class'=>'urgent'
                        );
                      }
                      else{
                        $data[]=  array(
                            'label'=>"[".$users[$task->assignedTo]."]".$task->name,
                            'start' => $task->estStarted,
                            'end'   => $task->deadline." 24:00:00",
                            //'class'=>'urgent'
                        );
                      }
                  }
              }

$gantti = new Gantti($data, array(
  'title'      => '需求分解甘特图',
  'cellwidth'  => 60,
  'cellheight' => 33
));

echo $gantti;
}

?>

<div id='titlebar'>
  <div id='main' <?php if($story->deleted) echo "class='deleted'";?>>STORY #<?php echo $story->id . $lang->colon . $story->title;?></div>
  <div>
  <?php
  $browseLink = $app->session->storyList != false ? $app->session->storyList : $this->createLink('product', 'browse', "productID=$story->product&moduleID=$story->module");
  if(!$story->deleted)
  {
      ob_start();

      if($this->story->isClickable($story, 'change')) common::printIcon('story', 'change', "storyID=$story->id");
      if($this->story->isClickable($story, 'review')) common::printIcon('story', 'review', "storyID=$story->id");
      if($this->story->isClickable($story, 'close'))  common::printIcon('story', 'close',  "storyID=$story->id");
      if($this->story->isClickable($story, 'activate'))  common::printIcon('story', 'activate',  "storyID=$story->id");
      common::printIcon('story', 'createCase', "productID=$story->product&moduleID=0&from=&param=0&storyID=$story->id", '', 'button', 'createCase');

      common::printDivider();
      common::printIcon('story', 'edit', "storyID=$story->id");
      common::printCommentIcon('story');
      common::printIcon('story', 'create', "productID=$story->product&moduleID=$story->module&storyID=$story->id", '', 'button', 'copy');
      common::printIcon('story', 'delete', "storyID=$story->id", '', 'button', '', 'hiddenwin');

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
        <legend><?php echo $lang->story->legendSpec;?></legend>
        <div class='content'><?php echo $story->spec;?></div>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->story->legendVerify;?></legend>
        <div class='content'><?php echo $story->verify;?></div>
      </fieldset>
      <?php echo $this->fetch('file', 'printFiles', array('files' => $story->files, 'fieldset' => 'true'));?>

        <fieldset>
            <legend>TDD  测试驱动-测试用例(请产品、开发、测试同事注意，测试用例作为story的check标准之一)</legend>
        <?php
        if($cases){
            foreach($cases as $case)
            {
                echo '<span class="nobr">' . html::a($this->createLink('testcase', 'view', "caseID=$case->id"), "#".$case->id." - ".$case->title." - ".$users[$case->openedBy]) . '</span><br />';
            ?>
                <fieldset>
                    <legend><?php echo $lang->testcase->precondition;?></legend>
                    <?php echo $case->info->precondition;?>
                </fieldset>

                <table class='table-1 colored'>
                    <tr class='colhead'>
                        <th class='w-30px'><?php echo $lang->testcase->stepID;?></th>
                        <th class='w-150px'><?php echo $lang->testcase->stepDesc;?></th>
                        <th class='w-150px'><?php echo $lang->testcase->stepExpect;?></th>
                    </tr>
                    <?php
                    foreach($case->info->steps as $stepID => $step)
                    {
                        $stepID += 1;
                        echo "<tr><th class='rowhead w-id a-center strong'>$stepID</th>";
                        echo "<td>" . nl2br($step->desc) . "</td>";
                        echo "<td>" . nl2br($step->expect) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            <?php
            }
        }
        else{
            echo "测试工程师未编写测试用例，或者暂未指派功能测试的任务";
        }
        ?>
        </fieldset>



      <?php include '../../common/view/action.html.php';?>
      <div class='a-center actionlink'><?php if(!$story->deleted) echo $actionLinks;?></div>
      <div id='comment' class='hidden'>
        <fieldset>
          <legend><?php echo $lang->comment;?></legend>
          <form method='post' action='<?php echo inlink('edit', "storyID=$story->id")?>'>
            <table align='center' class='table-1'>
            <tr><td><?php echo html::textarea('comment', '',"rows='5' class='w-p100'");?></td></tr>
            <tr><td><?php echo html::submitButton() . html::resetButton();?></td></tr>
            </table>
          </form>
        </fieldset>
      </div>
    </td>
    <td class='divider'></div>
    <td class='side'>
      <fieldset>
        <legend><?php echo $lang->story->legendBasicInfo;?></legend>
        <table class='table-1'>
          <tr>
            <td class='rowhead w-p20'><?php echo $lang->story->product;?></td>
            <td><?php common::printLink('product', 'view', "productID=$story->product", $product->name);?>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->module;?></td>
            <td>
            <?php
            if(empty($modulePath))
            {
                echo "/";
            }
            else
            {
                foreach($modulePath as $key => $module)
                {
                    if(!common::printLink('product', 'browse', "productID=$story->product&browseType=byModule&param=$module->id", $module->name)) echo $module->name;
                    if(isset($modulePath[$key + 1])) echo $lang->arrow;
                }
            }
            ?>
            </td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->plan;?></td>
            <td><?php if(isset($story->planTitle)) if(!common::printLink('productplan', 'view', "planID=$story->plan", $story->planTitle)) echo $story->planTitle;?>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->source;?></td>
            <td><?php echo $lang->story->sourceList[$story->source];?></td>
          </tr>
            <tr>
                <th class='rowhead'><span style='color: #ff0000'><?php echo $lang->story->value;?></span></th>
                <td><?php echo "<span style='color: #ff0000'>".$story->creditvalue."分</span>";?></td>
            </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->status;?></td>
            <td><?php echo $lang->story->statusList[$story->status];?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->stage;?></td>
            <td><?php echo $lang->story->stageList[$story->stage];?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->pri;?></td>
            <td><?php echo $lang->story->priList[$story->pri];?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->estimate;?></td>
            <td><?php echo $story->estimate;?></td>
          </tr>
            <tr>
                <td class='rowhead'><?php echo $lang->story->devFinishdDate;?></td>
                <td><?php echo $story->devFinishdDate;?></td>
            </tr>
            <tr>
                <td class='rowhead'><?php echo $lang->story->testFinishdDate;?></td>
                <td><?php echo $story->testFinishdDate;?></td>
            </tr>

            <tr>
                <td class='rowhead'><?php echo $lang->story->releasedDate;?></td>
                <td><?php echo $story->releasedDate;?></td>
            </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->keywords;?></td>
            <td><?php echo $story->keywords;?></td>
          </tr>
        </table>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->story->legendLifeTime;?></legend>
        <table class='table-1'>
          <tr>
            <td class='rowhead w-p20'><?php echo $lang->story->openedBy;?></td>
            <td><?php echo $users[$story->openedBy] . $lang->at . $story->openedDate;?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->assignedTo;?></td>
            <td><?php if($story->assignedTo) echo $users[$story->assignedTo] . $lang->at . $story->assignedDate;?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->reviewedBy;?></td>
            <td><?php $reviewedBy = explode(',', $story->reviewedBy); foreach($reviewedBy as $account) echo ' ' . $users[trim($account)]; ?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->reviewedDate;?></td>
            <td><?php if($story->reviewedBy) echo $story->reviewedDate;?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->closedBy;?></td>
            <td><?php if($story->closedBy) echo $users[$story->closedBy] . $lang->at . $story->closedDate;?></td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->closedReason;?></td>
            <td>
              <?php
              if($story->closedReason) echo $lang->story->reasonList[$story->closedReason];
              if(isset($story->extraStories[$story->duplicateStory]))
              {
                  echo html::a(inlink('view', "storyID=$story->duplicateStory"), '#' . $story->duplicateStory . ' ' . $story->extraStories[$story->duplicateStory]);
              }
              ?>
            </td>
          </tr>
          <tr>
            <td class='rowhead'><?php echo $lang->story->lastEditedBy;?></td>
            <td><?php if($story->lastEditedBy) echo $users[$story->lastEditedBy] . $lang->at . $story->lastEditedDate;?></td>
          </tr>
        </table>
      </fieldset>

      <fieldset>
        <legend><?php echo $lang->story->legendProjectAndTask;?></legend>
        <table class='table-1 fixed'>
          <tr>
            <td>
              <?php
              foreach($story->tasks as $projectTasks)
              {
                  foreach($projectTasks as $task)
                  {
                      @$projectName = $story->projects[$task->project]->name;
                      echo html::a($this->createLink('project', 'browse', "projectID=$task->project"), $projectName);
                      echo '<span class="nobr">' . html::a($this->createLink('task', 'view', "taskID=$task->id"), "#$task->id $task->name") . '</span><br />';
                  }
              }
              ?>
            </td>
          </tr>
        </table>
      </fieldset>

      <fieldset>
        <legend><?php echo $lang->story->legendBugs;?></legend>
        <table class='table-1 fixed'>
          <tr>
            <td>
              <?php
              foreach($bugs as $bug)
              {
                  echo '<span class="nobr">' . html::a($this->createLink('bug', 'view', "bugID=$bug->id"), "#$bug->id $bug->title") . '</span><br />';
              }
              ?>
            </td>
          </tr>
        </table>
      </fieldset>

      <fieldset>
        <legend><?php echo $lang->story->legendCases;?></legend>
        <table class='table-1 fixed'>
          <tr>
            <td>
              <?php
              foreach($cases as $case)
              {
                  echo '<span class="nobr">' . html::a($this->createLink('testcase', 'view', "caseID=$case->id"), "#$case->id $case->title") . '</span><br />';
              }
              ?>
            </td>
          </tr>
        </table>
      </fieldset>

      <fieldset>
        <legend><?php echo $lang->story->legendLinkStories;?></legend>
        <div>
          <?php
          $linkStories = explode(',', $story->linkStories) ;
          foreach($linkStories as $linkStoryID)
          {
              if(isset($story->extraStories[$linkStoryID])) echo html::a(inlink('view', "storyID=$linkStoryID"), "#$linkStoryID " . $story->extraStories[$linkStoryID]) . '<br />';
          }
          ?>
        </div>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->story->legendChildStories;?></legend>
        <div>
          <?php
          $childStories = explode(',', $story->childStories) ;
          foreach($childStories as $childStoryID)
          {
              if(isset($story->extraStories[$childStoryID])) echo html::a(inlink('view', "storyID=$childStoryID"), "#$childStoryID " . $story->extraStories[$childStoryID]) . '<br />';
          }
          ?>
        </div>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->story->legendFromBug;?></legend>
        <div>
          <?php
          if(!empty($fromBug)) echo '<span class="nobr">' . html::a($this->createLink('bug', 'view', "bugID=$fromBug->id"), "#$fromBug->id $fromBug->title") . '</span><br />';
          ?>
        </div>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->story->legendMailto;?></legend>
        <div><?php $mailto = explode(',', $story->mailto); foreach($mailto as $account) echo ' ' . $users[trim($account)]; ?></div>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->story->legendVersion;?></legend>
        <div><?php for($i = $story->version; $i >= 1; $i --) echo html::a(inlink('view', "storyID=$story->id&version=$i"), "#$i");?></div>
      </fieldset>
    </td>
  </tr>
</table>
<?php include '../../common/view/footer.html.php';?>
