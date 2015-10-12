<?php
/**
 * The control file of upgrade module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id: control.php 2605 2012-02-21 07:22:58Z wwccss $
 * @link        http://www.zentao.net
 */
class upgrade extends control
{
    /**
     * The index page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->display();
    }

    /**
     * Select the version of old zentao.
     * 
     * @access public
     * @return void
     */
    public function selectVersion()
    {
        $version = str_replace(array(' ', '.'), array('', '_'), $this->config->installedVersion);
        $version = strtolower($version);
        $this->view->header->title = $this->lang->upgrade->common . $this->lang->colon . $this->lang->upgrade->selectVersion;
        $this->view->position[]    = $this->lang->upgrade->common;
        $this->view->version       = $version;
        $this->display();
    }

    /**
     * Confirm the version.
     * 
     * @access public
     * @return void
     */
    public function confirm()
    {
        $this->view->header->title = $this->lang->upgrade->confirm;
        $this->view->position[]    = $this->lang->upgrade->common;
        $this->view->confirm       = $this->upgrade->getConfirm($this->post->fromVersion);
        $this->view->fromVersion   = $this->post->fromVersion;

        $this->display();
    }

    /**
     * Execute the upgrading.
     * 
     * @access public
     * @return void
     */
    public function execute()
    {
        $this->upgrade->execute($this->post->fromVersion);

        $this->view->header->title = $this->lang->upgrade->result;
        $this->view->position[]    = $this->lang->upgrade->common;

        if(!$this->upgrade->isError())
        {
            $this->view->result = 'success';
        }
        else
        {
            $this->view->result = 'fail';
            $this->view->errors = $this->upgrade->getError();
        }
        $this->display();
    }
}
