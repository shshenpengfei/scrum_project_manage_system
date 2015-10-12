<?php
/**
 * The create view of story module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     story
 * @version     $Id: create.html.php 3253 2012-07-02 05:59:24Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include './header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<script>var holders=<?php echo json_encode($lang->story->placeholder);?></script>
<form method='post' enctype='multipart/form-data' target='hiddenwin' id='dataform'>
  <table align='center' class='table-1'>
    <caption><?php echo $lang->sqlreview->create;?></caption>
    <tr>
      <th class='rowhead'><?php echo $lang->sqlreview->source;?></th>
      <td><?php echo html::select('source', $lang->sqlreview->sourceList, $source, 'class=select-3');?></td>
    </tr>
      <tr>
          <th class='rowhead'><?php echo $lang->task->story;?></th>
          <td>
              <?php echo html::select('story', $stories, 0, 'class=select-1 onchange=setPreview();');?>
          </td>
      </tr>
      <tr>
      <th class='rowhead'><?php echo $lang->sqlreview->title;?></th>
      <td><?php echo html::input('title', $title, "class='text-1'");?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->sqlreview->content;?></th>
      <td><?php echo html::textarea('content', $content, "rows='9' class='text-1'");?><br /></td>
    </tr>
      <tr>
          <th class='rowhead'><?php echo $lang->sqlreview->host;?></th>
          <td>
              <?php echo html::input('host_alpha', $host_alpha, "class='text-3'");?>
              <?php echo html::input('host_beta', $host_beta, "class='text-3'");?>
              <?php echo html::input('host_online', $host_online, "class='text-3'");?>
              <span>分别填写alpha、beta、线上的host</span>
          </td>
      </tr>
      <tr>
          <th class='rowhead'><?php echo $lang->sqlreview->db;?></th>
          <td>
              <?php echo html::input('db_alpha', $db_alpha, "class='text-3'");?>
              <?php echo html::input('db_beta', $db_beta, "class='text-3'");?>
              <?php echo html::input('db_online', $db_online, "class='text-3'");?>
              <span>分别填写alpha、beta、线上的db</span>
          </td>
      </tr>
     <tr>
      <th class='rowhead'><?php echo $lang->sqlreview->pri;?></th>
      <td><?php echo html::select('pri', (array)$lang->story->priList, $pri, 'class=select-3');?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->sqlreview->reviewedBy;?></th>
      <td><?php echo html::select('assignedTo', $users, '', 'class=select-3');?></td>
    </tr>
     <tr>
      <th class='rowhead'><nobr><?php echo $lang->sqlreview->mailto;?></nobr></th>
      <td><?php echo html::input('mailto', $mailto, 'class="text-1"');?></td>
    </tr>

    <tr>
      <th class='rowhead'><nobr><?php echo $lang->sqlreview->keywords;?></nobr></th>
      <td><?php echo html::input('keywords', $keywords, 'class="text-1"');?></td>
    </tr>
    <tr><td colspan='2' class='a-center'><?php echo html::submitButton() . html::resetButton();?></td></tr>
  </table>
</form>
<script type="text/javascript">

</script>
<?php include '../../common/view/footer.html.php';?>
