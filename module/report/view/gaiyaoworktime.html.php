<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<table class="cont-lt1">
    <tr valign='top'>
        <td class='divider'>
        </td>
        <td>
            <div class="choose-date mb-10px f-left">
                <?php echo html::input('date', $begin, "class='select-7 date' onchange='changeDate(this.value, \"$end\")'") . "<span> {$lang->report->to} </span>" . html::input('date', $end, "class='select-7 date' onchange='changeDate(\"$begin\", this.value)'");?>
                <?php echo html::select('project',$projects,$project,"onchange='changeDate(\"$begin\",\"$end\",this.value)'"); ?>
            </div>
            <div class="choose-date mb-10px f-left">
                统计月份：<?php echo $month;?>
            </div>
            <table class='table-1 fixed colored tablesorter datatable border-sep'>
                <thead>

                <tr class='colhead'>
                    <th style="width: 50px">姓名</th>
                    <?php foreach($daysarray as $day):?>
                    <th><?php echo $day;?></th>
                    <?php endforeach;?>
                </tr>
                </thead>

                <tbody>

                <?php foreach($newlist as  $user=>$timelist):?>
                    <tr class="a-center" >
                        <td>
                            <?php
                            $users=$this->loadModel('user')->getById($user);
                            echo html::a('index.php?m=report&f=UserWorktime&u='.$user,$users->realname?$users->realname:$user);
                            ?>
                        </td>
                        <?php foreach($timelist as  $day=>$worktime):?>
                        <td  <?php if($worktime=="双休") { ?> style="background-color:#009900; " <?php } ?>
                             <?php if($worktime=="假日") { ?> style="background-color:#0092ef; " <?php } ?>
                             <?php if($worktime=="缺岗") { ?> style="background-color:#ffcc00; " <?php } ?>>
                            <?php
                            echo $worktime;?>
                        </td>
                        <?php endforeach;?>
                    </tr>
                <?php endforeach;?>
                </tbody>


            </table>
        </td>
    </tr>
</table>

<?php include '../../common/view/footer.html.php';?>
