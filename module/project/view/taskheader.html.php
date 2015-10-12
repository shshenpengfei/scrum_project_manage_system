<div id='featurebar'>
  <div class='f-left'>
  <?php
    echo "<span id='byprojectTab' onclick='browseByProject()'>"; common::printLink('project', 'task',"project=$project->id&type=byProject", $lang->project->projectTasks); echo '</span>';
    echo "<span id='bymoduleTab'  onclick='browseByModule()'>";  common::printLink('project', 'task',"project=$project->id&type=byModule", $lang->project->moduleTask); echo '</span>';
    echo "<span id='allTab'>"         ; common::printLink('project', 'task', "project=$project->id&type=all",          $lang->project->allTasks);     echo  '</span>' ;
    echo "<span id='assignedtomeTab'>"; common::printLink('project', 'task', "project=$project->id&type=assignedtome", $lang->project->assignedToMe); echo  '</span>' ;
    echo "<span id='finishedbymeTab'>"; common::printLink('project', 'task', "project=$project->id&type=finishedbyme", $lang->project->finishedByMe); echo  '</span>' ;
    echo "<span id='waitTab'>"        ; common::printLink('project', 'task', "project=$project->id&type=wait",         $lang->project->statusWait);   echo  '</span>' ;
    echo "<span id='doingTab'>"       ; common::printLink('project', 'task', "project=$project->id&type=doing",        $lang->project->statusDoing);  echo  '</span>' ;
    echo "<span id='doneTab'>"        ; common::printLink('project', 'task', "project=$project->id&type=done",         $lang->project->statusDone);   echo  '</span>' ;
    echo "<span id='closedTab'>"      ; common::printLink('project', 'task', "project=$project->id&type=closed",       $lang->project->statusClosed); echo  '</span>' ;
    echo "<span id='delayedTab'>"     ; common::printLink('project', 'task', "project=$project->id&type=delayed",      $lang->project->delayed);      echo  '</span>' ;

    echo "<span id='groupTab'>";
    echo html::select('groupBy', $lang->project->groups, isset($groupBy) ? $groupBy : '', "onchange='switchGroup({$project->id}, this.value)'");
    echo "</span>";
    echo "<span id='needconfirmTab'>"; common::printLink('project', 'task',  "project=$project->id&status=needConfirm",$lang->project->listTaskNeedConfrim); echo  '</span>' ;
    echo "<span id='bysearchTab'><a href='#'><span class='icon-search'></span>{$lang->project->byQuery}</a></span> ";
    ?>
  </div>
  <div class='f-right'>
      <span class="link-button">
        <a href="/index.php?m=task&amp;f=reportToMail&amp;project=<?=$projectID?>" target="_blank" class="">今日报表发送</a>
      </span>
    <?php 
    if($browseType != 'needconfirm') common::printIcon('task', 'export', "projectID=$projectID&orderBy=$orderBy");
    common::printIcon('task', 'report', "project=$project->id&browseType=$browseType");
    common::printIcon('task', 'batchCreate', "projectID=$project->id");
    common::printIcon('task', 'create', "project=$project->id");
    ?>
  </div>
</div>
