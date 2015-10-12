<?php
/**
 * The control file of story module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     story
 * @version     $Id: control.php 3186 2012-07-01 01:59:14Z zhujinyonging@gmail.com $
 * @link        http://www.zentao.net
 */
class sqlreview extends control
{
    /**
     * The construct function, load product, tree, user auto.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('product');
        $this->loadModel('project');
        $this->loadModel('tree');
        $this->loadModel('user');
        $this->loadModel('action');
        $this->loadModel('story');
    }

    /**
     * Create a story.
     * 
     * @param  int    $productID 
     * @param  int    $moduleID 
     * @access public
     * @return void
     */
    public function create($projectID = 0, $sqlID = 0, $moduleID = 0)
    {


        if(!empty($_POST))
        {
            $sqlID = $this->sqlreview->create($projectID);
            if(dao::isError()) die(js::error(dao::getError()));

            $actionID = $this->action->create('sqlreview', $sqlID, 'Opened', '');


            $this->sendMail($sqlID, $actionID);
            if($projectID == 0)
            {
                die(js::locate($this->createLink('sqlreview', 'view', "sqlID=$sqlID"), 'parent'));
            }
            else
            {
                die(js::locate($this->createLink('project', 'sqlreview', "projectID=$projectID"), 'parent'));
            }
        }

        /* Set products, users and module. */


        $products = $this->product->getProductsByProject($projectID);

        $users    = $this->user->getPairs('nodeleted');

        /* Set menu. */
        //$this->product->setMenu($products, $product->id);

        /* Init vars. */
        $planID     = 0;
        $source     = 'dev';
        $pri        = 2;
        $title      = '';
        $content       = '';
        $keywords   = '';
        $mailto     = '';
        $host_alpha = '';
        $host_beta = '';
        $host_online = '';
        $db_alpha = '';
        $db_beta = '';
        $db_online = '';

        if($sqlID > 0)
        {
            $sql      = $this->sqlreview->getByID($sqlID);
            $planID     = $sql->plan;
            $source     = $sql->source;
            $pri        = $sql->pri;
            $moduleID   = $sql->module;
            $title      = $sql->title;
            $content       = htmlspecialchars($sql->content);
            $keywords   = $sql->keywords;
            $mailto     = $sql->mailto;
            $host_alpha = $sql->host_alpha;
            $host_beta = $sql->host_beta;
            $host_online = $sql->host_online;
            $db_alpha = $sql->db_alpha;
            $db_beta = $sql->db_beta;
            $db_online = $sql->db_online;
        }

        //$this->view->header->title    = $product->name . $this->lang->colon . $this->lang->story->create;
        //$this->view->position[]       = html::a($this->createLink('product', 'browse', "product=$productID"), $product->name);
        $this->view->sqlID  = $sqlID;
        $this->view->stories  = $this->story->getProjectStoryPairs($projectID);
        $this->view->position[]       = $this->lang->story->create;
        $this->view->products         = $products;
        $this->view->users            = $users;
        $this->view->moduleID         = $moduleID;
        $this->view->planID           = $planID;
        $this->view->source           = $source;
        $this->view->pri              = $pri;
        $this->view->title            = $title;
        $this->view->content             = $content;
        $this->view->keywords         = $keywords;
        $this->view->mailto           = $mailto;
        $this->view->host_alpha = $host_alpha;
        $this->view->host_beta = $host_beta;
        $this->view->host_online = $host_online;
        $this->view->db_alpha = $db_alpha;
        $this->view->db_beta = $db_beta;
        $this->view->db_online = $db_online;

        $this->display();
    }
    
    /**
     * Create a batch stories.
     * 
     * @param  int    $productID 
     * @param  int    $moduleID 
     * @access public
     * @return void
     */
    public function batchCreate($productID = 0, $moduleID = 0)
    {
        if(!empty($_POST))
        {
            $mails = $this->story->batchCreate($productID);
            if(dao::isError()) die(js::error(dao::getError()));

            foreach($mails as $mail)
            {
                $this->sendMail($mail->storyID, $mail->actionID);
            }
            die(js::locate($this->createLink('product', 'browse', "productID=$productID"), 'parent'));
        }

        /* Set products, users and module. */
        $product  = $this->product->getById($productID);
        $products = $this->product->getPairs();
        $moduleOptionMenu = $this->tree->getOptionMenu($productID, $viewType = 'story');

        /* Set menu. */
        $this->product->setMenu($products, $product->id);

        /* Init vars. */
        $planID     = 0;
        $pri        = 0;
        $estimate   = '';
        $title      = '';
        $spec       = '';

        $moduleOptionMenu['same'] = $this->lang->story->same;
        $plans = $this->loadModel('productplan')->getPairs($productID, 'unexpired');
        $plans['same'] = $this->lang->story->same;

        $this->view->header->title    = $product->name . $this->lang->colon . $this->lang->story->create;
        $this->view->position[]       = html::a($this->createLink('product', 'browse', "product=$productID"), $product->name);
        $this->view->position[]       = $this->lang->story->create;
        $this->view->products         = $products;
        $this->view->moduleID         = $moduleID;
        $this->view->moduleOptionMenu = $moduleOptionMenu;
        $this->view->plans            = $plans; 
        $this->view->planID           = $planID;
        $this->view->pri              = $pri;
        $this->view->productID        = $productID;
        $this->view->estimate         = $estimate;
        $this->view->title            = $title;
        $this->view->spec             = $spec;

        $this->display();
    }

    /**
     * The common action when edit or change a story.
     * 
     * @param  int    $sqlID
     * @access public
     * @return void
     */
    public function commonAction($sqlID)
    {
        /* Get datas. */
        $sql    = $this->sqlreview->getById($sqlID);
        $product  = $this->product->getById($sql->product);
        $products = $this->product->getPairs();
        $users    = $this->user->getPairs('nodeleted');
        //$moduleOptionMenu = $this->tree->getOptionMenu($product->id, $viewType = 'story');


        /* Assign. */
        $this->view->product          = $product;
        $this->view->products         = $products;
        $this->view->sql            = $sql;
        $this->view->users            = $users;
        $this->view->actions          = $this->action->getList('sqlreview', $sqlID);
    }

    /**
     * Edit a story.
     * 
     * @param  int    $sqlID
     * @access public
     * @return void
     */
    public function edit($sqlID)
    {
        if(!empty($_POST))
        {
            $changes = $this->sqlreview->update($sqlID);
            if(dao::isError()) die(js::error(dao::getError()));
            if($this->post->comment != '' or !empty($changes))
            {
                $action   = !empty($changes) ? 'Edited' : 'Commented';
                $actionID = $this->action->create('sqlreview', $sqlID, $action, $this->post->comment);
                $this->action->logHistory($actionID, $changes);
                $this->sendMail($sqlID, $actionID);
            }
            die(js::locate($this->createLink('sqlreview', 'view', "stqlID=$sqlID"), 'parent'));
        }

        $this->commonAction($sqlID);
  
        /* Assign. */
        $this->view->position[]    = $this->lang->story->edit;
        $this->display();
    }

    /**
     * Change a story.
     * 
     * @param  int    $sqlID
     * @access public
     * @return void
     */
    public function change($sqlID)
    {
        if(!empty($_POST))
        {
            $changes = $this->sqlreview->change($sqlID);
            if(dao::isError()) die(js::error(dao::getError()));
            if($this->post->comment != '' or !empty($changes))
            {
                $action = !empty($changes) ? 'Changed' : 'Commented';
                $actionID = $this->action->create('sqlreview', $sqlID, $action, $this->post->comment);
                $this->action->logHistory($actionID, $changes);
                $this->sendMail($sqlID, $actionID);
            }
            die(js::locate($this->createLink('sqlreview', 'view', "storyID=$sqlID"), 'parent'));
        }

        $this->commonAction($sqlID);
        $this->app->loadLang('task');
        $this->app->loadLang('bug');
        $this->app->loadLang('testcase');
        $this->app->loadLang('project');

        /* Assign. */
        $this->view->position[]    = $this->lang->story->change;
        $this->display();
    }

    /**
     * Activate a story.
     * 
     * @param  int    $storyID 
     * @access public
     * @return void
     */
    public function activate($storyID)
    {
        if(!empty($_POST))
        {
            $this->story->activate($storyID);
            if(dao::isError()) die(js::error(dao::getError()));
            $actionID = $this->action->create('story', $storyID, 'Activated', $this->post->comment);
            $this->action->logHistory($actionID, $changes);
            $this->sendMail($storyID, $actionID);
            die(js::locate($this->createLink('story', 'view', "storyID=$storyID"), 'parent'));
        }

        $this->commonAction($storyID);

        /* Assign. */
        $this->view->header->title = $this->view->product->name . $this->lang->colon . $this->lang->story->activate . $this->lang->colon . $this->view->story->title;
        $this->view->position[]    = $this->lang->story->activate;
        $this->display();
    }

    /**
     * View a story.
     * 
     * @param  int    $sqlID
     * @param  int    $version 
     * @access public
     * @return void
     */
    public function view($sqlID, $version = 0)
    {
        $sqlID = (int)$sqlID;
        $sql   = $this->sqlreview->getById($sqlID, $version, true);
        if(!$sql) die(js::error($this->lang->notFound) . js::locate('back'));


        $users        = $this->user->getPairs('noletter');

        /* Set menu. */
        $project = $this->project->getById($sql->project);
        $this->project->setMenu($this->project->getPairs(), $project->id);
        $position[]      = $this->lang->story->view;

        $this->view->position   = $position;

        $this->view->sql      = $sql;
        $this->view->users      = $users;
        $this->view->actions    = $this->action->getList('sqlreview', $sqlID);
        $this->view->preAndNext = $this->loadModel('common')->getPreAndNextObject('story', $sqlID);
        $this->display();
    }

    /**
     * Delete a story.
     * 
     * @param  int    $sqlID
     * @param  string $confirm  yes|no
     * @access public
     * @return void
     */
    public function delete($sqlID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            echo js::confirm($this->lang->sqlreview->confirmDelete, $this->createLink('sqlreview', 'delete', "sql=$sqlID&confirm=yes"), '');
            exit;
        }
        else
        {
            $this->sqlreview->delete(TABLE_SQLREVIEW, $sqlID);
            die(js::locate($this->session->storyList, 'parent'));
        }
    }

    /**
     * Review a story.
     * 
     * @param  int    $sqlID
     * @access public
     * @return void
     */
    public function review($sqlID)
    {
        if(!empty($_POST))
        {
            $this->sqlreview->review($sqlID);
            if(dao::isError()) die(js::error(dao::getError()));
            $result = $this->post->result;
            if($this->post->closedReason != '' and strpos('done,postponed,subdivided', $this->post->closedReason) !== false) $result = 'pass';
            $actionID = $this->action->create('sqlreview', $sqlID, 'Reviewed', $this->post->comment, ucfirst($result));
            $this->action->logHistory($actionID, array());
            $this->sendMail($sqlID, $actionID);
            if($this->post->result == 'reject')
            {
                $this->action->create('story', $sqlID, 'Closed', '', ucfirst($this->post->closedReason));
            }
            die(js::locate(inlink('view', "sqlID=$sqlID"), 'parent'));
        }

        /* Get story and product. */
        $sql   = $this->sqlreview->getById($sqlID);
        $product = $this->dao->findById($sql->product)->from(TABLE_PRODUCT)->fields('name, id')->fetch();



        /* Set the review result options. */
        if($sql->status == 'draft' and $sql->version == 1) unset($this->lang->story->reviewResultList['revert']);
        if($sql->status == 'changed') unset($this->lang->story->reviewResultList['reject']);


        $this->view->product = $product;
        $this->view->sql   = $sql;
        $this->view->actions = $this->action->getList('sqlreview', $sqlID);
        $this->view->users   = $this->loadModel('user')->getPairs('nodeleted');

        /* Get the affcected things. */

        $this->app->loadLang('task');
        $this->app->loadLang('bug');
        $this->app->loadLang('testcase');
        $this->app->loadLang('project');

        $this->display();
    }

    /**
     * Close a story.
     * 
     * @param  int    $sqlID
     * @access public
     * @return void
     */
    public function close($sqlID)
    {
        if(!empty($_POST))
        {
            $changes = $this->sqlreview->close($sqlID);
            if(dao::isError()) die(js::error(dao::getError()));
            $actionID = $this->action->create('story', $sqlID, 'Closed', $this->post->comment, ucfirst($this->post->closedReason));
            $this->action->logHistory($actionID, $changes);
            $this->sendMail($sqlID, $actionID);
            die(js::locate(inlink('view', "sqlID=$sqlID"), 'parent'));
        }

        /* Get story and product. */
        $sql   = $this->sqlreview->getById($sqlID);


        /* Set the closed reason options. */
        if($sql->status == 'draft') unset($this->lang->story->reasonList['cancel']);


        $this->view->sql   = $sql;
        $this->view->actions = $this->action->getList('sqlreview', $sqlID);
        $this->view->users   = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * Batch close story.
     * 
     * @param  string $from productBrowse|projectStory|storyBatchClose
     * @param  int    $productID 
     * @param  int    $projectID 
     * @param  string $orderBy 
     * @access public
     * @return void
     */
    public function batchClose($from = '', $productID = 0, $projectID = 0, $orderBy = '')
    {
        /* Get post data for product-Browse or project-Story. */
        if($from == 'productBrowse' or $from == 'projectStory')
        {
            /* Init vars. */
            $editedStories   = array();
            $storyIDList     = $this->post->storyIDList ? $this->post->storyIDList : array();
            $columns         = 4;
            $showSuhosinInfo = false;

            /* Get all stories. */
            if(!$projectID)
            {
                /* Set menu. */
                $this->product->setMenu($this->product->getPairs('nodeleted'), $productID);
                $allStories = $this->dao->select('*')->from(TABLE_STORY)->where($this->session->storyQueryCondition)->orderBy($orderBy)->fetchAll('id');
            }
            else
            {
                $this->lang->story->menu      = $this->lang->project->menu;
                $this->lang->story->menuOrder = $this->lang->project->menuOrder;
                $this->project->setMenu($this->project->getPairs('nodeleted'), $projectID);
                $this->lang->set('menugroup.story', 'project');
                $allStories = $this->story->getProjectStories($projectID, $orderBy);
            }
            if(!$allStories) $allStories = array();

            /* Initialize the stories whose need to edited. */
            foreach($allStories as $story) if(in_array($story->id, $storyIDList)) $editedStories[$story->id] = $story;

            /* Judge whether the editedStories is too large. */
            $showSuhosinInfo = $this->loadModel('common')->judgeSuhosinSetting(count($editedStories), $columns);

            /* Set the sessions. */
            $this->app->session->set('showSuhosinInfo', $showSuhosinInfo);

            /* Assign. */
            if(!$projectID)
            {
                $product = $this->product->getByID($productID);
                $this->view->header['title'] = $product->name . $this->lang->colon . $this->lang->story->batchClose;
            }
            else
            {
                $project = $this->project->getByID($projectID);
                $this->view->header['title'] = $project->name . $this->lang->colon . $this->lang->story->batchClose;
            }
            if($showSuhosinInfo) $this->view->suhosinInfo = $this->lang->suhosinInfo;
            $this->view->position[]       = $this->lang->story->common;
            $this->view->position[]       = $this->lang->story->batchClose;
            $this->view->users            = $this->loadModel('user')->getPairs('nodeleted');
            $this->view->moduleOptionMenu = $this->tree->getOptionMenu($productID, $viewType = 'story');
            $this->view->plans            = $this->loadModel('productplan')->getPairs($productID);
            $this->view->productID        = $productID;
            $this->view->editedStories    = $editedStories;

            $this->display();
        }
        /* Get post data for story-batchClose. */
        elseif($from == 'storyBatchClose')
        {
            if(!empty($_POST))
            {

                $allChanges = $this->story->batchClose();

                if($allChanges)
                {
                    foreach($allChanges as $storyID => $changes)
                    {
                        $actionID = $this->action->create('story', $storyID, 'Closed', $this->post->comments[$storyID], ucfirst($this->post->closedReasons[$storyID]));
                        $this->action->logHistory($actionID);
                        $this->sendMail($storyID, $actionID);
                    }
                }
            }
            die(js::locate($this->session->storyList, 'parent'));
        }
    }

    /**
     * Tasks of a story.
     * 
     * @param  int    $storyID 
     * @param  int    $projectID 
     * @access public
     * @return void
     */
    public function tasks($storyID, $projectID = 0)
    {
        $this->loadModel('task');
        $this->view->tasks = $this->task->getStoryTaskPairs($storyID, $projectID);
        $this->display();
        exit;
    }

    /**
     * Send mail to dba
     *
     * @param  int    $sqlID
     * @access public
     * @return void
     */
    public function dba($sqlID)
    {
        $sql   = $this->sqlreview->getById($sqlID);
        $me = $this->app->user->account;
        $user_info = $this->loadModel('user')->getById($me);
        if(!empty($_POST))
        {
            $post = fixer::input('post')->get();
            $content = "<p style='color:#f00'>Host：".$post->host_online."<br/>".
                        "DB：".$post->db_online."<br/><br/><br/></p>".
                        nl2br($sql->content);
            $mailContent = $content;
            $assignedTo = implode(",",$post->assignedTo);
            $mailto = $post->mailto;
            $subject = '公网执行sql——'.$sql->title;
            /* Send emails. */
            $this->loadModel('mail')->setReplyTo($user_info->email,$user_info->realname);
            $this->loadModel('mail')->send($assignedTo, $subject, $mailContent, $mailto,true,$user_info->realname);
            if($this->mail->isError()) echo js::error($this->mail->getError());

            echo js::alert("邮件发送成功！");
            die(js::locate($this->createLink('sqlreview', 'view', "sqlID=$sqlID"), 'parent'));
        }

        $members = array('chengjunfeng'=>'程俊峰','xiawenyong'=>'夏文勇');
        $members = array_merge($members,array($me=>$user_info->realname));
        $this->view->members  = $members;
        $mailContent = nl2br($sql->content);
        $this->view->mailContent   = $mailContent;
        $this->view->users    = $this->loadModel('user')->getPairs('noletter');

        $this->display();
    }

    /**
     * AJAX: get stories of a product in html select.
     * 
     * @param  int    $productID 
     * @param  int    $moduleID 
     * @param  int    $storyID 
     * @access public
     * @return void
     */
    public function ajaxGetProductStories($productID, $moduleID = 0, $storyID = 0)
    {
        $stories = $this->story->getProductStoryPairs($productID, $moduleID);
        die(html::select('story', $stories, $storyID, "class=''"));
    }

    /**
     * AJAX: 判断story下面是否有未完成的task.
     *
     * @param  int    $storyID
     * @access public
     * @return void
     */
    public function ajaxGetUnFinishedFlag($storyID = 0){
        $flag = $this->story->getFlagOfUnFinishedTask($storyID);
        die($flag);
    }

    public function ajaxGetFlagOfBacklog($planID = 0){
        $flag = 'allow';
        $plan = $this->loadModel('productplan')->getByID($planID);
        if($plan->isbacklog == '1'){
            $stories = $this->story->getPlanStories($planID,'all','id_desc',null,1);
            if(count($stories) >= 5){
                $flag = 'forbidden';
            }
        }

        die($flag);

    }

    /**
     * Send email.
     * 
     * @param  int    $sqlID
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function sendmail($sqlID, $actionID)
    {
        $sql       = $this->sqlreview->getById($sqlID);
        $projectName = $this->project->getById($sql->project)->name;

        /* Get actions. */
        $action          = $this->action->getById($actionID);
        $history         = $this->action->getHistory($actionID);
        $action->history = isset($history[$actionID]) ? $history[$actionID] : array();
        if(strtolower($action->action) == 'opened') $action->comment = $sql->content;

        /* Set toList and ccList. */
        $toList      = $sql->assignedTo;
        $ccList      = str_replace(' ', '', trim($sql->mailto, ','));

        /* If the action is changed or reviewed, mail to the project team. */
        if(strtolower($action->action) == 'changed' or strtolower($action->action) == 'reviewed')
        {
            $prjMembers = $this->story->getProjectMembers($sql);
            if($prjMembers)
            {
                $ccList .= ',' . join(',', $prjMembers);
                $ccList = ltrim($ccList, ',');
            }
        }

        if($toList == '')
        {
            if($ccList == '') return;
            if(strpos($ccList, ',') === false)
            {
                $toList = $ccList;
                $ccList = '';
            }
            else
            {
                $commaPos = strpos($ccList, ',');
                $toList   = substr($ccList, 0, $commaPos);
                $ccList   = substr($ccList, $commaPos + 1);
            }
        }
        elseif($toList == 'closed')
        {
            $toList = $sql->openedBy;
        }

        /* Get the mail content. */
        if($action->action == 'opened') $action->comment = '';
        $this->view->sql  = $sql;
        $this->view->action = $action;
        $this->view->users  = $this->user->getPairs('noletter');
        $mailContent = $this->parse($this->moduleName, 'sendmail');

        /* Send it. */
        $this->loadModel('mail')->send($toList, $projectName . ':' . 'SQL #' . $sql->id . $this->lang->colon . $sql->title, $mailContent, $ccList);
        if($this->mail->isError()) echo js::error($this->mail->getError());
    }
    /**
     * The report page.
     * 
     * @param  int    $productID 
     * @param  string $browseType 
     * @param  int    $moduleID 
     * @access public
     * @return void
     */
    public function report($productID, $browseType, $moduleID)
    {
        $this->loadModel('report');
        $this->view->charts   = array();
        $this->view->renderJS = '';

        if(!empty($_POST))
        {
            foreach($this->post->charts as $chart)
            {
                $chartFunc   = 'getDataOf' . $chart;
                $chartData   = $this->story->$chartFunc();
                $chartOption = $this->lang->story->report->$chart;
                $this->story->mergeChartOption($chart);

                $chartXML  = $this->report->createSingleXML($chartData, $chartOption->graph);
                $this->view->charts[$chart] = $this->report->createJSChart($chartOption->swf, $chartXML, $chartOption->width, $chartOption->height);
                $this->view->datas[$chart]  = $this->report->computePercent($chartData);
            }
            $this->view->renderJS = $this->report->renderJsCharts(count($this->view->charts));
        }
        $this->products = $this->product->getPairs();
        $this->product->setMenu($this->products, $productID);
        $this->view->header->title = $this->products[$productID] . $this->lang->colon . $this->lang->story->common;
        $this->view->productID     = $productID;
        $this->view->browseType    = $browseType;
        $this->view->moduleID      = $moduleID;
        $this->view->checkedCharts = $this->post->charts ? join(',', $this->post->charts) : '';
        $this->display();
    }
 
    /**
     * get data to export
     * 
     * @param  int $productID 
     * @param  string $orderBy 
     * @access public
     * @return void
     */
    public function export($productID, $orderBy)
    { 
        /* format the fields of every story in order to export data. */
        if($_POST)
        {
            $storyLang   = $this->lang->story;
            $storyConfig = $this->config->story;

            /* Create field lists. */
            $fields = explode(',', $storyConfig->list->exportFields);
            foreach($fields as $key => $fieldName)
            {
                $fieldName = trim($fieldName);
                $fields[$fieldName] = isset($storyLang->$fieldName) ? $storyLang->$fieldName : $fieldName;
                unset($fields[$key]);
            }

            /* Get stories. */
            $stories = $this->dao->select('*')->from(TABLE_STORY)->where($this->session->storyQueryCondition)->orderBy($orderBy)->fetchAll('id', false);

            /* Get users, products and projects. */
            $users    = $this->loadModel('user')->getPairs('noletter');
            $products = $this->loadModel('product')->getPairs();

            /* Get related objects id lists. */
            $relatedModuleIdList = array();
            $relatedStoryIdList  = array();
            $relatedPlanIdList   = array();

            foreach($stories as $story)
            {
                $relatedModuleIdList[$story->module] = $story->module;
                $relatedPlanIdList[$story->plan]     = $story->plan;

                /* Process related stories. */
                $relatedStories = $story->childStories . ',' . $story->linkStories . ',' . $story->duplicateStory;
                $relatedStories = explode(',', $relatedStories);
                foreach($relatedStories as $storyID)
                {
                    if($storyID) $relatedStoryIdList[$storyID] = trim($storyID);
                }
            }

            /* Get related objects title or names. */
            $relatedModules = $this->dao->select('id, name')->from(TABLE_MODULE)->where('id')->in($relatedModuleIdList)->fetchPairs();
            $relatedPlans   = $this->dao->select('id, title')->from(TABLE_PRODUCTPLAN)->where('id')->in($relatedPlanIdList)->fetchPairs();
            $relatedStories = $this->dao->select('id,title')->from(TABLE_STORY) ->where('id')->in($relatedStoryIdList)->fetchPairs();
            $relatedFiles   = $this->dao->select('id, objectID, pathname, title')->from(TABLE_FILE)->where('objectType')->eq('story')->andWhere('objectID')->in(@array_keys($stories))->fetchGroup('objectID');
            $relatedSpecs   = $this->dao->select('*')->from(TABLE_STORYSPEC)->where('`story`')->in(@array_keys($stories))->orderBy('version desc')->fetchGroup('story');

            foreach($stories as $story)
            {
                $story->spec   = '';
                $story->verify = '';
                if(isset($relatedSpecs[$story->id]))
                {
                    $storySpec     = $relatedSpecs[$story->id][0];
                    $story->title  = $storySpec->title;
                    $story->spec   = $storySpec->spec;
                    $story->verify = $storySpec->verify;
                }

                if($this->post->fileType == 'csv')
                {
                    $story->spec = htmlspecialchars_decode($story->spec);
                    $story->spec = str_replace("<br />", "\n", $story->spec);
                    $story->spec = str_replace('"', '""', $story->spec);

                    $story->verify = htmlspecialchars_decode($story->verify);
                    $story->verify = str_replace("<br />", "\n", $story->verify);
                    $story->verify = str_replace('"', '""', $story->verify);
                }
                /* fill some field with useful value. */
                if(isset($products[$story->product]))              $story->product        = $products[$story->product];
                if(isset($relatedModules[$story->module]))         $story->module         = $relatedModules[$story->module];
                if(isset($relatedPlans[$story->plan]))             $story->plan           = $relatedPlans[$story->plan];
                if(isset($relatedStories[$story->duplicateStory])) $story->duplicateStory = $relatedStories[$story->duplicateStory];

                if(isset($storyLang->priList[$story->pri]))             $story->pri          = $storyLang->priList[$story->pri];
                if(isset($storyLang->statusList[$story->status]))       $story->status       = $storyLang->statusList[$story->status];
                if(isset($storyLang->stageList[$story->stage]))         $story->stage        = $storyLang->stageList[$story->stage];
                if(isset($storyLang->reasonList[$story->closedReason])) $story->closedReason = $storyLang->reasonList[$story->closedReason];

                if(isset($users[$story->openedBy]))     $story->openedBy     = $users[$story->openedBy];
                if(isset($users[$story->assignedTo]))   $story->assignedTo   = $users[$story->assignedTo];
                if(isset($users[$story->lastEditedBy])) $story->lastEditedBy = $users[$story->lastEditedBy];
                if(isset($users[$story->closedBy]))     $story->closedBy     = $users[$story->closedBy]; 

                $story->openedDate     = substr($story->openedDate, 0, 10);
                $story->assignedDate   = substr($story->assignedDate, 0, 10);
                $story->lastEditedDate = substr($story->lastEditedDate, 0, 10);
                $story->closedDate     = substr($story->closedDate, 0, 10);


                if($story->linkStories)
                {
                    $tmpLinkStories = array();
                    $linkStoriesIdList = explode(',', $story->linkStories);
                    foreach($linkStoriesIdList as $linkStoryID)
                    {
                        $linkStoryID = trim($linkStoryID);
                        $tmpLinkStories[] = isset($relatedStories[$linkStoryID]) ? $relatedStories[$linkStoryID] : $linkStoryID;
                    }
                    $story->linkStories = join("; \n", $tmpLinkStories);
                }

                if($story->childStories)
                {
                    $tmpChildStories = array();
                    $childStoriesIdList = explode(',', $story->childStories);
                    foreach($childStoriesIdList as $childStoryID)
                    {
                        $childStoryID = trim($childStoryID);
                        $tmpChildStories[] = isset($relatedStories[$childStoryID]) ? $relatedStories[$childStoryID] : $childStoryID;
                    }
                    $story->childStories = join("; \n", $tmpChildStories);
                }

                /* Set related files. */
                if(isset($relatedFiles[$story->id]))
                {
                    foreach($relatedFiles[$story->id] as $file)
                    {
                        $fileURL = 'http://' . $this->server->http_host . $this->config->webRoot . "data/upload/$story->company/" . $file->pathname;
                        $story->files .= html::a($fileURL, $file->title, '_blank') . '<br />';
                    }
                }

                $story->mailto = trim(trim($story->mailto), ',');
                $mailtos = explode(',', $story->mailto);
                $story->mailto = '';
                foreach($mailtos as $mailto)
                {
                    $mailto = trim($mailto);
                    if(isset($users[$mailto])) $story->mailto .= $users[$mailto] . ',';
                }

                $story->reviewedBy = trim(trim($story->reviewedBy), ',');
                $reviewedBys = explode(',', $story->reviewedBy);
                $story->reviewedBy = '';
                foreach($reviewedBys as $reviewedBy)
                {
                    $reviewedBy = trim($reviewedBy);
                    if(isset($users[$reviewedBy])) $story->reviewedBy .= $users[$reviewedBy] . ',';
                }

            }

            $this->post->set('fields', $fields);
            $this->post->set('rows', $stories);
            $this->post->set('kind', 'story');
            $this->fetch('file', 'export2' . $this->post->fileType, $_POST);
        }

        $this->display();
    }
}
