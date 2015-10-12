<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<table class="cont-lt1">
    <tr valign='top'>
        <td class='side'>
            <?php include 'blockreportlist.html.php';?>
        </td>
        <td class='divider'></td>
        <td>
            <div class="choose-date mb-10px f-left">

                <?php echo html::input('date', $begin, "class='select-7 date' onchange='changeDate(this.value, \"$end\")'") . "<span> {$lang->report->to} </span>" . html::input('date', $end, "class='select-7 date' onchange='changeDate(\"$begin\", this.value)'");?>
                <?php echo html::select('project',$projects,$project,"onchange='changeDate(\"$begin\",\"$end\",this.value)'"); ?>
            </div>
            <table class='table-1 fixed colored tablesorter datatable border-sep'>
                <thead>
                <tr class='colhead'>
                    <th>需求ID</th>
                    <th>需求名称</th>
                    <th>项目id</th>
                    <th>项目名称</th>
                    <th>产品负责人</th>
                    <th>项目负责人</th>
                    <th>测试负责人</th>
                    <th>指派给</th>
                    <th>阶段</th>
                    <th>当前阶段</th>
                    <th>状态</th>
                    <th>当前状态</th>
                    <th>期望上线日期</th>
                    <th>延期天数</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($delayStory as $delay):?>
                    <?php
                    $this->loadModel('task');
                    $storyLink      = $this->createLink('story', 'view', "storyID=$delay->story");
                    ?>
                    <tr class="a-center">
                        <td><?php echo $delay->story;?></td>
                        <td><?php echo html::a($storyLink,$delay->storyTitle,"_blank","title=".$delay->storyTitle);?></td>
                        <td><?php echo $delay->project;?></td>
                        <td><?php echo $delay->projectName;?></td>
                        <td><?php echo $this->task->getRealNameByAccount($delay->PO);?></td>
                        <td><?php echo $this->task->getRealNameByAccount($delay->PM);?></td>
                        <td><?php echo $this->task->getRealNameByAccount($delay->QM);?></td>
                        <td><?php echo $this->task->getRealNameByAccount($delay->assignedTo);?></td>
                        <td><?php echo $lang->story->stageList[$delay->stage];?></td>
                        <td><?php echo $lang->story->stageList[$delay->current_stage];?></td>
                        <td><?php echo $lang->story->statusList[$delay->status];?></td>
                        <td><?php echo $lang->story->statusList[$delay->current_status];?></td>
                        <td><?php echo $delay->delayDate;?></td>
                        <td><?php echo $delay->delayDays;?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </td>
    </tr>
</table>

<script>
    $(function () {
        $('#container').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: '项目 延期需求展示图'
            },
            subtitle: {
                text: 'Source: tonglukuaijian.com'
            },
            xAxis: {
                categories: <?=json_encode($charData['category'])?>
            },
            yAxis: {
                title: {
                    text: '延期需求数（个）'
                }
            },
            tooltip: {
                enabled: false,
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y +'°C';
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series:<?=json_encode($charData['series'])?>
        });

        $('#container_2').highcharts({
            chart: {
                type: 'column',
                margin: [ 50, 50, 100, 80]
            },
            title: {
                text: '责任人 延期需求展示图'
            },
            xAxis: {
                categories: <?=json_encode($charData['category_2'])?>,
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '延期需求数（个）'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '延期需求数： <b>{point.y:.0f} 个</b>'
            },
            series: [{
                name: 'Population',
                data: <?=json_encode($charData['series_2'])?>,
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    x: 4,
                    y: 10,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px black'
                    }
                }
            }]
        });

    });
</script>
<div id="container" style="min-width:700px;height:400px"></div>
<br/><br/><br/><br/><br/><br/>
<div id="container_2" style="min-width:700px;height:400px"></div>
<?php include '../../common/view/footer.html.php';?>
