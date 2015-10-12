<?php
/**
 * The task view file of dashboard module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dashboard
 * @version     $Id: task.html.php 3341 2012-07-14 07:26:53Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<script type="text/javascript">
    $(function(){
        $(".button-c").click(function(){
            var begin = $("#beginDate").val();
            var end = $("#endDate").val();
            var begin_next = $("#beginDate_next").val();
            var end_next = $("#endDate_next").val();
            var show = $(this).parent().attr("title");

            if(show){
                link = createLink('my', 'birth', 'begin=' + begin + '&end=' + end + '&begin_next=' + begin_next + '&end_next=' + end_next + '&show=1');
            }
            else{
                link = createLink('my', 'birth', 'begin=' + begin + '&end=' + end + '&begin_next=' + begin_next + '&end_next=' + end_next);
            }
            window.open(link,"_blank")
        })
    })

</script>



    <table align='center' class='table-1 a-left'>
        <caption>请选择本周周报起始时间</caption>
        <tr>
            <th class='rowhead'>开始时间：</th>
            <td><?php echo html::input('beginDate', $begin, "class='text-3 date'");?></td>
        </tr>

        <tr>
            <th class='rowhead'>结束时间：</th>
            <td><?php echo html::input('endDate', $end, "class='text-3 date'");?></td>
        </tr>
    </table>
<table align='center' class='table-1 a-left'>
    <caption>请选择下周计划起始时间</caption>
    <tr>
        <th class='rowhead'>开始时间：</th>
        <td><?php echo html::input('beginDate_next', $begin_next, "class='text-3 date'");?></td>
    </tr>

    <tr>
        <th class='rowhead'>结束时间：</th>
        <td><?php echo html::input('endDate_next', $end_next, "class='text-3 date'");?></td>
    </tr>

</table>
<table align='center' class='table-1 a-left'>
    <tr>
        <td colspan='2' class='a-center'><?php echo html::commonButton("生成");?></td>
        <td colspan='2' class='a-center' title="show"><?php echo html::commonButton("只显示");?></td>
    </tr>
</table>
    <?php include '../../common/view/footer.html.php';?>
