<?php
/**
 * The control file of report module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     report
 * @version     $Id: control.php 3345 2012-07-16 01:45:37Z zhujinyonging@gmail.com $
 * @link        http://www.zentao.net
 */
class top extends control
{
    /**
     * The index of report, goto project deviation.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->locate(inlink('projectdeviation')); 
    }


    public function top(){
        try{
            $userlist = $this->dao->select('realname,dept')->from(TABLE_USER)->where('deleted')->eq(0)->orderBy('id desc')->fetchAll();
            //var_dump($userlist);
            //exit;
        }
        catch(Exception $e){
            print $e->getMessage();
            exit();
        }

        $this->view->userlist         = $userlist;
        $this->view->submenu       = 'top';
        $this->display();
    }

}
