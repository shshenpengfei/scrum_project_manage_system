<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/colorize.html.php';?>
<table class="cont-lt1">
  <tr valign='top'>
    <td class='side' style="display:none">
      <?php include 'blockreportlist.html.php';?>
      <div class='proversion'><?php echo $lang->report->proVersion;?></div>
    </td>
    <td class='divider'  style="display:none"></td>
    <td>
      <table class='table-1 fixed colored tablesorter datatable border-sep'>
        <thead>
        <tr class='colhead'>
          <th class='w-id'><?php echo $lang->report->id;?></th>
          <th class="w-200px"><?php echo $lang->report->project;?></th>
          <th>状态</th>
          <th>启动时间</th>
          <th>结束时间</th>

          <th>团队人数</th>
          <th><?php echo $lang->report->task;?></th>
          <th><?php echo $lang->report->stories;?></th>
          <th><?php echo $lang->report->bugs;?></th>
          <th><?php echo $lang->report->devConsumed;?></th>
          <th><?php echo $lang->report->testConsumed;?></th>
          <th><?php echo $lang->report->devTestRate;?></th>
          <th><?php echo $lang->report->estimate;?></th>
          <th><?php echo $lang->report->consumed;?></th>
          <th  style="display:none"><?php echo $lang->report->deviation;?></th>
          <th style="display:none"><?php echo $lang->report->deviationRate;?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($projects as $id  =>$project):?>
          <tr class="a-center">
            <td><?php echo $id;?></td>
            <td align="left"><?php echo $project->name;?></td>
            <td><?php echo $lang->project->statusList[$project->status];?></td>
            <td><?php echo $project->begin;?></td>
            <td><?php echo $project->end;?></td>
            <td><?php echo $project->teamMember;?></td>
            <td><?php echo isset($project->tasks) ? $project->tasks : 0;?></td>
            <td><?php echo isset($project->stories) ? $project->stories : 0;?></td>
            <td><?php echo isset($project->bugs) ? $project->bugs : 0;?></td>
            <?php
                $project->devConsumed  = isset($project->devConsumed) ? $project->devConsumed : 0;
                $project->testConsumed = isset($project->testConsumed) ? $project->testConsumed : 0;
                $project->estimate     = isset($project->estimate) ? $project->estimate : 0;
                $project->consumed     = isset($project->consumed) ? $project->consumed : 0;
            ?>
            <td><?php echo $project->devConsumed;?></td>
            <td><?php echo $project->testConsumed;?></td>
            <td><?php echo round($project->devConsumed / (($project->testConsumed < 1) ? 1 : $project->testConsumed), 1);?></td>
            <td><?php echo $project->estimate;?></td>
            <td><?php echo $project->consumed;?></td>
            <?php $deviation = $project->consumed - $project->estimate;?>
            <td  style="display:none"><?php echo $deviation > 0 ? ('+' . $deviation) : ($deviation);?></td>
            <td  style="display:none">
              <?php
                if($project->estimate)
                {
                    echo $deviation > 0 ? ('+' . round($deviation / $project->estimate * 100, 2)) . '%' : round($deviation / $project->estimate * 100, 2) . '%';
                }
                else
                {
                    echo '0%';
                }
              ?>
            </td>
          </tr>
        <?php endforeach;?>
        </tbody>
      </table>
    </td>
  </tr>
</table>
<script>

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

    $(function () {
        $('#container').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: '项目总控图'
            },
            subtitle: {
                text: '我查查移动研发中心'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                }
            },
            yAxis: {
                title: {
                    text: '工作量 (小时)'
                },
                min: 0
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br>'+
                    Highcharts.dateFormat('%e. %b', this.x) +': '+ this.y +' m';
                }
            },

            series: [{
                name: 'Winter 2007-2008',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
                    [Date.UTC(1970,  9, 27), 0   ],
                    [Date.UTC(1970, 10, 10), 0.6 ],
                    [Date.UTC(1970, 10, 18), 0.7 ],
                    [Date.UTC(1970, 11,  2), 0.8 ],
                    [Date.UTC(1970, 11,  9), 0.6 ],
                    [Date.UTC(1970, 11, 16), 0.6 ],
                    [Date.UTC(1970, 11, 28), 0.67],
                    [Date.UTC(1971,  0,  1), 0.81],
                    [Date.UTC(1971,  0,  8), 0.78],
                    [Date.UTC(1971,  0, 12), 0.98],
                    [Date.UTC(1971,  0, 27), 1.84],
                    [Date.UTC(1971,  1, 10), 1.80],
                    [Date.UTC(1971,  1, 18), 1.80],
                    [Date.UTC(1971,  1, 24), 1.92],
                    [Date.UTC(1971,  2,  4), 2.49],
                    [Date.UTC(1971,  2, 11), 2.79],
                    [Date.UTC(1971,  2, 15), 2.73],
                    [Date.UTC(1971,  2, 25), 2.61],
                    [Date.UTC(1971,  3,  2), 2.76],
                    [Date.UTC(1971,  3,  6), 2.82],
                    [Date.UTC(1971,  3, 13), 2.8 ],
                    [Date.UTC(1971,  4,  3), 2.1 ],
                    [Date.UTC(1971,  4, 26), 1.1 ],
                    [Date.UTC(1971,  5,  9), 0.25],
                    [Date.UTC(1971,  5, 12), 0   ]
                ]
            }, {
                name: 'Winter 2008-2009',
                data: [
                    [Date.UTC(1970,  9, 18), 0   ],
                    [Date.UTC(1970,  9, 26), 0.2 ],
                    [Date.UTC(1970, 11,  1), 0.47],
                    [Date.UTC(1970, 11, 11), 0.55],
                    [Date.UTC(1970, 11, 25), 1.38],
                    [Date.UTC(1971,  0,  8), 1.38],
                    [Date.UTC(1971,  0, 15), 1.38],
                    [Date.UTC(1971,  1,  1), 1.38],
                    [Date.UTC(1971,  1,  8), 1.48],
                    [Date.UTC(1971,  1, 21), 1.5 ],
                    [Date.UTC(1971,  2, 12), 1.89],
                    [Date.UTC(1971,  2, 25), 2.0 ],
                    [Date.UTC(1971,  3,  4), 1.94],
                    [Date.UTC(1971,  3,  9), 1.91],
                    [Date.UTC(1971,  3, 13), 1.75],
                    [Date.UTC(1971,  3, 19), 1.6 ],
                    [Date.UTC(1971,  4, 25), 0.6 ],
                    [Date.UTC(1971,  4, 31), 0.35],
                    [Date.UTC(1971,  5,  7), 0   ]
                ]
            }, {
                name: 'Winter 2009-2010',
                data: [
                    [Date.UTC(1970,  9,  9), 0   ],
                    [Date.UTC(1970,  9, 14), 0.15],
                    [Date.UTC(1970, 10, 28), 0.35],
                    [Date.UTC(1970, 11, 12), 0.46],
                    [Date.UTC(1971,  0,  1), 0.59],
                    [Date.UTC(1971,  0, 24), 0.58],
                    [Date.UTC(1971,  1,  1), 0.62],
                    [Date.UTC(1971,  1,  7), 0.65],
                    [Date.UTC(1971,  1, 23), 0.77],
                    [Date.UTC(1971,  2,  8), 0.77],
                    [Date.UTC(1971,  2, 14), 0.79],
                    [Date.UTC(1971,  2, 24), 0.86],
                    [Date.UTC(1971,  3,  4), 0.8 ],
                    [Date.UTC(1971,  3, 18), 0.94],
                    [Date.UTC(1971,  3, 24), 0.9 ],
                    [Date.UTC(1971,  4, 16), 0.39],
                    [Date.UTC(1971,  4, 21), 0   ]
                ]
            }]
        });
    });
</script>
<div id="container" style="min-width:700px;height:400px"></div>

<?php include '../../common/view/footer.html.php';?>
