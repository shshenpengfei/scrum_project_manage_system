<?php
/**
 * The task module zh-tw file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青島易軟天創網絡科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     task
 * @version     $Id: zh-tw.php 3341 2012-07-14 07:26:53Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
$lang->task->index              = "任務一覽";
$lang->task->create             = "新增";
$lang->task->batchCreate        = "批量添加";
$lang->task->batchEdit          = "批量編輯";
$lang->task->import             = "導入之前未完任務";
$lang->task->edit               = "編輯";
$lang->task->delete             = "刪除";
$lang->task->view               = "查看任務";
$lang->task->logEfforts         = "記錄工時";
$lang->task->start              = "開始";
$lang->task->finish             = "完成";
$lang->task->close              = "關閉";
$lang->task->batchClose         = "批量關閉";
$lang->task->cancel             = "取消";
$lang->task->activate           = "激活";
$lang->task->export             = "導出";
$lang->task->reportChart        = "報表統計";
$lang->task->fromBug            = '來源Bug';
$lang->task->confirmStoryChange = "確認需求變動";
$lang->task->reportChart        = "今日報錶";
$lang->task->reportToMail        = "髮送報錶";

$lang->task->common            = '任務';
$lang->task->id                = '編號';
$lang->task->project           = '所屬項目';
$lang->task->module            = '所屬模組';
$lang->task->story             = '相關需求';
$lang->task->storyVersion      = '需求版本';
$lang->task->name              = '任務名稱';
$lang->task->type              = '任務類型';
$lang->task->pri               = '優先順序';
$lang->task->mailto            = '抄送給';
$lang->task->estimate          = '最初預計';
$lang->task->estimateAB        = '預';
$lang->task->left              = '預計剩餘';
$lang->task->leftAB            = '剩';
$lang->task->consumed          = '已經消耗';
$lang->task->consumedAB        = '耗';
$lang->task->hour              = '小時';
$lang->task->estStarted        = '預計開始';
$lang->task->realStarted       = '實際開始';
$lang->task->deadline          = '截止日期';
$lang->task->deadlineAB        = '截止';
$lang->task->status            = '任務狀態';
$lang->task->statusCustom      = '狀態排序';
$lang->task->desc              = '任務描述';
$lang->task->assign            = '指派';
$lang->task->assignTo          = $lang->task->assign;
$lang->task->assignedTo        = '指派給';
$lang->task->assignedToAB      = '指派給';
$lang->task->assignedDate      = '指派日期';
$lang->task->openedBy          = '由誰創建';
$lang->task->openedByAB        = '創建者';
$lang->task->openedDate        = '創建日期';
$lang->task->openedDateAB      = '創建';
$lang->task->finishedBy        = '由誰完成';
$lang->task->finishedByAB      = '完成者';
$lang->task->finishedDate      = '完成時間';
$lang->task->finishedDateAB    = '完成';
$lang->task->canceledBy        = '由誰取消';
$lang->task->canceledDate      = '取消時間';
$lang->task->closedBy          = '由誰關閉';
$lang->task->closedDate        = '關閉時間';
$lang->task->closedReason      = '關閉原因';
$lang->task->lastEditedBy      = '最後修改';
$lang->task->lastEditedDate    = '最後修改日期';
$lang->task->lastEdited        = '最後編輯';

$lang->task->same  = '同上';
$lang->task->notes = '(註：“任務類型”、“任務名稱”、“優先順序”和“預計工時”必需填寫，否則此行無效)';

$lang->task->statusList['']        = '';
$lang->task->statusList['wait']    = '未開始';
$lang->task->statusList['doing']   = '進行中';
$lang->task->statusList['done']    = '已完成';
$lang->task->statusList['cancel']  = '已取消';
$lang->task->statusList['closed']  = '已關閉';

$lang->task->typeList['']        = '';
$lang->task->typeList['design']  = '設計';
$lang->task->typeList['devel']   = '開發';
$lang->task->typeList['test']    = '測試';
$lang->task->typeList['study']   = '研究';
$lang->task->typeList['discuss'] = '討論';
$lang->task->typeList['ui']      = '界面';
$lang->task->typeList['affair']  = '事務';
$lang->task->typeList['misc']    = '其他';

$lang->task->priList[0]  = '';
$lang->task->priList[3]  = '3';
$lang->task->priList[1]  = '1';
$lang->task->priList[2]  = '2';
$lang->task->priList[4]  = '4';

$lang->task->reasonList['']       = '';
$lang->task->reasonList['done']   = '已完成';
$lang->task->reasonList['cancel'] = '已取消';

$lang->task->afterChoices['continueAdding'] = '繼續為該需求添加任務';
$lang->task->afterChoices['toTastList']     = '返回任務列表';
$lang->task->afterChoices['toStoryList']    = '返回需求列表';

$lang->task->buttonEdit       = '編輯';
$lang->task->buttonClose      = '關閉';
$lang->task->buttonCancel     = '取消';
$lang->task->buttonActivate   = '激活';
$lang->task->buttonLogEfforts = '記錄工時';
$lang->task->buttonDelete     = '刪除';
$lang->task->buttonBackToList = '返回';
$lang->task->buttonStart      = '開始';
$lang->task->buttonDone       = '完成';

$lang->task->legendBasic  = '基本信息';
$lang->task->legendEffort = '工時信息';
$lang->task->legendLife   = '任務的一生';
$lang->task->legendDesc   = '任務描述';
$lang->task->legendAction = '操作';

$lang->task->ajaxGetUserTasks    = "介面:我的任務";
$lang->task->ajaxGetProjectTasks = "介面:項目任務";
$lang->task->confirmDelete       = "您確定要刪除這個任務嗎？";
$lang->task->copyStoryTitle      = "同需求";
$lang->task->afterSubmit         = "添加之後";
$lang->task->successSaved        = "成功添加，";
$lang->task->delayWarning        = " <strong class='delayed f-14px'> 延期%s天 </strong>";
$lang->task->remindBug           = "該任務為Bug轉化得到，是否更新Bug:%s ?";

/* 統計報表。*/
$lang->task->report->common = '報表';
$lang->task->report->select = '請選擇報表類型';
$lang->task->report->create = '生成報表';

$lang->task->report->charts['tasksPerProject']      = '項目任務數統計';
$lang->task->report->charts['tasksPerModule']       = '模組任務數統計';
$lang->task->report->charts['tasksPerAssignedTo']   = '指派給統計';
$lang->task->report->charts['tasksPerType']         = '任務類型統計';
$lang->task->report->charts['tasksPerPri']          = '優先順序統計';
$lang->task->report->charts['tasksPerStatus']       = '任務狀態統計';
$lang->task->report->charts['tasksPerDeadline']     = '截止日期統計';
$lang->task->report->charts['tasksPerEstimate']     = '預計時間統計';
$lang->task->report->charts['tasksPerLeft']         = '剩餘時間統計';
$lang->task->report->charts['tasksPerConsumed']     = '消耗時間統計';
$lang->task->report->charts['tasksPerFinishedBy']   = '由誰完成統計';
$lang->task->report->charts['tasksPerClosedReason'] = '關閉原因統計';
$lang->task->report->charts['finishedTasksPerDay']  = '每天完成統計';

$lang->task->report->options->swf                     = 'pie2d';
$lang->task->report->options->width                   = 'auto';
$lang->task->report->options->height                  = 300;
$lang->task->report->options->graph->baseFontSize     = 12;
$lang->task->report->options->graph->showNames        = 1;
$lang->task->report->options->graph->formatNumber     = 1;
$lang->task->report->options->graph->decimalPrecision = 0;
$lang->task->report->options->graph->animation        = 0;
$lang->task->report->options->graph->rotateNames      = 0;
$lang->task->report->options->graph->yAxisName        = 'COUNT';
$lang->task->report->options->graph->pieRadius        = 100; // 餅圖直徑。
$lang->task->report->options->graph->showColumnShadow = 0;   // 是否顯示柱狀圖陰影。

$lang->task->report->tasksPerProject->graph->xAxisName      = '項目';
$lang->task->report->tasksPerModule->graph->xAxisName       = '模組';
$lang->task->report->tasksPerAssignedTo->graph->xAxisName   = '用戶';
$lang->task->report->tasksPerType->graph->xAxisName         = '類型';
$lang->task->report->tasksPerPri->graph->xAxisName          = '優先順序';
$lang->task->report->tasksPerStatus->graph->xAxisName       = '狀態';
$lang->task->report->tasksPerDeadline->graph->xAxisName     = '日期';
$lang->task->report->tasksPerEstimate->graph->xAxisName     = '時間';
$lang->task->report->tasksPerLeft->graph->xAxisName         = '時間';
$lang->task->report->tasksPerConsumed->graph->xAxisName     = '時間';
$lang->task->report->tasksPerFinishedBy->graph->xAxisName   = '用戶';
$lang->task->report->tasksPerClosedReason->graph->xAxisName = '關閉原因';

$lang->task->report->finishedTasksPerDay->swf                = 'column2d';
$lang->task->report->finishedTasksPerDay->height             = 400;
$lang->task->report->finishedTasksPerDay->graph->xAxisName   = '日期';
$lang->task->report->finishedTasksPerDay->graph->rotateNames = '1';

$lang->task->placeholder->estimate = '對該任務最初的預計';
$lang->task->placeholder->mailto   = '輸入用戶名進行選擇'; 
