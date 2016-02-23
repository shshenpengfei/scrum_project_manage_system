<?php include '../../common/view/header.html.php';?>
<table class="cont-lt1">
  <tr valign='top'>
    <td>
      <table class='table-1 fixed colored tablesorter datatable border-sep' id="workload">
        <thead>
        <tr class='colhead'>
          <th><?php echo $lang->report->user;?></th>
          <th colspan="4"><?php echo $lang->report->task;?></th>
          <th colspan="3"><?php echo $lang->report->bug;?></th>
        </tr>
        </thead>
        <tbody>
          <tr class="a-center">
            <td></td>
            <td><?php echo $lang->report->project;?></td>
            <td><?php echo $lang->report->task;?></td>
            <td><?php echo $lang->report->remain;?></td>
            <td><?php echo $lang->report->total;?></td>
            <td><?php echo $lang->report->product;?></td>
            <td><?php echo $lang->report->bug;?></td>
            <td><?php echo $lang->report->total;?></td>
          </tr>
        <?php foreach($workload as $account => $load):?>
        <?php
        $i = 1;
        $taskNum = empty($load['task']) ? 0 : count($load['task']);
        $bugNum  = empty($load['bug'])  ? 0 : count($load['bug']);
        $max     = $taskNum >= $bugNum ? 'task' : 'bug';
        ?>
        <?php foreach($load[$max] as $key => $val):?>
          <tr class="a-center">
          <?php if($i == 1):?>
          <td rowspan="<?php echo count($load[$max]);?>"><?php echo $users[$account];?></td>
          <?php endif;?>
            <?php if($max == 'task'):?>
            <td><?php echo $key?></td>
            <td><?php echo $val['count']?></td>
            <td><?php echo $val['manhour']?></td>
            <?php if($i == 1):?>
            <td rowspan='<?php echo count($load[$max]);?>'>
            <?php
                $taskCount = isset($load['total']['task']['count']) ? $load['total']['task']['count'] : 0;
                $taskHour  = isset($load['total']['task']['manhour']) ? $load['total']['task']['manhour'] : 0;
                printf($lang->report->taskTotal, $taskCount, $taskHour);
            ?>
            </td>
            <?php endif;?>
            <td><?php echo $product = empty($load['bug']) ? '' : key($load['bug'])?></td>
            <td><?php echo empty($product) ? '' : $load['bug'][$product]['count']?></td>
            <?php if($i == 1):?>
            <td rowspan='<?php echo count($load[$max]);?>'>
            <?php
                $bugCount = isset($load['total']['bug']['count']) ? $load['total']['bug']['count'] : 0;
                printf($lang->report->bugTotal, $bugCount);
            ?>
            </td>
            <?php endif;?>
            <?php unset($load['bug'][$product]);?>
            <?php else:?>
            <td><?php echo $project = empty($load['task']) ? '' : key($load['task'])?></td>
            <td><?php echo empty($project) ? '' : $load['task'][$project]['count']?></td>
            <td><?php echo empty($project) ? '' : $load['task'][$project]['manhour']?></td>
            <?php if($i == 1):?>
            <td rowspan='<?php echo count($load[$max]);?>'>
            <?php
                $taskCount = isset($load['total']['task']['count']) ? $load['total']['task']['count'] : 0;
                $taskHour  = isset($load['total']['task']['manhour']) ? $load['total']['task']['manhour'] : 0;
                printf($lang->report->taskTotal, $taskCount, $taskHour);
            ?>
            </td>
            <?php endif;?>
            <td><?php echo $key?></td>
            <td><?php echo $val['count']?></td>
            <?php if($i == 1):?>
            <td rowspan='<?php echo count($load[$max]);?>'>
            <?php
                $bugCount = isset($load['total']['bug']['count']) ? $load['total']['bug']['count'] : 0;
                printf($lang->report->bugTotal, $bugCount);
            ?>
            </td>
            <?php endif;?>
            <?php unset($load['task'][$project]);?>
            <?php endif;?>
          </tr>
          <?php $i ++;?>
          <?php endforeach;?>
        <?php endforeach;?>
        </tbody>
      </table> 
    </td>
  </tr>
</table>
<?php include '../../common/view/footer.html.php';?>
