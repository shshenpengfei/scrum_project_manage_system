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
class report extends control
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
    
    /**
     * Project deviation report.
     * 
     * @access public
     * @return void
     */
    public function projectDeviation()
    {
        $this->view->header->title = $this->lang->report->projectDeviation;
        $this->view->projects      = $this->report->getProjects();
        $this->view->users         = $this->loadModel('user')->getPairs('noletter|noclosed');
        $this->view->submenu       = 'project';
        $this->display();
    }

    /**
     * Product information report.
     * 
     * @access public
     * @return void
     */
    public function productInfo()
    {
        $this->app->loadLang('product');
        $this->app->loadLang('productplan');
        $this->app->loadLang('story');
        $this->view->header->title = $this->lang->report->productInfo;
        $this->view->products      = $this->report->getProducts();
        $this->view->users         = $this->loadModel('user')->getPairs('noletter|noclosed');
        $this->view->submenu       = 'product';
        $this->display();
    }

    /**
     * Bug summary report.
     * 
     * @param  int    $begin 
     * @param  int    $end 
     * @access public
     * @return void
     */
    public function bugSummary($begin = 0, $end = 0)
    {
        $this->app->loadLang('bug');
        if($begin == 0) 
        {
            $begin = date('Y-m-d', strtotime('last month'));
        }
        else
        {
            $begin = date('Y-m-d', strtotime($begin));
        }
        if($end == 0)
        {
            $end = date('Y-m-d', strtotime('now'));
        }
        else
        {
            $end = date('Y-m-d', strtotime($end));
        }
        $this->view->header->title = $this->lang->report->bugSummary;
        $this->view->begin         = $begin;
        $this->view->end           = $end;
        $this->view->bugs          = $this->report->getBugs($begin, $end);
        $this->view->users         = $this->loadModel('user')->getPairs('noletter|noclosed');
        $this->view->submenu       = 'test';
        $this->display(); 
    }

    /**
     * Workload report.
     * 
     * @access public
     * @return void
     */
    public function workload()
    {
        $this->view->header->title = $this->lang->report->workload;
        $workload = $this->report->getWorkload();
        $this->view->workload      = $this->report->getWorkload();
        $this->view->users         = $this->loadModel('user')->getPairs('noletter|noclosed');
        $this->view->submenu       = 'staff';
        $this->display();
    }


    //工作时间统计表
    public function worktime(){
        $worklist = $this->dao->select('pkid,begintime,endtime,status,ip,id,endip')->from(TABLE_CHECK)
            ->orderBy('pkid desc')->fetchAll();
        $this->view->submenu       = 'worktime';
        $this->view->worktimelist         = $worklist;
        $this->display();

    }


    //贡献排行榜
    public function top(){
        $userlist = $this->dao->select('id,realname,dept')->from(TABLE_USER)
            ->where('deleted')->eq(0)
            ->orderBy('id desc')->fetchAll();
        //var_dump($userlist);
        $this->view->userlist         = $userlist;
        $this->view->submenu       = 'top';
        $this->display();
    }

    public function daysnum($begin,$end){
        $days=array();
        while($begin<=$end){
            $days[]=sprintf("%02d", $begin);
            $begin++;
        }
        return $days;
    }

    //概要统计
    public function gaiyaoworktime($beginchoose = 0, $endchoose = 0){
        if($beginchoose == 0)
        {
            $beginchoose = date('Y-m-d', strtotime('yesterday'));
        }
        else
        {
            $beginchoose = date('Y-m-d', strtotime($beginchoose));
        }
        if($endchoose == 0)
        {
            $endchoose = date('Y-m-d', strtotime('yesterday'));
        }
        else
        {
            $endchoose = date('Y-m-d', strtotime($endchoose));
        }

        $month=date('Ym', strtotime($beginchoose));
        $beginday=$beginchoose;
        $endday=$endchoose;
        $montharr=array($month=>array($beginday,$endday));
        $begin=1;
        $end=31;
        $june=$this->daysnum($begin,$end);
        $daysarray=$june;
        //var_dump($june);

        $holiday=file_get_contents("http://www.easybots.cn/api/holiday.php?m=".$month);
        $holiday=json_decode($holiday,true);
        //var_dump($holiday[$month]);

        $worklist = $this->dao->select('id,pkid,begintime,endtime,status,ip,id,workday,worktime')->from(TABLE_CHECK)
            ->where('workday')->ge($beginday)->andwhere('workday')->le($endday)->fetchAll();

        $newlist=array();
        foreach($worklist as $person=>$val){
            $day=date("d",strtotime($val->workday));
            //echo $val->id."___".$val->workday."___".$day."<br>";
            $newlist[$val->id][$day]=$val->worktime;
        }

        foreach($newlist as $user=>$val){
            $userdays=(array_keys($val));
            foreach($daysarray as $everyday){
                if(!in_array($everyday,$userdays)){
                    if($holiday[$month][$everyday]==1){
                    $newlist[$user][$everyday]="双休";
                    }
                    elseif($holiday[$month][$everyday]==2){
                        $newlist[$user][$everyday]="假日";
                    }
                    else{
                    $newlist[$user][$everyday]="缺岗";
                    }

                }
            }
            ksort($newlist[$user]);
            //var_dump($val);
        }
        ksort($newlist);

        $this->view->begin         = $beginchoose;
        $this->view->end           = $endchoose;
        $this->view->month         = $month;

        $this->view->submenu       = 'worktime';
        $this->view->daysarray         = $daysarray;
        $this->view->montharr       =$montharr;
        $this->view->newlist         = $newlist;
        $this->display();

    }


    /**
     * code review
     */
    public function codereview(){
        echo "<script language='javascript'>";
        echo 'window.top.location="http://10.43.50.237:8008"';
        echo "</script>";
    }

    //某用户的工作时间统计
    public function userworktime(){
        $uid=!is_null($_GET['u'])?$_GET['u']:$this->app->user->id;
        $worklist = $this->dao->select('pkid,begintime,endtime,status,ip,id,workday,worktime,endip')->from(TABLE_CHECK)
            ->where('id')->eq($uid)->orderBy('pkid desc')->fetchAll();

        foreach ($worklist as $item) {
            $lasttime=html::calculateWorktime($item->begintime,$item->endtime);
            $workday=date('Y-m-d',$item->begintime);
            $lasttime=number_format($lasttime,1);
            $sql = "UPDATE " . TABLE_CHECK . " SET workday='".$workday."' , worktime = '".$lasttime."'  WHERE pkid = '".$item->pkid."' ";
            $this->dbh->exec($sql);
            //echo $sql."<br>";
        }


        $users=$this->loadModel('user')->getById($uid);


        //echo "<pre>";
        //var_dump($worklist);
        //echo "</pre>";

        //$sql = "UPDATE " . TABLE_CHECK . " SET worktime = 0 WHERE parent = '$projectID'";
        //$this->dbh->exec($sql);
        $this->view->UserDayData = $this->report->getUserDayData($uid,$item->begintime,$item->endtime);
        $this->view->submenu       = 'worktime';
        $this->view->checkuserinfo       = $users;
        $this->view->worktimelist         = $worklist;
        $this->display();
    }





    //延期统计报表(需求)
    public function delay($begin = 0, $end = 0, $project = -1){
        $this->app->loadLang('story');
        if($begin == 0)
        {
            $begin = date('Y-m-d', strtotime('yesterday'));
        }
        else
        {
            $begin = date('Y-m-d', strtotime($begin));
        }
        if($end == 0)
        {
            $end = date('Y-m-d', strtotime('yesterday'));
        }
        else
        {
            $end = date('Y-m-d', strtotime($end));
        }

        $projects = $this->report->getProject();
        $this->view->header->title = $this->lang->report->delay;
        $this->view->begin         = $begin;
        $this->view->end           = $end;
        $this->view->project           = $project;
        $this->view->delayStory          = $this->report->getDelayStory($begin, $end, $project);
        $this->view->charData = $this->report->getCharDataForDelayStory($begin, $end);
        $this->view->projects         = $projects;
        $this->view->submenu       = 'delay';
        $this->display();
    }

    //延期统计报表(任务)
    public function delayTask($begin = 0, $end = 0, $project = -1){
        $this->app->loadLang('task');
        if($begin == 0)
        {
            $begin = date('Y-m-d', strtotime('yesterday'));
        }
        else
        {
            $begin = date('Y-m-d', strtotime($begin));
        }
        if($end == 0)
        {
            $end = date('Y-m-d', strtotime('yesterday'));
        }
        else
        {
            $end = date('Y-m-d', strtotime($end));
        }
        $projects = $this->report->getProject();
        $this->view->header->title = $this->lang->report->delay;
        $this->view->begin         = $begin;
        $this->view->end           = $end;
        $this->view->project           = $project;
        $this->view->delayTask          = $this->report->getDelayTask($begin, $end, $project);
        $this->view->charData = $this->report->getCharDataForDelayTask($begin, $end);
        $this->view->projects         = $projects;
        $this->view->submenu       = 'delay';
        $this->display();
    }

}
