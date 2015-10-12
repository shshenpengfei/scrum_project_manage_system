<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<table class="cont-lt1">
    <tr valign='top'>
        <td>
            <div class="choose-date mb-10px f-left">
                <?php echo html::input('date', $begin, "class='select-7 date' onchange='changeDate(this.value, \"$end\")'") . "<span> {$lang->report->to} </span>" . html::input('date', $end, "class='select-7 date' onchange='changeDate(\"$begin\", this.value)'");?>
                <?php echo html::select('project',$projects,$project,"onchange='changeDate(\"$begin\",\"$end\",this.value)'"); ?>
            </div>
            <table class='table-1 fixed colored tablesorter datatable border-sep'>
                <thead>
                <tr class='colhead'>
                    <th>ID</th>
                    <th>所在组</th>
                    <th>姓名</th>
                    <th>开始工作时间</th>
                    <th>结束工作时间</th>
                    <th>工作时长</th>
                    <th>状态</th>
                    <th>签到IP</th>
                    <th>签离IP</th>
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
                            $dept=$this->loadModel('dept')->getById($users->dept);
                            echo $dept->name;
                            ?>
                        </td>
                        <td>
                            <?php

                            //echo $users->realname;

                            echo html::a('index.php?m=report&f=UserWorktime&u='.$item->id,$users->realname);
                            ?>
                        </td>
                        <td>
                            <?php echo date("Y-m-d H:i:s",$item->begintime);?>
                        </td>
                        <td  <?php if($item->status==2) { ?> style="background-color:#ffcc00; " <?php } ?> >
                            <?php echo $item->endtime == 0 ? "" : date("Y-m-d  H:i:s",$item->endtime);?>
                        </td>
                        <td>
                            <?php
                            if($item->endtime <> 0){
                                $lasttime=html::calculateWorktime($item->begintime,$item->endtime);
                                $hours=number_format($lasttime,1);
//                                $hours=number_format(($item->endtime-$item->begintime)/3600,1);
                                if($hours<1){
                                    $minute=number_format($hours*60,0);
                                    echo $minute."分钟";
                                }
                                else{
                                    echo $hours."小时";
                                }
                            }

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

<?php include '../../common/view/footer.html.php';?>
