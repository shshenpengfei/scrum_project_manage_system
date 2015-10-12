<?php
/**
 * The sqlreview module zh-cn file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     sqlreview
 * @version     $Id: zh-cn.php 3341 2012-07-14 07:26:53Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
$lang->sqlreview->browse      = "SQL列表";
$lang->sqlreview->create      = "新增";
$lang->sqlreview->createCase  = "建用例";
$lang->sqlreview->batchCreate = "批量添加";
$lang->sqlreview->change      = "变更";
$lang->sqlreview->changed     = '变更SQL';
$lang->sqlreview->review      = '评审';
$lang->sqlreview->edit        = "编辑SQL";
$lang->sqlreview->close       = '关闭';
$lang->sqlreview->batchClose  = '批量关闭';
$lang->sqlreview->activate    = '激活';
$lang->sqlreview->delete      = "删除SQL";
$lang->sqlreview->view        = "SQL详情";
$lang->sqlreview->tasks       = "相关任务";
$lang->sqlreview->taskCount   = '任务数';
$lang->sqlreview->bugs        = "Bug";
$lang->sqlreview->linksqlreview   = '关联需求';
$lang->sqlreview->export      = "导出";
$lang->sqlreview->reportChart = "统计报表";
$lang->sqlreview->dba = "DBA执行";

$lang->sqlreview->common         = 'SQL评审';
$lang->sqlreview->id             = '编号';
$lang->sqlreview->product        = '所属产品';
$lang->sqlreview->module         = '所属模块';
$lang->sqlreview->source         = '来源';
$lang->sqlreview->fromBug        = '来源Bug';
$lang->sqlreview->release        = '发布计划';
$lang->sqlreview->bug            = '相关bug';
$lang->sqlreview->title          = 'SQL名称';
$lang->sqlreview->content           = 'SQL内容';
$lang->sqlreview->verify         = '验收标准';
$lang->sqlreview->type           = 'SQL类型 ';
$lang->sqlreview->pri            = '优先级';
$lang->sqlreview->estimate       = '预计工时';
$lang->sqlreview->estimateAB     = '预计';
$lang->sqlreview->hour           = '小时';
$lang->sqlreview->status         = '当前状态';
$lang->sqlreview->stage          = '所处阶段';
$lang->sqlreview->stageAB        = '阶段';
$lang->sqlreview->mailto         = '抄送给';
$lang->sqlreview->openedBy       = '由谁创建';
$lang->sqlreview->openedDate     = '创建日期';
$lang->sqlreview->assignedTo     = '指派给';
$lang->sqlreview->assignedDate   = '指派日期';
$lang->sqlreview->lastEditedBy   = '最后修改';
$lang->sqlreview->lastEditedDate = '最后修改日期';
$lang->sqlreview->lastEdited     = '最后修改';
$lang->sqlreview->closedBy       = '由谁关闭';
$lang->sqlreview->closedDate     = '关闭日期';
$lang->sqlreview->closedReason   = '关闭原因';
$lang->sqlreview->rejectedReason = '拒绝原因';
$lang->sqlreview->reviewedBy     = '由谁评审';
$lang->sqlreview->reviewedDate   = '评审时间';
$lang->sqlreview->version        = '版本号';
$lang->sqlreview->project        = '所属项目';
$lang->sqlreview->plan           = '所属计划';
$lang->sqlreview->planAB         = '计划';
$lang->sqlreview->comment        = '备注';
$lang->sqlreview->linkStories    = '相关需求';
$lang->sqlreview->childStories   = '细分需求';
$lang->sqlreview->duplicatesqlreview = '重复需求';
$lang->sqlreview->reviewResult   = '评审结果';
$lang->sqlreview->preVersion     = '之前版本';
$lang->sqlreview->keywords       = '关键词';
$lang->sqlreview->newsqlreview       = '继续添加SQL';
$lang->sqlreview->host       = '执行HOST';
$lang->sqlreview->db       = '执行DB';

$lang->sqlreview->same = '同上';

$lang->sqlreview->useList[0] = '不使用';
$lang->sqlreview->useList[1] = '使用';

$lang->sqlreview->statusList['']          = '';
$lang->sqlreview->statusList['draft']     = '草稿';
$lang->sqlreview->statusList['active']    = '审核通过';
$lang->sqlreview->statusList['closed']    = '已关闭';
$lang->sqlreview->statusList['changed']   = '已变更';

$lang->sqlreview->stageList['']           = '';
$lang->sqlreview->stageList['wait']       = '待审核';
$lang->sqlreview->stageList['passed']    = '审核通过';
$lang->sqlreview->stageList['alpha_exec']     = '内网已执行';
$lang->sqlreview->stageList['beta_exec']   = '预发布已执行';
$lang->sqlreview->stageList['released']   = '外网已执行';
$lang->sqlreview->reasonList['']           = '';
$lang->sqlreview->reasonList['done']       = '已完成';
$lang->sqlreview->reasonList['subdivided'] = '已细分';
$lang->sqlreview->reasonList['duplicate']  = '重复';
$lang->sqlreview->reasonList['postponed']  = '延期';
$lang->sqlreview->reasonList['willnotdo']  = '不做';
$lang->sqlreview->reasonList['cancel']     = '已取消';
$lang->sqlreview->reasonList['bydesign']   = '设计如此';
//$lang->sqlreview->reasonList['isbug']      = '是个Bug';

$lang->sqlreview->reviewResultList['']        = '';
$lang->sqlreview->reviewResultList['pass']    = '确认通过';
$lang->sqlreview->reviewResultList['revert']  = '撤销变更';
$lang->sqlreview->reviewResultList['clarify'] = '有待明确';
$lang->sqlreview->reviewResultList['reject']  = '拒绝';

$lang->sqlreview->reviewList[0] = '否';
$lang->sqlreview->reviewList[1] = '是';

$lang->sqlreview->sourceList['']           = '';
$lang->sqlreview->sourceList['TD']        = '部门总监';
$lang->sqlreview->sourceList['kaifa']        = '开发团队';
$lang->sqlreview->sourceList['chanpin']        = '产品组';
$lang->sqlreview->sourceList['tuiguang']        = '推广组';
$lang->sqlreview->sourceList['bianji']        = '编辑组';
$lang->sqlreview->sourceList['kefu']        = '客服组';
$lang->sqlreview->sourceList['yingxiao']        = '营销团队';
$lang->sqlreview->sourceList['gongsi']        = '公司';
$lang->sqlreview->sourceList['bug']        = 'Bug';
$lang->sqlreview->sourceList['customer']   = '客户';
$lang->sqlreview->sourceList['user']       = '用户';
$lang->sqlreview->sourceList['market']     = '市场';
$lang->sqlreview->sourceList['service']    = '客服';
$lang->sqlreview->sourceList['competitor'] = '竞争对手';
$lang->sqlreview->sourceList['partner']    = '合作伙伴';
$lang->sqlreview->sourceList['dev']        = '开发人员';
$lang->sqlreview->sourceList['tester']     = '测试人员';
$lang->sqlreview->sourceList['po']         = '产品经理';
$lang->sqlreview->sourceList['other']      = '其他';


$lang->sqlreview->priList[]   = '';
$lang->sqlreview->priList[3]  = '3';
$lang->sqlreview->priList[1]  = '1';
$lang->sqlreview->priList[2]  = '2';
$lang->sqlreview->priList[4]  = '4';

$lang->sqlreview->legendBasicInfo      = '基本信息';
$lang->sqlreview->legendLifeTime       = '需求的一生';
$lang->sqlreview->legendRelated        = '相关信息';
$lang->sqlreview->legendMailto         = '抄送给';
$lang->sqlreview->legendAttatch        = '附件';
$lang->sqlreview->legendProjectAndTask = '项目任务';
$lang->sqlreview->legendBugs           = '相关Bug';
$lang->sqlreview->legendFromBug        = '来源Bug';
$lang->sqlreview->legendCases          = '相关用例';
$lang->sqlreview->legendLinkStories    = '相关需求';
$lang->sqlreview->legendChildStories   = '细分需求';
$lang->sqlreview->legendSpec           = '需求描述';
$lang->sqlreview->legendVerify         = '验收标准';
$lang->sqlreview->legendHisqlreview        = '历史记录';
$lang->sqlreview->legendVersion        = '历史版本';
$lang->sqlreview->legendMisc           = '其他相关';

$lang->sqlreview->lblChange            = '变更SQL';
$lang->sqlreview->lblReview            = '评审SQL';
$lang->sqlreview->lblActivate          = '激活SQL';
$lang->sqlreview->lblClose             = '关闭SQL';

$lang->sqlreview->affectedProjects     = '影响的项目';
$lang->sqlreview->affectedBugs         = '影响的Bug';
$lang->sqlreview->affectedCases        = '影响的用例';

$lang->sqlreview->specTemplate          = "建议参考的模板：作为一名<<i class='red'>某种类型的用户</i>>，我希望<<i class='red'>达成某些目的</i>>，这样可以<<i class='red'>开发的价值</i>>。";
$lang->sqlreview->notes                 = '(注：如果“SQL名称”为空，则表示不使用此行)';
$lang->sqlreview->needNotReview         = '不需要评审';
$lang->sqlreview->afterSubmit           = "添加之后";
$lang->sqlreview->successSaved          = "SQL成功添加，";
$lang->sqlreview->confirmDelete         = "您确认删除该SQL评审吗?";
$lang->sqlreview->confirmBatchClose     = "您确认关闭这些SQL吗?";
$lang->sqlreview->errorFormat           = 'SQL数据有误';
$lang->sqlreview->errorEmptyTitle       = '标题不能为空';
$lang->sqlreview->mustChooseResult      = '必须选择评审结果';
$lang->sqlreview->mustChoosePreVersion  = '必须选择回溯的版本';
$lang->sqlreview->ajaxGetProjectStories = '接口:获取项目SQL列表';
$lang->sqlreview->ajaxGetProductStories = '接口:获取产品需求列表';
$lang->sqlreview->ajaxGetUnFinishedFlag = '接口:获取未完成的任务标识';
$lang->sqlreview->ajaxGetFlagOfBacklog = '接口:获取是否允许计划标识';

$lang->sqlreview->form->titleNote = '一句话简要表达需求内容';
$lang->sqlreview->form->area      = '该需求所属范围';
$lang->sqlreview->form->desc      = '描述及标准，什么需求？如何验收？';
$lang->sqlreview->form->resource  = '资源分配，有谁完成？需要多少时间？';
$lang->sqlreview->form->file      = '附件，如果该需求有相关文件，请点此上传。';

$lang->sqlreview->action->reviewed            = array('main' => '$date, 由 <strong>$actor</strong> 记录评审结果，结果为 <strong>$extra</strong>。', 'extra' => $lang->sqlreview->reviewResultList);
$lang->sqlreview->action->closed              = array('main' => '$date, 由 <strong>$actor</strong> 关闭，原因为 <strong>$extra</strong>。', 'extra' => $lang->sqlreview->reasonList);
$lang->sqlreview->action->linked2plan         = array('main' => '$date, 由 <strong>$actor</strong> 关联到计划 <strong>$extra</strong>。'); 
$lang->sqlreview->action->unlinkedfromplan    = array('main' => '$date, 由 <strong>$actor</strong> 从计划 <strong>$extra</strong> 移除。'); 
$lang->sqlreview->action->linked2project      = array('main' => '$date, 由 <strong>$actor</strong> 关联到项目 <strong>$extra</strong>。'); 
$lang->sqlreview->action->unlinkedfromproject = array('main' => '$date, 由 <strong>$actor</strong> 从项目 <strong>$extra</strong> 移除。'); 

/* 统计报表。*/
$lang->sqlreview->report->common = '报表';
$lang->sqlreview->report->select = '请选择报表类型';
$lang->sqlreview->report->create = '生成报表';

$lang->sqlreview->report->charts['sqlreviewsPerProduct']        = '产品需求数量';
$lang->sqlreview->report->charts['sqlreviewsPerModule']         = '模块需求数量';
$lang->sqlreview->report->charts['sqlreviewsPerSource']         = '需求来源统计';
$lang->sqlreview->report->charts['sqlreviewsPerPlan']           = '计划进行统计';
$lang->sqlreview->report->charts['sqlreviewsPerStatus']         = '状态进行统计';
$lang->sqlreview->report->charts['sqlreviewsPerStage']          = '所处阶段进行统计';
$lang->sqlreview->report->charts['sqlreviewsPerPri']            = '优先级进行统计';
$lang->sqlreview->report->charts['sqlreviewsPerEstimate']       = '预计工时进行统计';
$lang->sqlreview->report->charts['sqlreviewsPerOpenedBy']       = '由谁创建来进行统计';
$lang->sqlreview->report->charts['sqlreviewsPerAssignedTo']     = '当前指派来进行统计';
$lang->sqlreview->report->charts['sqlreviewsPerClosedReason']   = '关闭原因来进行统计';
$lang->sqlreview->report->charts['sqlreviewsPerChange']         = '变更次数来进行统计';

$lang->sqlreview->report->options->swf                     = 'pie2d';
$lang->sqlreview->report->options->width                   = 'auto';
$lang->sqlreview->report->options->height                  = 300;
$lang->sqlreview->report->options->graph->baseFontSize     = 12;
$lang->sqlreview->report->options->graph->showNames        = 1;
$lang->sqlreview->report->options->graph->formatNumber     = 1;
$lang->sqlreview->report->options->graph->decimalPrecision = 0;
$lang->sqlreview->report->options->graph->animation        = 0;
$lang->sqlreview->report->options->graph->rotateNames      = 0;
$lang->sqlreview->report->options->graph->yAxisName        = 'COUNT';
$lang->sqlreview->report->options->graph->pieRadius        = 100; // 饼图直径。
$lang->sqlreview->report->options->graph->showColumnShadow = 0;   // 是否显示柱状图阴影。

$lang->sqlreview->report->sqlreviewsPerProduct->graph->xAxisName      = '产品';
$lang->sqlreview->report->sqlreviewsPerModule->graph->xAxisName       = '模块';
$lang->sqlreview->report->sqlreviewsPerSource->graph->xAxisName       = '来源';
$lang->sqlreview->report->sqlreviewsPerPlan->graph->xAxisName         = '产品计划';
$lang->sqlreview->report->sqlreviewsPerStatus->graph->xAxisName       = '状态';
$lang->sqlreview->report->sqlreviewsPerStage->graph->xAxisName        = '所处阶段';
$lang->sqlreview->report->sqlreviewsPerPri->graph->xAxisName          = '优先级';
$lang->sqlreview->report->sqlreviewsPerOpenedBy->graph->xAxisName     = '由谁创建';
$lang->sqlreview->report->sqlreviewsPerAssignedTo->graph->xAxisName   = '当前指派';
$lang->sqlreview->report->sqlreviewsPerClosedReason->graph->xAxisName = '关闭原因';
$lang->sqlreview->report->sqlreviewsPerEstimate->graph->xAxisName     = '预计时间';
$lang->sqlreview->report->sqlreviewsPerChange->graph->xAxisName       = '变更次数';

$lang->sqlreview->placeholder->estimate = "完成该需求的工作量";
$lang->sqlreview->placeholder->mailto   = '输入用户名自动完成';
