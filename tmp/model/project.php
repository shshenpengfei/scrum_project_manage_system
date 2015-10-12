<?php 
include '/home/z/pms/module/project/model.php';
class extprojectModel extends projectModel {

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
 * Delete all data for Sunyard 
 * 
 * @access public
 * @return void
 */
public function deleteSunyard()
{
    $deleteProjects = fixer::input('post')->get();
    foreach($deleteProjects->projects as $projectID)
    {
        $this->dao->delete()->from(TABLE_SUNEFFORTEVERYDAY)->where('project')->eq($projectID)->exec();
        $this->dao->delete()->from(TABLE_SUNPROJECTESTIMATE)->where('project')->eq($projectID)->exec();
    }
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