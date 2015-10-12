<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>Initiazation</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body >
<p style="color: #3668d9;font-size: 30px;text-align: center;">推广中心<b style="color: #ff3600"><?=$user_info->realname;?></b>
    <?=$user_info->position == 'leader' ? '组' : '';?><?=$begin?>至<?=$end?>周报</p>
<br/>
<p><b style="background-color: #A4BED4">本周<b style="color: #ff3600">已完成TASK</b>详情如下：</b></p>
<table style="border:1px #000 solid;border-collapse:collapse;" cellpadding="0" cellspacing="0" border="1">
    <tr style="background: #f08300;color:#fff">
        <th>产品线</th>
        <th>项目</th>
        <th>任务编号</th>
        <th><p style="width: 250px;">任务名称</p></th>
        <th>状态</th>
        <th>计划用时</th>
        <th>实际用时</th>
        <th>完成时间</th>
        <th>由谁完成</th>
        <th>所在小组</th>
    </tr>
    <?php foreach($tasks_me as $v){?>
        <tr>
            <td><?=$v->productName?></td>
            <td><?=$v->projectName?></td>
            <td><?=$v->id?></td>
            <td><p style="width: 250px;"><?=$v->name?></p></td>
            <td><?=$lang->task->statusList[$v->status]?></td>
            <td><?=$v->estimate?></td>
            <td><?=$v->consumed?></td>
            <td><?=$v->finishedDate?></td>
            <td><?=$user_info->realname?></td>
            <td><?=$this->task->getDeptByAccount($user_info->account)?></td>
        </tr>
    <?php }?>
    <?php foreach($tasks_guys as $tg){?>
    <?php foreach($tg as $t){?>
        <tr>
            <td><?=$t->productName?></td>
            <td><?=$t->projectName?></td>
            <td><?=$t->id?></td>
            <td><p style="width: 250px;"><?=$t->name?></p></td>
            <td><?=$lang->task->statusList[$t->status]?></td>
            <td><?=$t->estimate?></td>
            <td><?=$t->consumed?></td>
            <td><?=$t->finishedDate?></td>
            <td><?=$this->task->getRealNameByAccount($t->finishedBy)?></td>
            <td><?=$this->task->getDeptByAccount($t->finishedBy)?></td>
        </tr>
        <?php }?>
    <?php }?>
</table>
<br/>
<p><b style="background-color: #A4BED4">本周<b style="color: #ff3600">未完成TASK</b>详情如下：</b></p>
<table style="border:1px #000 solid;border-collapse:collapse;" cellpadding="0" cellspacing="0" border="1">
    <tr style="background: #f08300;color:#fff">
        <th>产品线</th>
        <th>项目</th>
        <th>任务编号</th>
        <th><p style="width: 250px;">任务名称</p></th>
        <th>状态</th>
        <th>计划用时</th>
        <th>实际用时</th>
        <th>截止日期</th>
        <th>指派给谁</th>
        <th>所在小组</th>
    </tr>
    <?php foreach($tasks_undone_me as $v){?>
        <tr>
            <td><?=$v->productName?></td>
            <td><?=$v->projectName?></td>
            <td><?=$v->id?></td>
            <td><p style="width: 250px;"><?=$v->name?></p></td>
            <td><?=$lang->task->statusList[$v->status]?></td>
            <td><?=$v->estimate?></td>
            <td><?=$v->consumed?></td>
            <td><?=$v->deadline?></td>
            <td><?=$user_info->realname?></td>
            <td><?=$this->task->getDeptByAccount($user_info->account)?></td>
        </tr>
    <?php }?>
    <?php foreach($tasks_undone_guys as $ug){?>
        <?php foreach($ug as $u){?>
            <tr>
                <td  style="width: 473px"><?=$u->productName?></td>
                <td  style="width: 473px"><?=$u->projectName?></td>
                <td style="width:73px"><?=$u->id?></td>
                <td  style="width: 473px"><p style="width: 250px;"><?=$u->name?></p></td>
                <td  style="width: 73px"><?=$lang->task->statusList[$u->status]?></td>
                <td style="width:160px"><?=$u->estimate?></td>
                <td style="width:160px"><?=$u->consumed?></td>
                <td style="width:160px"><?=$u->deadline?></td>
                <td style="width:73px"><?=$this->task->getRealNameByAccount($u->assignedTo)?></td>
                <td style="width:73px"><?=$this->task->getDeptByAccount($u->assignedTo)?></td>
            </tr>
        <?php }?>
    <?php }?>
</table>
<br/>
<p><b style="background-color: #A4BED4">本周<b style="color: #ff3600">解决并关闭的BUG</b>详情如下：</b></p>
<table style="border:1px #000 solid;border-collapse:collapse;" cellpadding="0" cellspacing="0" border="1">
    <tr style="background: #f08300;color:#fff">
        <th>产品线</th>
        <th>项目</th>
        <th>BUG编号</th>
        <th><p style="width: 250px;">BUG名称</p></th>
        <th>状态</th>
        <th>关闭时间</th>
        <th>由谁解决</th>
        <th>所在小组</th>
    </tr>
    <?php foreach($bugs_me as $v){?>
        <tr>
            <td><?=$v->productName?></td>
            <td><?=$v->projectName?></td>
            <td><?=$v->id?></td>
            <td><p style="width: 250px;"><?=$v->title?></p></td>
            <td><?=$lang->bug->statusList[$v->status]?></td>
            <td><?=$v->closedDate?></td>
            <td><?=$user_info->realname?></td>
            <td><?=$this->task->getDeptByAccount($user_info->account)?></td>
        </tr>
    <?php }?>
    <?php foreach($bugs_guys as $bg){?>
    <?php foreach($bg as $b){?>
        <tr>
            <td><?=$b->productName?></td>
            <td><?=$b->projectName?></td>
            <td><?=$b->id?></td>
            <td><p style="width: 250px;"><?=$b->title?></p></td>
            <td><?=$lang->bug->statusList[$b->status]?></td>
            <td><?=$b->closedDate?></td>
            <td><?=$this->task->getRealNameByAccount($b->resolvedBy)?></td>
            <td><?=$this->task->getDeptByAccount($b->resolvedBy)?></td>
        </tr>
        <?php }?>
    <?php }?>
</table>
<br/>
<p><b style="background-color: #A4BED4">本周<b style="color: #ff3600">未关闭的BUG</b>详情如下：</b></p>
<table style="border:1px #000 solid;border-collapse:collapse;" cellpadding="0" cellspacing="0" border="1">
    <tr style="background: #f08300;color:#fff">
        <th>产品线</th>
        <th>项目</th>
        <th>BUG编号</th>
        <th><p style="width: 250px;">BUG名称</p></th>
        <th>状态</th>
        <th>说明</th>
        <th>提出时间</th>
        <th>由谁解决</th>
        <th>所在小组</th>
    </tr>
    <?php foreach($bugs_undone_me as $v){?>
        <tr>
            <td><?=$v->productName?></td>
            <td><?=$v->projectName?></td>
            <td><?=$v->id?></td>
            <td><p style="width: 250px;"><?=$v->title?></p></td>
            <td><?=$lang->bug->statusList[$v->status]?></td>
            <td><?=$v->status == 'resolved' ? $lang->bug->resolutionList[$v->resolution] : $lang->bug->confirmedList[$v->confirmed]?></td>
            <td><?=$v->assignedDate?></td>
            <td><?=$user_info->realname?></td>
            <td><?=$this->task->getDeptByAccount($user_info->account)?></td>
        </tr>
    <?php }?>
    <?php foreach($bugs_undone_guys as $ubg){?>
        <?php foreach($ubg as $ub){?>
            <tr>
                <td><?=$ub->productName?></td>
                <td><?=$ub->projectName?></td>
                <td><?=$ub->id?></td>
                <td><p style="width: 250px;"><?=$ub->title?></p></td>
                <td><?=$lang->bug->statusList[$ub->status]?></td>
                <td><?=$ub->status == 'resolved' ? $lang->bug->resolutionList[$ub->resolution] : $lang->bug->confirmedList[$ub->confirmed]?></td>
                <td><?=$ub->assignedDate?></td>
                <td><?=$this->task->getRealNameByAccount($ub->assignedTo)?></td>
                <td><?=$this->task->getDeptByAccount($ub->assignedTo)?></td>
            </tr>
        <?php }?>
    <?php }?>
</table>
<br/>
<p><b style="background-color: #A4BED4">本周禅道更新<b style="color: #ff3600">TODO</b>详情如下：</b></p>
<table style="border:1px #000 solid;border-collapse:collapse;" cellpadding="0" cellspacing="0" border="1">
    <tr style="background: #f08300;color:#fff">
        <th>TODO编号</th>
        <th><p style="width: 250px;">TODO名称</p></th>
        <th>状态</th>
        <th>提出时间</th>
        <th>由谁提出</th>
        <th>所在小组</th>
    </tr>
    <?php foreach($todo_me as $v){?>
        <tr>
            <td><?=$v->id?></td>
            <td><p style="width: 250px;"><?=$v->name?></p></td>
            <td><?=$lang->todo->statusList[$v->status]?></td>
            <td><?=$v->date?></td>
            <td><?=$user_info->realname?></td>
            <td><?=$this->task->getDeptByAccount($user_info->account)?></td>
        </tr>
    <?php }?>
    <?php foreach($todo_guys as $dg){?>
    <?php foreach($dg as $d){?>
        <tr>
            <td><?=$d->id?></td>
            <td><p style="width: 250px;"><?=$d->name?></p></td>
            <td><?=$lang->todo->statusList[$d->status]?></td>
            <td><?=$d->date?></td>
            <td><?=$this->task->getRealNameByAccount($d->account)?></td>
            <td><?=$this->task->getDeptByAccount($d->account)?></td>
        </tr>
        <?php }?>
    <?php }?>
</table>
<br/>
<p><b style="background-color: #A4BED4"><b style="color: #ff3600">下周PLAN</b>详情如下：</b></p>
<table style="border:1px #000 solid;border-collapse:collapse;" cellpadding="0" cellspacing="0" border="1">
    <tr style="background: #f08300;color:#fff">
        <th>PLAN编号</th>
        <th><p style="width: 250px;">PLAN名称</p></th>
        <th>状态</th>
        <th>提出时间</th>
        <th>由谁提出</th>
        <th>所在小组</th>
    </tr>
    <?php foreach($plan_me as $v){?>
        <tr>
            <td><?=$v->id?></td>
            <td><p style="width: 250px;"><?=$v->name?></p></td>
            <td><?=$lang->todo->statusList[$v->status]?></td>
            <td><?=$v->date?></td>
            <td><?=$user_info->realname?></td>
            <td><?=$this->task->getDeptByAccount($user_info->account)?></td>
        </tr>
    <?php }?>
    <?php foreach($plan_guys as $pg){?>
        <?php foreach($pg as $p){?>
            <tr>
                <td><?=$p->id?></td>
                <td><p style="width: 250px;"><?=$p->name?></p></td>
                <td><?=$lang->todo->statusList[$p->status]?></td>
                <td><?=$p->date?></td>
                <td><?=$this->task->getRealNameByAccount($p->account)?></td>
                <td><?=$this->task->getDeptByAccount($p->account)?></td>
            </tr>
        <?php }?>
    <?php }?>
</table>
</body>
</html>