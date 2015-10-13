<?php
if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}
include 'header.lite.html.php';
include 'colorbox.html.php';
include 'chosen.html.php';
?>
<script>
    $(function(){
        $("form").submit(function(){

            $(".popbox").show();
        })
        $(".p_close").click(function(){
            $(".popbox").hide();
        })
    }
</script>
<style>
    .popm{margin:0 auto;width:200px;height:100px;line-height: 100px;color: #fff;font-size:18px;margin-top: 20%;position: relative;}
    .p_close{font-size:18px;color:#fff;position:absolute;right:-10px;top:-20px;cursor:pointer}
    .popbox{position: fixed;zoom:1;z-index:9999;height: 100%;width: 100%;top:0;left:0;background:rgba(0,0,0,0.5);filter: progid:DXImageTransform.Microsoft.gradient(startcolorstr=#7F000000,endcolorstr=#7F000000);display: none;}
</style>
<div class="popbox">
    <div class="popm"><img src="/loading.gif" alt="正在提交中"/>正在提交中....<div class="p_close">关闭</div></div>
</div>
<div id='header'>
  <table class='cont' id='topbar'>
    <tr>
      <td class='w-p50'>
        <?php
        echo "<span id='companyname'>{$app->company->name}</span> ";
        if($app->company->website)  echo html::a($app->company->website,  $lang->company->website,  '_blank');
        if($app->company->backyard) echo html::a($app->company->backyard, $lang->company->backyard, '_blank');
        ?>
      </td>
      <td class='a-right'><?php commonModel::printTopBar();?></td>
    </tr>
  </table>
  <table class='cont' id='navbar'>
    <tr><td id='mainmenu'><?php commonModel::printMainmenu($this->moduleName); commonModel::printSearchBox();?></td></tr>
  </table>
</div>
<table class='cont' id='navbar'>
   <tr><td id='modulemenu'><?php commonModel::printModuleMenu($this->moduleName);?></td></tr>
</table>
<div id='wrap'>
  <div class='outer'>
