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
                    <th>用户ID</th>
                    <th>所在组</th>
                    <th>姓名</th>
                    <th>任务总数</th>
                    <th>事项总数</th>
                    <th>BUG总数</th>
                    <th>GIT COMMIT总数</th>
                    <th>代码reivew情况</th>
                    <th>总投入工时</th>
                    <th>总贡献值</th>

                </tr>
                </thead>
                <tbody>
                <?php foreach($userlist as $item):?>

                    <tr class="a-center" >
                        <td>
                            <?php
                                echo $item->id;
                            ?>
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
                            <?php
                                echo $item->tasknum;
                            ?>
                        </td>

                        <td>
                        </td>

                        <td>
                        </td>

                        <td >
                        </td>

                        <td>
                        </td>

                        <td>
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
