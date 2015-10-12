<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>Initiazation</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

</head>
<body >
<p>今天是 <b style="color:#f00"><?=$project_info->name?></b> 第  <b style="color:#f00"><?=floor((strtotime(date("Y-m-d"))-strtotime($project_info->begin))/86400);?></b> 天，
    距离结束还有  <b style="color:#f00"><?=floor((strtotime($project_info->end)-strtotime(date("Y-m-d")))/86400);?> </b>天；</p>
<p>今天完成Task数量  <b style="color:#f00"><?=count($tasks_done_today)?></b>；今天增加Task数量  <b style="color:#f00"><?=count($tasks_opened_today)?></b>；
还剩未完成Task数量 <b style="color:#f00"> <?=count($tasks_un_finished)?></b>。</p>
<br/>
<p><b style="background-color: #A4BED4">今日禅道更新完成Task详情如下：</b></p>
<?php if($tasks_done_today){?>
<table style="border:1px #000 solid;width:765px;border-collapse:collapse;" cellpadding="0" cellspacing="0" border="1">
    <tr style="background: #f08300;color:#fff">
        <th style="width:73px">任务编号</th>
        <th style="width: 473px">任务名称</th>
        <th style="width:160px">完成时间</th>
        <th style="width:73px">由谁完成</th>
    </tr>
    <?php foreach($tasks_done_today as $v){?>
        <tr>
            <td style="width:73px"><?=$v->id?></td>
            <td  style="width: 473px"><?=$v->name?></td>
            <td style="width:160px"><?=$v->finishedDate?></td>
            <td style="width:73px"><?=$this->task->getRealNameByAccount($v->finishedBy)?></td>
        </tr>
    <?php }?>
</table>
<?php }else{?>
    <p><b style="background-color: #A4BED4">今天没有完成的Task列表</b></p>
<?php }?>
<br/>
<p><b style="background-color: #A4BED4">每日剩余Task：</b></p>
<p><img src="<?=$src_line;?>" /></p>
<br/>
<p><b style="background-color: #A4BED4">TEAM成员剩余Task：</b></p>
<p><img src="<?=$src_bar;?>" /></p>
</body>
</html>