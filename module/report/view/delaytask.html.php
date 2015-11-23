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


        /**
         * Dark blue theme for Highcharts JS
         * @author Torstein Honsi
         */

        Highcharts.theme = {
            colors: ["#DDDF0D", "#55BF3B", "#DF5353", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
                "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
            chart: {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
                    stops: [
                        [0, 'rgb(48, 48, 96)'],
                        [1, 'rgb(0, 0, 0)']
                    ]
                },
                borderColor: '#000000',
                borderWidth: 2,
                className: 'dark-container',
                plotBackgroundColor: 'rgba(255, 255, 255, .1)',
                plotBorderColor: '#CCCCCC',
                plotBorderWidth: 1
            },
            title: {
                style: {
                    color: '#C0C0C0',
                    font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
                }
            },
            subtitle: {
                style: {
                    color: '#666666',
                    font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
                }
            },
            xAxis: {
                gridLineColor: '#333333',
                gridLineWidth: 1,
                labels: {
                    style: {
                        color: '#A0A0A0'
                    }
                },
                lineColor: '#A0A0A0',
                tickColor: '#A0A0A0',
                title: {
                    style: {
                        color: '#CCC',
                        fontWeight: 'bold',
                        fontSize: '12px',
                        fontFamily: 'Trebuchet MS, Verdana, sans-serif'

                    }
                }
            },
            yAxis: {
                gridLineColor: '#333333',
                labels: {
                    style: {
                        color: '#A0A0A0'
                    }
                },
                lineColor: '#A0A0A0',
                minorTickInterval: null,
                tickColor: '#A0A0A0',
                tickWidth: 1,
                title: {
                    style: {
                        color: '#CCC',
                        fontWeight: 'bold',
                        fontSize: '12px',
                        fontFamily: 'Trebuchet MS, Verdana, sans-serif'
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.75)',
                style: {
                    color: '#F0F0F0'
                }
            },
            toolbar: {
                itemStyle: {
                    color: 'silver'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        color: '#CCC'
                    },
                    marker: {
                        lineColor: '#333'
                    }
                },
                spline: {
                    marker: {
                        lineColor: '#333'
                    }
                },
                scatter: {
                    marker: {
                        lineColor: '#333'
                    }
                },
                candlestick: {
                    lineColor: 'white'
                }
            },
            legend: {
                itemStyle: {
                    font: '9pt Trebuchet MS, Verdana, sans-serif',
                    color: '#A0A0A0'
                },
                itemHoverStyle: {
                    color: '#FFF'
                },
                itemHiddenStyle: {
                    color: '#444'
                }
            },
            credits: {
                style: {
                    color: '#666'
                }
            },
            labels: {
                style: {
                    color: '#CCC'
                }
            },

            navigation: {
                buttonOptions: {
                    symbolStroke: '#DDDDDD',
                    hoverSymbolStroke: '#FFFFFF',
                    theme: {
                        fill: {
                            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                            stops: [
                                [0.4, '#606060'],
                                [0.6, '#333333']
                            ]
                        },
                        stroke: '#000000'
                    }
                }
            },

            // scroll charts
            rangeSelector: {
                buttonTheme: {
                    fill: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0.4, '#888'],
                            [0.6, '#555']
                        ]
                    },
                    stroke: '#000000',
                    style: {
                        color: '#CCC',
                        fontWeight: 'bold'
                    },
                    states: {
                        hover: {
                            fill: {
                                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                stops: [
                                    [0.4, '#BBB'],
                                    [0.6, '#888']
                                ]
                            },
                            stroke: '#000000',
                            style: {
                                color: 'white'
                            }
                        },
                        select: {
                            fill: {
                                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                stops: [
                                    [0.1, '#000'],
                                    [0.3, '#333']
                                ]
                            },
                            stroke: '#000000',
                            style: {
                                color: 'yellow'
                            }
                        }
                    }
                },
                inputStyle: {
                    backgroundColor: '#333',
                    color: 'silver'
                },
                labelStyle: {
                    color: 'silver'
                }
            },

            navigator: {
                handles: {
                    backgroundColor: '#666',
                    borderColor: '#AAA'
                },
                outlineColor: '#CCC',
                maskFill: 'rgba(16, 16, 16, 0.5)',
                series: {
                    color: '#7798BF',
                    lineColor: '#A6C7ED'
                }
            },

            scrollbar: {
                barBackgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0.4, '#888'],
                        [0.6, '#555']
                    ]
                },
                barBorderColor: '#CCC',
                buttonArrowColor: '#CCC',
                buttonBackgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0.4, '#888'],
                        [0.6, '#555']
                    ]
                },
                buttonBorderColor: '#CCC',
                rifleColor: '#FFF',
                trackBackgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#000'],
                        [1, '#333']
                    ]
                },
                trackBorderColor: '#666'
            },

            // special colors for some of the
            legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
            background2: 'rgb(35, 35, 70)',
            dataLabelsColor: '#444',
            textColor: '#C0C0C0',
            maskColor: 'rgba(255,255,255,0.3)'
        };

// Apply the theme
        var highchartsOptions = Highcharts.setOptions(Highcharts.theme);


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
