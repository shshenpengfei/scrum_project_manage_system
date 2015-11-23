<?php
/**
 * The control file of dashboard module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dashboard
 * @version     $Id: control.php 3290 2012-07-02 15:23:59Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
class my extends control
{
    /**
     * Construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('user');
        $this->loadModel('dept');
        $this->my->setMenu();
    }

    /**
     * Index page, goto todo.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $account = $this->app->user->account;

        /* Get project and product stats. */
        $projectStats = $this->loadModel('project')->getProjectStats();
        $productStats = $this->loadModel('product')->getStats();

        /* Set the dynamic pager. */
        $this->app->loadClass('pager', true);
        $pager = new pager(0, $this->config->my->dynamicCounts);
        
        $storyinfo = $this->loadModel('story')->getUserStories($account, 'assignedTo', $this->config->my->storyCounts);
        $this->view->projectStats  = $projectStats;
        $this->view->productStats  = $productStats;
        $this->view->actions       = $this->loadModel('action')->getDynamic('all', 'all', 'date_desc', $pager,'all','all',0);
        $this->view->todos         = $this->loadModel('todo')->getList('all', $account, 'wait, doing', $this->config->my->todoCounts);
        $this->view->tasks         = $this->loadModel('task')->getUserTasks($account, 'assignedTo', $this->config->my->taskCounts);
        $mytesttask = $this->loadModel('testtask')->getByUser($account);
        $this->view->testtasks         = $mytesttask;
        $this->view->storys         = $storyinfo;
        $this->view->bugs          = $this->loadModel('bug')->getUserBugPairs($account, false, $this->config->my->bugCounts);
        $this->view->users         = $this->loadModel('user')->getPairs('noletter|withguest');
        $this->view->header->title = $this->lang->my->common;

        $this->display();
    }

    /**
     * My todos. 
     * 
     * @param  string $type 
     * @param  string $account 
     * @param  string $status 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function todo($type = 'today', $account = '', $status = 'all', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session. */
        $uri = $this->app->getURI(true);
        $this->session->set('todoList', $uri);
        $this->session->set('bugList',  $uri);
        $this->session->set('taskList', $uri);

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* The header and position. */
        $this->view->header->title = $this->lang->my->common . $this->lang->colon . $this->lang->my->todo;
        $this->view->position[]    = $this->lang->my->todo;

        /* Assign. */
        $this->view->dates   = $this->loadModel('todo')->buildDateList();
        $this->view->todos   = $this->todo->getList($type, $account, $status, 0, $pager);
        $this->view->date    = (int)$type == 0 ? date(DT_DATE1) : date(DT_DATE1, strtotime($type));
        $this->view->type    = $type;
        $this->view->status  = $status;
        $this->view->account = $this->app->user->account;
        $this->view->pager   = $pager;
        $this->view->importFuture = ($type == 'before' or $type == 'future' or $type == TODOMODEL::DAY_IN_FUTURE);

        $this->display();
    }

    /**
     * My stories 
      
     * @param  string $type 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function story($type = 'assignedto', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session. */
        $this->session->set('storyList', $this->app->getURI(true));

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* Assign. */
        $this->view->header->title = $this->lang->my->common . $this->lang->colon . $this->lang->my->story;
        $this->view->position[]    = $this->lang->my->story;
        $this->view->stories       = $this->loadModel('story')->getUserStories($this->app->user->account, $type, 'id_desc', $pager);
        $this->view->users         = $this->user->getPairs('noletter');
        $this->view->type          = $type;
        $this->view->pager         = $pager;

        $this->display();
    }

    /**
     * My tasks
     * 
     * @param  string $type 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function task($type = 'assignedto', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session. */
        $this->session->set('taskList',  $this->app->getURI(true));
        $this->session->set('storyList', $this->app->getURI(true));

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* Assign. */
        $this->view->header->title = $this->lang->my->common . $this->lang->colon . $this->lang->my->task;
        $this->view->position[]    = $this->lang->my->task;
        $this->view->tabID         = 'task';
        $this->view->tasks         = $this->loadModel('task')->getUserTasks($this->app->user->account, $type, 0, $pager);
        $this->view->type          = $type;
        $this->view->users         = $this->loadModel('user')->getPairs('noletter');
        $this->view->pager         = $pager;
        $this->display();
    }

    /**
     * My bugs.
     * 
     * @param  string $type 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function bug($type = 'assigntome', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session. load Lang. */
        $this->session->set('bugList', $this->app->getURI(true));
        $this->app->loadLang('bug');
 
        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        $bugs = array();
        if($type == 'assigntome')
        {
            $bugs = $this->dao->select('t1.*')
                ->from(TABLE_BUG)->alias('t1')
                ->leftJoin(TABLE_PRODUCT)->alias('t2')
                ->on('t1.product = t2.id')
                ->where('t2.deleted')->eq(0)
                ->andWhere('t1.deleted')->eq(0)
                ->andWhere('t1.assignedTo')->eq($this->app->user->account)
                ->orderBy('t1.id_desc')->page($pager)->fetchAll();
        }
        elseif($type == 'openedbyme')
        {
            $bugs = $this->dao->findByOpenedBy($this->app->user->account)->from(TABLE_BUG)
                ->andWhere('deleted')->eq(0)
                ->orderBy($orderBy)->page($pager)->fetchAll();
        }
        elseif($type == 'resolvedbyme')
        {
            $bugs = $this->dao->findByResolvedBy($this->app->user->account)->from(TABLE_BUG)
                ->andWhere('deleted')->eq(0)
                ->orderBy($orderBy)->page($pager)->fetchAll();
        }
        elseif($type == 'closedbyme')
        {
            $bugs = $this->dao->findByClosedBy($this->app->user->account)->from(TABLE_BUG)
                ->andWhere('deleted')->eq(0)
                ->orderBy($orderBy)->page($pager)->fetchAll();
        }

        /* Save bugIDs session for get the pre and next bug. */
        $bugIDs = '';
        foreach($bugs as $bug) $bugIDs .= ',' . $bug->id;
        $this->session->set('bugIDs', $bugIDs . ',');

        /* assign. */
        $this->view->header->title = $this->lang->my->common . $this->lang->colon . $this->lang->my->bug;
        $this->view->position[]    = $this->lang->my->bug;
        $this->view->bugs          = $bugs;
        $this->view->users         = $this->user->getPairs('noletter');
        $this->view->tabID         = 'bug';
        $this->view->type          = $type;
        $this->view->pager         = $pager;

        $this->display();
    }

    /**
     * My test task.
     * 
     * @access public
     * @return void
     */
    public function testtask()
    {
        /* Save session. */
        $this->session->set('testtaskList', $this->app->getURI(true));

        $this->app->loadLang('testcase');

        $this->view->header->title = $this->lang->my->common . $this->lang->colon . $this->lang->my->testTask;
        $this->view->position[]    = $this->lang->my->testTask;
        $this->view->tasks         = $this->loadModel('testtask')->getByUser($this->app->user->account);
        
        $this->display();

    }

    /**
     * My test case.
     * 
     * @param  string $type 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function testcase($type = 'assigntome', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session, load lang. */
        $this->session->set('caseList', $this->app->getURI(true));
        $this->app->loadLang('testcase');
        
        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);
        
        $cases = array();
        if($type == 'assigntome')
        {
            $cases = $this->dao->select('t1.assignedTo AS assignedTo, t2.*')->from(TABLE_TESTRUN)->alias('t1')
                ->leftJoin(TABLE_CASE)->alias('t2')->on('t1.case = t2.id')
                ->leftJoin(TABLE_TESTTASK)->alias('t3')->on('t1.task = t3.id')
                ->Where('t1.assignedTo')->eq($this->app->user->account)
                ->andWhere('t1.status')->ne('done')
                ->andWhere('t3.status')->ne('done')
                ->orderBy($orderBy)->page($pager)->fetchAll();
        }
        elseif($type == 'donebyme')
        {
            $cases = $this->dao->select('t1.assignedTo AS assignedTo, t2.*')->from(TABLE_TESTRUN)->alias('t1')
                ->leftJoin(TABLE_CASE)->alias('t2')->on('t1.case = t2.id')
                ->Where('t1.assignedTo')->eq($this->app->user->account)
                ->andWhere('t1.status')->eq('done')
                ->orderBy($orderBy)->page($pager)->fetchAll();
        }
        elseif($type == 'openedbyme')
        {
            $cases = $this->dao->findByOpenedBy($this->app->user->account)->from(TABLE_CASE)
                ->andWhere('deleted')->eq(0)
                ->orderBy($orderBy)->page($pager)->fetchAll();
        }
        $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'testcase');
        
        /* Assign. */
        $this->view->header->title = $this->lang->my->common . $this->lang->colon . $this->lang->my->testCase;
        $this->view->position[]    = $this->lang->my->testCase;
        $this->view->cases         = $cases;
        $this->view->users         = $this->user->getPairs('noletter');
        $this->view->tabID         = 'test';
        $this->view->type          = $type;
        $this->view->pager         = $pager;
        
        $this->display();
    }

    /**
     * My projects.
     * 
     * @access public
     * @return void
     */
    public function project()
    {
        $this->app->loadLang('project');

        $this->view->header->title = $this->lang->my->common . $this->lang->colon . $this->lang->my->myProject;
        $this->view->position[]    = $this->lang->my->myProject;
        $this->view->tabID         = 'project';
        $this->view->projects      = @array_reverse($this->user->getProjects($this->app->user->account));

        $this->display();
    }

    /**
     * Edit profile 
     *
     * @access public
     * @return void
     */
    public function editProfile()
    {
        if($this->app->user->account == 'guest') die(js::alert('guest') . js::locate('back'));
        if(!empty($_POST))
        {
            $this->user->update($this->app->user->id);
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::locate($this->createLink('my', 'profile'), 'parent'));
        }

        $this->view->header->title = $this->lang->my->common . $this->lang->colon . $this->lang->my->editProfile;
        $this->view->position[]    = $this->lang->my->editProfile;
        $this->view->user          = $this->user->getById($this->app->user->id);

        $this->display();
    }

    /**
     * Change password 
     * 
     * @access public
     * @return void
     */
    public function changePassword()
    {
        if($this->app->user->account == 'guest') die(js::alert('guest') . js::locate('back'));
        if(!empty($_POST))
        {
            $this->user->updatePassword($this->app->user->id);
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::locate($this->createLink('my', 'profile'), 'parent'));
        }

        $this->view->header->title = $this->lang->my->common . $this->lang->colon . $this->lang->my->changePassword;
        $this->view->position[]    = $this->lang->my->changePassword;
        $this->view->user          = $this->user->getById($this->app->user->id);

        $this->display();
    }

    /**
     * View my profile.
     * 
     * @access public
     * @return void
     */
    public function profile()
    {
        if($this->app->user->account == 'guest') die(js::alert('guest') . js::locate('back'));
        $user                 = $this->user->getById($this->app->user->account);
        $deptPath             = $this->dept->getParents($user->dept); 
        $this->view->deptPath = $deptPath;
        $this->view->header->title = $this->lang->my->common . $this->lang->colon . $this->lang->my->profile;
        $this->view->position[]    = $this->lang->my->profile;
        $this->view->user          = $this->user->getById($this->app->user->id);
        $this->display();
    }

    /**
     * My dynamic.
     * 
     * @param  string $type 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function dynamic($type = 'today', $orderBy = 'date_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session. */
        $uri = $this->app->getURI(true);
        $this->session->set('productList',     $uri);
        $this->session->set('productPlanList', $uri);
        $this->session->set('releaseList',     $uri);
        $this->session->set('storyList',       $uri);
        $this->session->set('projectList',     $uri);
        $this->session->set('taskList',        $uri);
        $this->session->set('buildList',       $uri);
        $this->session->set('bugList',         $uri);
        $this->session->set('caseList',        $uri);
        $this->session->set('testtaskList',    $uri);

        /* Set the pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);
        $this->view->orderBy = $orderBy;
        $this->view->pager   = $pager;

        /* The header and position. */
        $this->view->header->title = $this->lang->my->common . $this->lang->colon . $this->lang->my->dynamic;
        $this->view->position[]    = $this->lang->my->dynamic;

        /* Assign. */
        $this->view->type    = $type;
        $this->view->actions = $this->loadModel('action')->getDynamic($this->app->user->account, $type, $orderBy, $pager);
        $this->display();
    }

    public function weekly(){
        $week = date('w');
        $mon = date('Y-m-d',strtotime( '+'. 1-$week .' days' ));
        $fri = date('Y-m-d',strtotime( '+'. 5-$week .' days' ));

        $mon_next = date('Y-m-d',strtotime( '+'. 1-$week+7 .' days' ));
        $fri_next = date('Y-m-d',strtotime( '+'. 5-$week+7 .' days' ));
        $this->view->begin = $mon;
        $this->view->end = $fri;
        $this->view->begin_next = $mon_next;
        $this->view->end_next = $fri_next;
        $this->display();
    }

    public function birth($begin, $end, $begin_next, $end_next, $show = 0){

        $me = $this->app->user->account;
        if($show){
            $mailContent = $this->fetch('task', 'reportweekly', array($me,$begin, $end, $begin_next, $end_next));
            echo $mailContent;
            exit;
        }

        $user_info = $this->loadModel('user')->getById($me);
        if(!empty($_POST))
        {
            $post = fixer::input('post')->get();
            $mailContent = $this->fetch('task', 'reportweekly', array($this->app->user->account,$begin, $end, $begin_next, $end_next));
            $assignedTo = implode(",",$post->assignedTo);
            $team = $user_info->position == 'leader' ? '组' : '';
            $mailto = $post->mailto;
            $subject = $user_info->realname.$team.$begin.'至'.$end.'周报';
            /* Send emails. */
            $this->loadModel('mail')->setReplyTo($user_info->email,$user_info->realname);
            $this->loadModel('mail')->send($assignedTo, $subject, $mailContent, $mailto,true,$user_info->realname);
            if($this->mail->isError()) echo js::error($this->mail->getError());

            echo js::alert("邮件发送成功！");
            die(js::locate($this->createLink('my', 'index', ""), 'parent'));
        }

        $childDeptIds = $this->loadModel('dept')->getAllChildID($user_info->dept);
        $members = array();
        $guys_list = $this->dept->getUsers($childDeptIds);
        foreach($guys_list as $g){
            $members[$g->account] = $g->realname;
        }

        //unset($members[$me]);
        //if($user_info->position != 'engineer'){
        //    $members = array_merge($members,array('eric_shen'=>'eric_shen'));
        //}

        $this->view->members  = $members;
        $mailContent = $this->fetch('task', 'reportweekly', array($me,$begin, $end, $begin_next, $end_next));
        $this->view->mailContent   = $mailContent;
        $this->view->users    = $this->loadModel('user')->getPairs('noletter');


        $this->display();

    }

    public function plan($type = 'today', $account = '', $status = 'all', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session. */
        $uri = $this->app->getURI(true);
        $this->session->set('todoList', $uri);
        $this->session->set('bugList',  $uri);
        $this->session->set('taskList', $uri);

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* The header and position. */
        $this->view->header->title = $this->lang->my->common . $this->lang->colon . $this->lang->my->todo;
        $this->view->position[]    = $this->lang->my->todo;

        /* Assign. */
        $this->view->dates   = $this->loadModel('todo')->buildDateList();
        $this->view->todos   = $this->todo->getList($type, $account, $status, 0, $pager, '', 'plan');
        $this->view->date    = (int)$type == 0 ? date(DT_DATE1) : date(DT_DATE1, strtotime($type));
        $this->view->type    = $type;
        $this->view->status  = $status;
        $this->view->account = $this->app->user->account;
        $this->view->pager   = $pager;
        $this->view->importFuture = ($type == 'before' or $type == 'future' or $type == TODOMODEL::DAY_IN_FUTURE);

        $this->display();
    }

    /**
     * My sqls

     * @param  string $type
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function sqlreview($type = 'assignedto', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session. */
        $this->session->set('sqlList', $this->app->getURI(true));

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* Assign. */
        $this->view->header->title = $this->lang->my->common . $this->lang->colon . $this->lang->my->story;
        $this->view->position[]    = $this->lang->my->story;
            $this->view->sqls       = $this->loadModel('sqlreview')->getUserSqls($this->app->user->account, $type, 'id_desc', $pager);
        $this->view->users         = $this->user->getPairs('noletter');
        $this->view->type          = $type;
        $this->view->pager         = $pager;

        $this->display();
    }


    public function beginwork(){

        $this->loadModel('my')->beginwork();


    }

    public function endwork(){

        $this->loadModel('my')->endwork();


    }

    public function myworktime(){
        $this->view->myworktimelist = $this->loadModel('my')->myworktime();
        $this->display();

    }

}

