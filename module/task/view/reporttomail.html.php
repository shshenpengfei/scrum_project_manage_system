<?php
/**
 * The create view of task module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     task
 * @version     $Id: create.html.php 3333 2012-07-09 01:35:36Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/autocomplete.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<script> var holders = <?php echo json_encode($lang->task->placeholder);?></script>
<script language='javascript'> var userList = "<?php echo join(',', array_keys($users));?>".split(',');</script>
<script language='Javascript'>
    $(document).ready(function()
    {
        $("#mailto").autocomplete(userList, { multiple: true, mustMatch: true});
    });
</script>
<form method='post' enctype='multipart/form-data' target='hiddenwin' id='dataform'>
    <table align='center' class='table-1 a-left'>
        <tr>
            <th class='rowhead'>发送给</th>
            <td><?php echo html::checkbox('assignedTo', $members, implode(",",array_keys($members)));?></td>
        </tr>

        <tr>
            <th class='rowhead'><?php echo $lang->task->mailto;?></th>
            <td> <?php echo html::input('mailto', '', 'class=text-1');?> </td>
        </tr>

        <tr>
            <th class='rowhead'>报表内容</th>
            <td><?php echo $mailContent;?></td>
        </tr>
        <tr>
            <td colspan='2' class='a-center'><input type="submit" id="submit" value="发送" class="button-s"></td>
        </tr>
    </table>
</form>
<?php include '../../common/view/footer.html.php';?>
