<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php
css::import($defaultTheme . 'treeview.css');
js::import($jsRoot . 'jquery/treeview/min.js');
?>
<script language='javascript'>$(function() { $("#tree").treeview({ persist: "cookie", collapsed: true, unique: true }) })</script>
