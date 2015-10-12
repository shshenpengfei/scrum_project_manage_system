<?php 
include '/home/z/pms/module/user/model.php';
class extuserModel extends userModel {

/**
 * The model file of sunyard module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     business(商业软件) 
 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     sunyard 
 * @version     $Id$
 * @link        http://www.zentao.net
 */

/**
 * Get efforts. 
 * 
 * @param  string $account 
 * @param  int    $date 
 * @param  string $project 
 * @access public
 * @return void
 */
public function getEfforts($account = 'all', $date, $project = '', $begin = '', $end = '')
{
    $this->loadModel('todo');
    $efforts = array();
    if($date == 'today') 
    {
        $begin = $this->todo->today();
        $end   = $begin;
    }
    elseif($date == 'thisweek')
    {
        extract($this->todo->getThisWeek());
    }
    elseif($date == 'lastweek')
    {
        extract($this->todo->getLastWeek());
    }
    elseif($date == 'thismonth')
    {
        extract($this->todo->getThisMonth());
    }
    elseif($date == 'lastmonth')
    {
        extract($this->todo->getLastMonth());
    }
    elseif($date == 'select')
    {
        if($begin == '') $begin = helper::today();
        if($end   == '') $end   = helper::today();
    }
    elseif($date == 'all')
    {
        $begin = '1970-01-01';
        $end   = '2109-01-01';
    }
    else
    {
        $begin = $end = $date;
    }

    $efforts = $this->dao->select('*')->from(TABLE_SUNEFFORTEVERYDAY)
        ->where('account')->eq($this->app->user->account)
        ->andWhere("date >= '$begin'")
        ->andWhere("date <= '$end'")
        ->beginIF($project != '')->andWhere('project')->eq($project)->fi()
        ->beginIF($account != 'all')->andWhere('account')->eq($account)->fi()
        ->fetchAll('id');
    return $efforts;
}
	public function __call($method, $params)
	{
        $extClasses = array();
        foreach($extClasses as $extClass)
        {
            if(method_exists($extClass, $method))
            {
                $class = new $extClass();
                return call_user_func_array(array(&$class, $method), $params);
            }
        }
    }
}