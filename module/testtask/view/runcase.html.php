<?php
/**
 * The runrun view file of testtask of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     testtask
 * @version     $Id: runcase.html.php 2605 2012-02-21 07:22:58Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<form method='post'>
  <table class='table-1'>
    <caption class='caption-tl'>CASE#<?php echo $run->case->id. $lang->colon . $run->case->title;?></caption>
    <tr>
      <td colspan='5'><h5><?php echo $lang->testcase->precondition;?></h5><?php echo $run->case->precondition;?></td>
    </tr>
    <tr class='colhead'>
      <th class='w-30px'><?php echo $lang->testcase->stepID;?></th>
      <th class='w-p40'><?php  echo $lang->testcase->stepDesc;?></th>
      <th class='w-p20'><?php  echo $lang->testcase->stepExpect;?></th>
      <th class='w-100px'><?php echo $lang->testcase->result;?></th>
      <th><?php echo $lang->testcase->real;?></th>
    </tr>
    <?php foreach($run->case->steps as $key => $step):?>
    <?php $defaultResult = $step->expect ? 'pass' : 'n/a';?>
    <tr>
      <th><?php echo $key + 1;?></th>
      <td><?php echo nl2br($step->desc);?></td>
      <td><?php echo nl2br($step->expect);?></td>
      <td class='a-center'><?php echo html::select("steps[$step->id]", $lang->testcase->resultList, $defaultResult);?></td>
      <td><?php echo html::textarea("reals[$step->id]", '', "rows=3 class='area-1'");?></td>
    </tr>
    <?php endforeach;?>
    <tr class='a-center'>
      <td colspan='5'>
        <?php
        if(empty($run->case->steps))
        {
            echo html::submitButton($lang->testtask->pass, "onclick=$('#result').val('pass')");
            echo html::submitButton($lang->testtask->fail, "onclick=$('#result').val('fail')");
        }
        else
        {
            echo html::submitButton();
            echo html::submitButton($lang->testtask->passAll, "onclick=$('#passall').val(1)");
        }
        echo html::hidden('case',    $run->case->id);
        echo html::hidden('version', $run->case->version);
        if($run->case->steps)  echo html::hidden('passall', 0);
        if(!$run->case->steps) echo html::hidden('result', '');
        ?>
      </td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.lite.html.php';?>
