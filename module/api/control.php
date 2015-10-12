<?php
/**
 * The control file of api of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     api
 * @version     $Id: control.php 2605 2012-02-21 07:22:58Z wwccss $
 * @link        http://www.zentao.net
 */
class api extends control
{
    /**
     * Return session to the client.
     * 
     * @access public
     * @return void
     */
    public function getSessionID()
    {
        $this->session->set('rand', mt_rand(0, 10000));
        $this->view->sessionName = session_name();
        $this->view->sessionID   = session_id();
        $this->view->rand        = $this->session->rand;
        $this->display();
    }

    /**
     * Execute a module's model's method, return the result.
     * 
     * @param  string    $moduleName 
     * @param  string    $methodName 
     * @param  string    $params        param1=value1,param2=value2, don't use & to join them.
     * @access public
     * @return string
     */
    public function getModel($moduleName, $methodName, $params = '')
    {
        parse_str(str_replace(',', '&', $params), $params);
        $module = $this->loadModel($moduleName);
        $result = call_user_func_array(array(&$module, $methodName), $params);
        if(dao::isError()) die(json_encode(dao::getError()));
        $output['status'] = $result ? 'success' : 'fail';
        $output['data']   = json_encode($result);
        $output['md5']    = md5($output['data']);
        $this->output     = json_encode($output);
        die($this->output);
    }


    /**
     * api接口，验证登录
     */
    public function ibeacon_login(){
        $username=$_POST['user_name'];
        $password=$_POST['password'];
        $module = $this->loadModel('user');
        $user = $this->user->identify($username, $password);
        if($user!=flase){
            $result['status']=1;
            $result['userid']=$user->id;
        }
        else{
            $result['status']=0;
        }
        echo json_encode($result);
        exit;
    }

    /**
     * api接口，退出登录
     */
    public function   ibeacon_logout(){

    }

    /**
     *
     */
    public function ibeacon_checklist(){

    }


}
