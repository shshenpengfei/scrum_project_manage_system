<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>

<div id="container" style="min-width:700px;height:400px"></div>

<table class="cont-lt1">
    <tr valign='top'>
        <td>
            <table class='table-1 fixed colored tablesorter datatable border-sep'>
                <thead>
                <tr class='colhead'>
                    <th>ID</th>
                    <th>姓名</th>
                    <th>工作日</th>
                    <th>开始工作时间</th>
                    <th>结束工作时间</th>
                    <th>工作时长</th>
                    <th>状态</th>
                    <th>IP</th>
                    <th>签出IP</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($worktimelist as $item):?>

                    <tr class="a-center" >
                        <td>
                            <?php
                            echo $item->pkid;;
                            ?>
                        </td>
                        <td>
                            <?php
                            $users=$this->loadModel('user')->getById($item->id);
                            //echo $users->realname;
                            echo html::a('http://www.pm-my.com/index.php?m=report&f=UserWorktime&u='.$item->id,$users->realname);
                            ?>
                        </td>
                        <td>
                            <?php echo $item->workday;?>
                        </td>
                        <td>
                            <?php echo date("Y-m-d H:i:s",$item->begintime);?>
                        </td>
                        <td  <?php if($item->status==2) { ?> style="background-color:#ffcc00; " <?php } ?> >
                            <?php echo $item->endtime == 0 ? "" : date("Y-m-d  H:i:s",$item->endtime);?>
                        </td>
                        <td>
                            <?php
                                    echo $item->worktime."小时";
                            ?>
                        </td>
                        <td  <?php if($item->status==2) { ?> style="background-color:#ffcc00; " <?php } ?> >
                            <?php echo html::statusName($item->status);?>
                        </td>
                        <td>
                            <?php echo $item->ip;?>
                        </td>
                        <td>
                            <?php echo $item->endip;?>
                        </td>
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
                text: '<?=$checkuserinfo->realname?>'+"工作情况分析"
            },
            subtitle: {
                text: '猫市技术产品部，平台技术部，产品研发部'
            },
            xAxis: {
                categories: <?=json_encode($UserDayData['workday'])?>
            },
            yAxis: {
                title: {
                    text: '工作评估'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
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
            series: [{
                name:"工作持续时间（小时）",
                data:<?=json_encode($UserDayData['sumtime'])?>
            }]
        });

    });
</script>


<?php include '../../common/view/footer.html.php';?>
