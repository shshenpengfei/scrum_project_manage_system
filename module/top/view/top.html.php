<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<table class="cont-lt1">
    <tr valign='top'>
        <td>
            <div class="choose-date mb-10px f-left">
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
                    <th>IP</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($userlist as $item):?>

                    <tr class="a-center" >
                        <td>
                        </td>

                        <td>
                            <?php
                            $dept=$this->loadModel('dept')->getById($item->dept);
                            echo $dept->name;
                            ?>
                        </td>

                        <td>
                            <?php
                                echo $item->realname;
                            ?>
                        </td>



                        <td>
                        </td>

                        <td>
                        </td>

                        <td>
                        </td>

                        <td >
                        </td>

                        <td>
                        </td>
                    </tr>

                <?php endforeach;?>
                </tbody>
            </table>
        </td>
    </tr>
</table>

<?php include '../../common/view/footer.html.php';?>
