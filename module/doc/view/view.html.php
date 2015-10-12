<?php
/**
 * The view of doc module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Jia Fu <fujia@cnezsoft.com>
 * @package     doc
 * @version     $Id: view.html.php 975 2010-07-29 03:30:25Z jajacn@126.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<table class='table-1'>
  <caption><?php echo $doc->title . $lang->colon . $lang->doc->view;?></caption>
  <tr>
    <th class='rowhead'><?php echo $lang->doc->title;?></th>
    <td <?php if($doc->deleted) echo "class='deleted'";?>><?php echo $doc->title;?></td>
  </tr>
  <tr>
    <th class='rowhead'><?php echo $lang->doc->lib;?></th>
    <td><?php echo $lib;?></td>
  </tr>
  <tr>
    <th class='rowhead'><?php echo $lang->doc->module;?></th>
    <td><?php echo $doc->moduleName;?></td>
  </tr>
  <tr>
    <th class='rowhead'><?php echo $lang->doc->type;?></th>
    <td><?php echo $lang->doc->types[$doc->type];?></td>
  </tr>  
    <th class='rowhead'><?php echo $lang->doc->title;?></th>
    <td><?php echo $doc->title;?></td>
  </tr> 
  <tr>
    <th class='rowhead'><?php echo $lang->doc->keywords;?></th>
    <td><?php echo $doc->keywords;?></td>
  </tr>  
  <tr id='urlBox' <?php if($doc->type != 'url') echo "class='hidden'";?>>
    <th class='rowhead'><?php echo $lang->doc->url;?></th>
    <td><?php echo html::a(urldecode($doc->url), '', '_blank');?></td>
  </tr>  
  <tr id='contentBox' <?php if($doc->type != 'text') echo "class='hidden'";?>>
    <th class='rowhead'><?php echo $lang->doc->content;?></th>
    <td class='content'><?php echo $doc->content;?></td>
  </tr>  
  <tr>
    <th class='rowhead'><?php echo $lang->doc->digest;?></th>
    <td><?php echo nl2br($doc->digest);?></td>
  </tr>  
  <tr id='fileBox' <?php if($doc->type != 'file') echo "class='hidden'";?>>
    <th class='rowhead'><?php echo $lang->files;?></th>
    <td><?php echo $this->fetch('file', 'printFiles', array('files' => $doc->files, 'fieldset' => 'false'));?></td>
  </tr>
</table>
<div class='a-center f-16px strong'>
  <?php
  $browseLink = $this->session->docList ? $this->session->docList : inlink('browse');
  if(!$doc->deleted)
  {
      common::printLink('doc', 'edit',   "docID=$doc->id", $lang->edit);
      common::printLink('doc', 'delete', "docID=$doc->id", $lang->delete, 'hiddenwin');
  }
  echo html::a($browseLink, $lang->goback);
  ?>
</div>
<?php include '../../common/view/action.html.php';?>
<?php include './footer.html.php';?>
