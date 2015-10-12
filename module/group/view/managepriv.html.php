<?php
/**
 * The manage privilege view of group module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     group
 * @version     $Id: managepriv.html.php 2605 2012-02-21 07:22:58Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php 
include '../../common/view/header.html.php';
if($type == 'byGroup')  include 'privbygroup.html.php';
if($type == 'byModule') include 'privbymodule.html.php';
include '../../common/view/footer.html.php';
