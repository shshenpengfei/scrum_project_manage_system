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
                    <th>任务ID</th>
                    <th>任务名称</th>
                    <th>需求ID</th>
                    <th>需求名称</th>
                    <th>项目id</th>
                    <th>项目名称</th>
                    <th>指派给</th>
                    <th>状态</th>
                    <th>当前状态</th>
                    <th>截止日期</th>
                    <th>延期天数</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($delayTask as $delay):?>
                    <?php
                    $this->loadModel('task');
                    $taskLink      = $this->createLink('task', 'view', "task=$delay->task");
                    $storyLink      = $this->createLink('story', 'view', "storyID=$delay->story");
                    ?>
                    <tr class="a-center"
                        <?php if($delay->current_deleted ==1){
                        ?>
                        style="text-decoration:line-through;color: #949494"
                        <?php } ?>
                        >
                        <td><?php echo $delay->task;?></td>
                        <td><?php echo html::a($taskLink,$delay->taskName,"_blank","title=".$delay->taskName);?></td>
                        <td><?php echo $delay->story;?></td>
                        <td><?php echo html::a($storyLink,$delay->storyTitle,"_blank","title=".$delay->storyTitle);?></td>
                        <td><?php echo $delay->project;?></td>
                        <td><?php echo $delay->projectName;?></td>
                        <td><?php echo $this->task->getRealNameByAccount($delay->assignedTo);?></td>
                        <td><?php echo $lang->task->statusList[$delay->status];?></td>
                        <td>
                            <?php echo $lang->task->statusList[$delay->current_status];?>
                        </td>
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
                text: '项目 任务延期展示图'
            },
            subtitle: {
                text: 'Source: wochacha.cn'
            },
            xAxis: {
                categories: <?=json_encode($charData['category'])?>
            },
            yAxis: {
                title: {
                    text: '延期任务数（个）'
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

        $('#container_1').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: '责任人-日期 延期任务展示图'
            },
            xAxis: {
                categories: <?=json_encode($charData['category'])?>
            },
            yAxis: {
                min: 0,
                title: {
                    text: '延期任务数（个）'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: -70,
                verticalAlign: 'top',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        'Total: '+ this.point.stackTotal;
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            series: <?=json_encode($charData['series_1'])?>
        });

        $('#container_2').highcharts({
            chart: {
                type: 'column',
                margin: [ 50, 50, 100, 80]
            },
            title: {
                text: '责任人 延期任务展示图'
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
                    text: '延期任务数（个）'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '延期任务数： <b>{point.y:.0f} 个</b>'
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

    $(function () {
        $("text").each(function(){
            if($(this).text()=="0"){
                $(this).text("")
            }
        })
    });
</script>
<div id="container" style="min-width:700px;height:400px"></div>
<br/><br/><br/><br/><br/><br/>
<div id="container_1" style="min-width:700px;height:400px"></div>
<br/><br/><br/><br/><br/><br/>
<div id="container_2" style="min-width:700px;height:400px"></div>
<?php include '../../common/view/footer.html.php';?>
