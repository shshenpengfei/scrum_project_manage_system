<?php
/**
 * The control file of task module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     task
 * @version     $Id: control.php 3333 2012-07-09 01:35:36Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
class task extends control
{
    /**
     * Construct function, load model of project and story modules.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('project');
        $this->loadModel('story');
        $this->loadModel('tree');
    }

    /**
     * Create a task.
     * 
     * @param  int    $projectID 
     * @param  int    $storyID 
     * @access public
     * @return void
     */
    public function create($projectID = 0, $storyID = 0, $moduleID = 0)
    {
        $project   = $this->project->getById($projectID); 
        $taskLink  = $this->createLink('project', 'browse', "projectID=$projectID&tab=task");
        $storyLink = $this->session->storyList ? $this->session->storyList : $this->createLink('project', 'story', "projectID=$projectID");
        $this->view->users    = $this->loadModel('user')->getPairs('noletter');
        $story   = $this->story->getById($storyID);
        /* Set menu. */
        $this->project->setMenu($this->project->getPairs(), $project->id);

        if(!empty($_POST))
        {
            $tasksID = $this->task->create($projectID);
            if(dao::isError()) die(js::error(dao::getError()));

            /* Create actions. */
            $this->loadModel('action');
            foreach($tasksID as $taskID)
            {
                $actionID = $this->action->create('task', $taskID, 'Opened', '');
                $this->sendmail($taskID, $actionID);
            }            

            /* Locate the browser. */
            if($this->post->after == 'continueAdding')
            {
                echo js::alert($this->lang->task->successSaved . $this->lang->task->afterChoices['continueAdding']);
                die(js::locate($this->createLink('task', 'create', "projectID=$projectID&storyID={$this->post->story}"), 'parent'));
            }
            elseif($this->post->after == 'toTastList')
            {
                die(js::locate($taskLink, 'parent'));
            }
            elseif($this->post->after == 'toStoryList')
            {
                die(js::locate($storyLink, 'parent'));
            }
        }

        $stories = $this->story->getProjectStoryPairs($projectID);
        $members = $this->project->getTeamMemberPairs($projectID, 'nodeleted');
        $moduleOptionMenu = $this->tree->getOptionMenu($projectID, $viewType = 'task');
        $header['title'] = $project->name . $this->lang->colon . $this->lang->task->create;
        $position[]      = html::a($taskLink, $project->name);
        $position[]      = $this->lang->task->create;
        $this->view->header   = $header;
        $this->view->position = $position;
        $this->view->project  = $project;
        $this->view->stories  = $stories;
        $this->view->storyID  = $storyID;
        $this->view->story  = $story;
        $this->view->members  = $members;
        $this->view->moduleID = $moduleID;
        $this->view->moduleOptionMenu = $moduleOptionMenu;
        $this->display();
    }

    /**
     * Batch create task.
     * 
     * @param  int    $projectID 
     * @param  int    $storyID 
     * @access public
     * @return void
     */
    public function batchCreate($projectID = 0, $storyID = 0)
    {
        $project   = $this->project->getById($projectID); 
        $taskLink  = $this->createLink('project', 'browse', "projectID=$projectID&tab=task");
        $storyLink = $this->session->storyList ? $this->session->storyList : $this->createLink('project', 'story', "projectID=$projectID");
        $this->view->users    = $this->loadModel('user')->getPairs('noletter');

        /* Set menu. */
        $this->project->setMenu($this->project->getPairs(), $project->id);

        if(!empty($_POST))
        {
            $mails = $this->task->batchCreate($projectID);
            if(dao::isError()) die(js::error(dao::getError()));

            foreach($mails as $mail)
            {
                $this->sendmail($mail->taskID, $mail->actionID);
            }            

            /* Locate the browser. */
            die(js::locate($taskLink, 'parent'));
        }

        $stories = $this->story->getProjectStoryPairs($projectID);
        $stories['same'] = $this->lang->task->same;
        $members = $this->project->getTeamMemberPairs($projectID, 'nodeleted');
        $header['title'] = $project->name . $this->lang->colon . $this->lang->task->create;
        $position[]      = html::a($taskLink, $project->name);
        $position[]      = $this->lang->task->create;

        $this->view->header   = $header;
        $this->view->position = $position;
        $this->view->project  = $project;
        $this->view->stories  = $stories;
        $this->view->storyID  = $storyID;
        $this->view->members  = $members;
        $this->display();
    }

    /**
     * Common actions of task module.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function commonAction($taskID)
    {
        $this->view->task    = $this->loadModel('task')->getByID($taskID);
        $this->view->project = $this->project->getById($this->view->task->project);
        $this->view->members = $this->project->getTeamMemberPairs($this->view->project->id ,'nodeleted');
        $this->view->users   = $this->loadModel('user')->getPairs('noletter'); 
        $this->view->actions = $this->loadModel('action')->getList('task', $taskID);

        /* Set menu. */
        $this->project->setMenu($this->project->getPairs(), $this->view->project->id);
        $this->view->position[] = html::a($this->createLink('project', 'browse', "project={$this->view->task->project}"), $this->view->project->name);

    }

    /**
     * Edit a task.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function edit($taskID, $comment = false)
    {
        $this->commonAction($taskID);

        if(!empty($_POST))
        {
            $this->loadModel('action');
            $changes = array();
            $files   = array();
            if($comment == false)
            {
                $changes = $this->task->update($taskID);
                if(dao::isError()) die(js::error(dao::getError()));
                $files = $this->loadModel('file')->saveUpload('task', $taskID);
            }

            $task = $this->task->getById($taskID);
            if($this->post->comment != '' or !empty($changes) or !empty($files))
            {
                $action = !empty($changes) ? 'Edited' : 'Commented';
                $fileAction = '';
                if(!empty($files)) $fileAction = $this->lang->addFiles . join(',', $files) . "\n" ;
                $actionID = $this->action->create('task', $taskID, $action, $fileAction . $this->post->comment);
                $this->action->logHistory($actionID, $changes);
                $this->sendmail($taskID, $actionID);
            }

            if($task->fromBug != 0)
            {
                foreach($changes as $change)
                {
                    if($change['field'] == 'status')
                    {
                        $confirmURL = $this->createLink('bug', 'view', "id=$task->fromBug");
                        $cancelURL  = $this->server->HTTP_REFERER;
                        die(js::confirm(sprintf($this->lang->task->remindBug, $task->fromBug), $confirmURL, $cancelURL, 'parent', 'parent'));
                    }
                }
            }
            die(js::locate($this->createLink('task', 'view', "taskID=$taskID"), 'parent'));
        }

        $this->view->header->title = $this->lang->task->edit;
        $this->view->position[]    = $this->lang->task->edit;
        $this->view->stories       = $this->story->getProjectStoryPairs($this->view->project->id);
        $this->view->members       = $this->loadModel('user')->appendDeleted($this->view->members, $this->view->task->assignedTo);        
        $this->view->modules       = $this->tree->getOptionMenu($this->view->task->project, $viewType = 'task');
        $this->display();
    }

    /**
     * Batch edit task.
     *
     * @param  int    $projectID
     * @param  string $from example:projectTask, taskBatchEdit
     * @param  string $orderBy
     * @access public
     * @return void
     */
    public function batchStandChoose($projectID = 0, $from = '', $orderBy = '')
    {
        /* Get form data for project-task. */
        if($from == 'projectTask')
        {
            /* Initialize vars. */
            if(!$orderBy) $orderBy = $this->cookie->projectTaskOrder ? $this->cookie->projectTaskOrder : 'status,id_desc';
            $project         = $this->project->getById($projectID);
            $taskIDList      = $this->post->taskIDList ? $this->post->taskIDList : array();
            $editedTasks     = array();
            $columns         = 13;
            $showSuhosinInfo = false;

            /* Set project menu. */
            $this->project->setMenu($this->project->getPairs(), $project->id);

            /* Get all tasks. */
            $allTasks = $this->dao->select('*')->from(TABLE_TASK)->alias('t1')->where($this->session->taskQueryCondition)->orderBy($orderBy)->fetchAll('id');
            if(!$allTasks) $allTasks = array();

            /* Initialize the tasks whose need to edited. */
            foreach($allTasks as $task) if(in_array($task->id, $taskIDList)) $editedTasks[$task->id] = $task;

            /* Judge whether the editedTasks is too large. */
            $showSuhosinInfo = $this->loadModel('common')->judgeSuhosinSetting(count($editedTasks), $columns);

            /* Set the sessions. */
            $this->app->session->set('showSuhosinInfo', $showSuhosinInfo);

            /* Assign. */
            $this->view->header['title'] = $project->name . $this->lang->colon . $this->lang->task->batchEdit;
            $this->view->position[] = $this->lang->task->common;
            $this->view->position[] = $this->lang->task->batchEdit;

            if($showSuhosinInfo) $this->view->suhosinInfo = $this->lang->suhosinInfo;
            $this->view->projectID   = $project->id;
            $this->view->editedTasks = $editedTasks;
            $this->view->users       = $this->loadModel('user')->getPairs('noletter');
            $this->view->members     = $this->project->getTeamMemberPairs($projectID, 'nodeleted');

            $this->display();
        }
        /* Get form data for task-batchEdit. */
        elseif($from == 'taskbatchStandChoose')
        {
            $result = $this->task->batchChoose();

            die(js::locate($this->session->taskList, 'parent'));
        }
    }

    /**
     * Batch edit task.
     * 
     * @param  int    $projectID 
     * @param  string $from example:projectTask, taskBatchEdit
     * @param  string $orderBy 
     * @access public
     * @return void
     */
    public function batchEdit($projectID = 0, $from = '', $orderBy = '')
    {
        /* Get form data for project-task. */
        if($from == 'projectTask')
        {
            /* Initialize vars. */
            if(!$orderBy) $orderBy = $this->cookie->projectTaskOrder ? $this->cookie->projectTaskOrder : 'status,id_desc';
            $project         = $this->project->getById($projectID); 
            $taskIDList      = $this->post->taskIDList ? $this->post->taskIDList : array();
            $editedTasks     = array();
            $columns         = 13;
            $showSuhosinInfo = false;

            /* Set project menu. */
            $this->project->setMenu($this->project->getPairs(), $project->id);

            /* Get all tasks. */
            $allTasks = $this->dao->select('*')->from(TABLE_TASK)->alias('t1')->where($this->session->taskQueryCondition)->orderBy($orderBy)->fetchAll('id');
            if(!$allTasks) $allTasks = array();

            /* Initialize the tasks whose need to edited. */
            foreach($allTasks as $task) if(in_array($task->id, $taskIDList)) $editedTasks[$task->id] = $task;

            /* Judge whether the editedTasks is too large. */
            $showSuhosinInfo = $this->loadModel('common')->judgeSuhosinSetting(count($editedTasks), $columns);

            /* Set the sessions. */
            $this->app->session->set('showSuhosinInfo', $showSuhosinInfo);
    
            /* Assign. */
            $this->view->header['title'] = $project->name . $this->lang->colon . $this->lang->task->batchEdit;
            $this->view->position[] = $this->lang->task->common;
            $this->view->position[] = $this->lang->task->batchEdit;

            if($showSuhosinInfo) $this->view->suhosinInfo = $this->lang->suhosinInfo;
            $this->view->projectID   = $project->id;
            $this->view->editedTasks = $editedTasks;
            $this->view->users       = $this->loadModel('user')->getPairs('noletter');
            $this->view->members     = $this->project->getTeamMemberPairs($projectID, 'nodeleted');

            $this->display();
        }
        /* Get form data for task-batchEdit. */
        elseif($from == 'taskBatchEdit')
        {
            $allChanges = $this->task->batchUpdate();

            if(!empty($allChanges))
            {
                foreach($allChanges as $taskID => $changes)
                {
                    if(!empty($changes))
                    {
                        $actionID = $this->loadModel('action')->create('task', $taskID, 'Edited');
                        $this->action->logHistory($actionID, $changes);
                        $this->sendmail($taskID, $actionID);

                        $task = $this->task->getById($taskID);
                        if($task->fromBug != 0)
                        {
                            foreach($changes as $change)
                            {
                                if($change['field'] == 'status')
                                {
                                    $confirmURL = $this->createLink('bug', 'view', "id=$task->fromBug");
                                    $cancelURL  = $this->server->HTTP_REFERER;
                                    die(js::confirm(sprintf($this->lang->task->remindBug, $task->fromBug), $confirmURL, $cancelURL, 'parent', 'parent'));
                                }
                            }
                        }
                    }
                }
            }
            die(js::locate($this->session->taskList, 'parent'));
        }
    }

    /**
     * Update assign of task 
     *
     * @param  int    $requestID
     * @access public
     * @return void
     */
    public function assignTo($projectID, $taskID)
    {
        $this->commonAction($taskID);

        if(!empty($_POST))
        {
            $this->loadModel('action');
            $changes = $this->task->assign($taskID);
            if(dao::isError()) die(js::error(dao::getError()));
            $actionID = $this->action->create('task', $taskID, 'Assigned', $this->post->comment, $this->post->assignedTo);
            $this->action->logHistory($actionID, $changes);
            $this->sendmail($taskID, $actionID);

            die(js::locate($this->createLink('task', 'view', "taskID=$taskID"), 'parent'));
        }

        $this->view->header->title = $this->view->project->name . $this->lang->colon . $this->lang->task->assign;
        $this->view->position[]    = $this->lang->task->assign;

        $this->view->users = $this->project->getTeamMemberPairs($projectID);
        $this->display();
    }

    /**
     * View a task.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function view($taskID)
    {
        $task = $this->task->getById($taskID, true);
        if(!$task) die(js::error($this->lang->notFound) . js::locate('back'));

        /* Set menu. */
        $project = $this->project->getById($task->project);
        $this->project->setMenu($this->project->getPairs(), $project->id);

        $header['title'] = "TASK#$task->id $task->name / $project->name";
        $position[]      = html::a($this->createLink('project', 'browse', "projectID=$task->project"), $project->name);
        $position[]      = $task->name;

        $this->view->header      = $header;
        $this->view->position    = $position;
        $this->view->project     = $project;
        $this->view->task        = $task;
        $this->view->actions     = $this->loadModel('action')->getList('task', $taskID);
        $this->view->users       = $this->loadModel('user')->getPairs('noletter');
        $this->view->preAndNext  = $this->loadModel('common')->getPreAndNextObject('task', $taskID);
        $this->view->modulePath  = $this->tree->getParents($task->module);
        $this->display();
    }

    /**
     * Confirm story change 
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function confirmStoryChange($taskID)
    {
        $task = $this->task->getById($taskID);
        $this->dao->update(TABLE_TASK)->set('storyVersion')->eq($task->latestStoryVersion)->where('id')->eq($taskID)->exec();
        $this->loadModel('action')->create('task', $taskID, 'confirmed', '', $task->latestStoryVersion);
        die(js::reload('parent'));
    }

    /**
     * Start a task.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function start($taskID)
    {
        $this->commonAction($taskID);
        if(!empty($_POST))
        {
            $this->loadModel('action');
            $changes = $this->task->start($taskID);
            if(dao::isError()) die(js::error(dao::getError()));

            if($this->post->comment != '' or !empty($changes))
            {
                $actionID = $this->action->create('task', $taskID, 'Started', $this->post->comment);
                $this->action->logHistory($actionID, $changes);
                $this->sendmail($taskID, $actionID);
            }
            die(js::locate($this->createLink('task', 'view', "taskID=$taskID"), 'parent'));
        }

        $this->view->header->title = $this->view->project->name . $this->lang->colon .$this->lang->task->start;
        $this->view->position[]    = $this->lang->task->start;
        $this->display();
    }
    
    /**
     * Finish a task.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function finish($taskID)
    {
        $this->commonAction($taskID);
        $taskinfo=$this->loadModel('task')->getByID($taskID);
        //如果实际开始时间不为默认空值（如00-00），则进行持续时间的处理。
        if($taskinfo->realStarted !== "0000-00-00 00:00:00"){
            $usedtime=$taskinfo->consumed;
            $his=date('H:i:s',strtotime($taskinfo->realStarted));
            //当时间值默认没有时分秒的时候，不去自动计算上次开始到现在的持续时间。
            if($his == "00:00:00"){
                $continuetime=0;
            }
            else{
                $continuetime=number_format((time()-strtotime($taskinfo->realStarted))/60/60,2);
            }
        }
        else {
            $continuetime=0;
        }
        

        if(!empty($_POST))
        {
            $this->loadModel('action');
            $changes = $this->task->finish($taskID);
            if(dao::isError()) die(js::error(dao::getError()));

            $task = $this->task->getById($taskID);
            if($this->post->comment != '' or !empty($changes))
            {
                $actionID = $this->action->create('task', $taskID, 'Finished', $this->post->comment);
                $this->action->logHistory($actionID, $changes);
                $this->sendmail($taskID, $actionID);
            }

            if($task->fromBug != 0)
            {
                foreach($changes as $change)
                {
                    if($change['field'] == 'status')
                    {
                        $confirmURL = $this->createLink('bug', 'view', "id=$task->fromBug");
                        $cancelURL  = $this->server->HTTP_REFERER;
                        die(js::confirm(sprintf($this->lang->task->remindBug, $task->fromBug), $confirmURL, $cancelURL, 'parent', 'parent'));
                    }
                }
            }
            die(js::locate($this->createLink('task', 'view', "taskID=$taskID"), 'parent'));
        }

        $this->view->header->title = $this->view->project->name . $this->lang->colon .$this->lang->task->finish;
        $this->view->position[]    = $this->lang->task->finish;
        $this->view->continuetime = $continuetime;
        $this->view->date            = strftime("%Y-%m-%d %X", strtotime('now'));
       
        $this->display();
    }

    /**
     * Close a task.
     * 
     * @param  int      $taskID 
     * @access public
     * @return void
     */
    public function close($taskID)
    {
        $this->commonAction($taskID);

        if(!empty($_POST))
        {
            $this->loadModel('action');
            $changes = $this->task->close($taskID);
            if(dao::isError()) die(js::error(dao::getError()));

            if($this->post->comment != '' or !empty($changes))
            {
                $actionID = $this->action->create('task', $taskID, 'Closed', $this->post->comment);
                $this->action->logHistory($actionID, $changes);
                $this->sendmail($taskID, $actionID);
            }
            die(js::locate($this->createLink('task', 'view', "taskID=$taskID"), 'parent'));
        }

        $this->view->header->title = $this->view->project->name . $this->lang->colon .$this->lang->task->finish;
        $this->view->position[]    = $this->lang->task->finish;
        
        $this->display();

    }

    /**
     * Batch close tasks.
     * 
     * @access public
     * @return void
     */
    public function batchClose()
    {
        if($this->post->tasks)
        {
            $tasks = $this->post->tasks;
            unset($_POST['tasks']);
            $this->loadModel('action');

            foreach($tasks as $taskID)
            {
                $this->commonAction($taskID);
                $task = $this->task->getById($taskID);
                if($task->status == 'wait' or $task->status == 'doing') continue;

                $changes = $this->task->close($taskID);

                if($changes)
                {
                    $actionID = $this->action->create('task', $taskID, 'Closed', '');
                    $this->action->logHistory($actionID, $changes);
                    $this->sendmail($taskID, $actionID);
                }
            }
        }
        die(js::reload('parent'));
    }

    /**
     * Cancel a task.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function cancel($taskID)
    {
        $this->commonAction($taskID);

        if(!empty($_POST))
        {
            $this->loadModel('action');
            $changes = $this->task->cancel($taskID);
            if(dao::isError()) die(js::error(dao::getError()));

            if($this->post->comment != '' or !empty($changes))
            {
                $actionID = $this->action->create('task', $taskID, 'Canceled', $this->post->comment);
                $this->action->logHistory($actionID, $changes);
                $this->sendmail($taskID, $actionID);
            }
            die(js::locate($this->createLink('task', 'view', "taskID=$taskID"), 'parent'));
        }

        $this->view->header->title = $this->view->project->name . $this->lang->colon .$this->lang->task->cancel;
        $this->view->position[]    = $this->lang->task->cancel;
        
        $this->display();
    }

    /**
     * Activate a task.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function activate($taskID)
    {
        $this->commonAction($taskID);

        if(!empty($_POST))
        {
            $this->loadModel('action');
            $changes = $this->task->activate($taskID);
            if(dao::isError()) die(js::error(dao::getError()));

            if($this->post->comment != '' or !empty($changes))
            {
                $actionID = $this->action->create('task', $taskID, 'Activated', $this->post->comment);
                $this->action->logHistory($actionID, $changes);
                $this->sendmail($taskID, $actionID);
            }
            die(js::locate($this->createLink('task', 'view', "taskID=$taskID"), 'parent'));
        }

        $this->view->header->title = $this->view->project->name . $this->lang->colon .$this->lang->task->activate;
        $this->view->position[]    = $this->lang->task->activate;
        $this->display();
    }

    /**
     * Delete a task.
     * 
     * @param  int    $projectID 
     * @param  int    $taskID 
     * @param  string $confirm yes|no
     * @access public
     * @return void
     */
    public function delete($projectID, $taskID, $confirm = 'no')
    {
        $task = $this->task->getById($taskID);
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->task->confirmDelete, inlink('delete', "projectID=$projectID&taskID=$taskID&confirm=yes")));
        }
        else
        {
            $story = $this->dao->select('story')->from(TABLE_TASK)->where('id')->eq($taskID)->fetch('story');
            $this->task->delete(TABLE_TASK, $taskID);
            if($task->fromBug != 0) $this->dao->update(TABLE_BUG)->set('toTask')->eq(0)->where('id')->eq($task->fromBug)->exec();
            if($story) $this->loadModel('story')->setStage($story);
            die(js::locate($this->session->taskList, 'parent'));
        }
    }

    /**
     * Send email.
     * 
     * @param  int    $taskID 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function sendmail($taskID, $actionID)
    {
        /* Set toList and ccList. */
        $task        = $this->task->getById($taskID);
        $projectName = $this->project->getById($task->project)->name;
        $toList      = $task->assignedTo;
        $ccList      = trim($task->mailto, ',');

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
                $toList = substr($ccList, 0, $commaPos);
                $ccList = substr($ccList, $commaPos + 1);
            }
        }
        elseif(strtolower($toList) == 'closed')
        {
            $toList = $task->finishedBy;
        }

        /* Get action info. */
        $action          = $this->loadModel('action')->getById($actionID);
        $history         = $this->action->getHistory($actionID);
        $action->history = isset($history[$actionID]) ? $history[$actionID] : array();

        /* Create the email content. */
        $this->view->task   = $task;
        $this->view->action = $action;
        $this->clear();
        $mailContent = $this->parse($this->moduleName, 'sendmail');

        /* Send emails. */
        $this->loadModel('mail')->send($toList, $projectName . ':' . 'TASK#' . $task->id . $this->lang->colon . $task->name, $mailContent, $ccList);
        if($this->mail->isError()) echo js::error($this->mail->getError());
    }
    
    /**
     * AJAX: return tasks of a user in html select. 
     * 
     * @param  string $account 
     * @param  string $id 
     * @param  string $status 
     * @access public
     * @return string
     */
    public function ajaxGetUserTasks($account = '', $id = '', $status = 'wait,doing')
    {
        if($account == '') $account = $this->app->user->account;
        $tasks = $this->task->getUserTaskPairs($account, $status);

        if($id) die(html::select("tasks[$id]", $tasks, '', 'class="select-1 f-left"'));
        die(html::select('task', $tasks, '', 'class=select-1'));
    }

    /**
     * AJAX: return project tasks in html select.
     * 
     * @param  int    $projectID 
     * @param  int    $taskID 
     * @access public
     * @return string
     */
    public function ajaxGetProjectTasks($projectID, $taskID = 0)
    {
        $tasks = $this->task->getProjectTaskPairs((int)$projectID);
        die(html::select('task', $tasks, $taskID));
    }

    /**
     * The report page.
     * 
     * @param  int    $projectID 
     * @param  string $browseType 
     * @access public
     * @return void
     */
    public function report($projectID, $browseType = 'all')
    {
        
        $this->loadModel('report');
        $this->view->charts   = array();
        $this->view->renderJS = '';

        if(!empty($_POST))
        {
            foreach($this->post->charts as $chart)
            {
                $chartFunc   = 'getDataOf' . $chart;
                $chartData   = $this->task->$chartFunc();
                $chartOption = $this->lang->task->report->$chart;
                $this->task->mergeChartOption($chart);

                $chartXML  = $this->report->createSingleXML($chartData, $chartOption->graph);
                $this->view->charts[$chart] = $this->report->createJSChart($chartOption->swf, $chartXML, $chartOption->width, $chartOption->height);
                $this->view->datas[$chart]  = $this->report->computePercent($chartData);
            }
            $this->view->renderJS = $this->report->renderJsCharts(count($this->view->charts));
        }

        $this->project->setMenu($this->project->getPairs(), $projectID);
        $this->projects            = $this->project->getPairs();
        $this->view->header->title = $this->projects[$projectID] . $this->lang->colon . $this->lang->task->report->common;
        $this->view->projectID     = $projectID;
        $this->view->browseType    = $browseType;
        $this->view->checkedCharts = $this->post->charts ? join(',', $this->post->charts) : '';

        $this->display();
    }

    /**
     * get data to export
     * 
     * @param  int $projectID 
     * @param  string $orderBy 
     * @access public
     * @return void
     */
    public function export($projectID, $orderBy)
    {
        if($_POST)
        {
            $taskLang   = $this->lang->task;
            $taskConfig = $this->config->task;

            /* Create field lists. */
            $fields = explode(',', $taskConfig->exportFields);
            foreach($fields as $key => $fieldName)
            {
                $fieldName = trim($fieldName);
                $fields[$fieldName] = isset($taskLang->$fieldName) ? $taskLang->$fieldName : $fieldName;
                unset($fields[$key]);
            }

            /* Get tasks. */
            $tasks = $this->dao->select('*')->from(TABLE_TASK)->alias('t1')->where($this->session->taskQueryCondition)->orderBy($orderBy)->fetchAll('id');

            /* Get users and projects. */
            $users    = $this->loadModel('user')->getPairs('noletter');
            $projects = $this->loadModel('project')->getPairs('all');

            /* Get related objects id lists. */
            $relatedStoryIdList  = array();
            foreach($tasks as $task) $relatedStoryIdList[$task->story] = $task->story;

            /* Get related objects title or names. */
            $relatedStories = $this->dao->select('id,title')->from(TABLE_STORY) ->where('id')->in($relatedStoryIdList)->fetchPairs();
            $relatedFiles   = $this->dao->select('id, objectID, pathname, title')->from(TABLE_FILE)->where('objectType')->eq('task')->andWhere('objectID')->in(@array_keys($tasks))->fetchGroup('objectID');

            foreach($tasks as $task)
            {
                if($this->post->fileType == 'csv')
                {
                    $task->desc = htmlspecialchars_decode($task->desc);
                    $task->desc = str_replace("<br />", "\n", $task->desc);
                    $task->desc = str_replace('"', '""', $task->desc);
                }

                /* fill some field with useful value. */
                $task->story = isset($relatedStories[$task->story]) ? $relatedStories[$task->story] : '';

                if(isset($projects[$task->project]))                  $task->project      = $projects[$task->project];
                if(isset($taskLang->typeList[$task->type]))           $task->type         = $taskLang->typeList[$task->type];
                if(isset($taskLang->priList[$task->pri]))             $task->pri          = $taskLang->priList[$task->pri];
                if(isset($taskLang->statusList[$task->status]))       $task->status       = $taskLang->statusList[$task->status];
                if(isset($taskLang->reasonList[$task->closedReason])) $task->closedReason = $taskLang->reasonList[$task->closedReason];

                if(isset($users[$task->openedBy]))     $task->openedBy     = $users[$task->openedBy];
                if(isset($users[$task->assignedTo]))   $task->assignedTo   = $users[$task->assignedTo];
                if(isset($users[$task->finishedBy]))   $task->finishedBy   = $users[$task->finishedBy];
                if(isset($users[$task->canceledBy]))   $task->canceledBy   = $users[$task->canceledBy];
                if(isset($users[$task->closedBy]))     $task->closedBy     = $users[$task->closedBy];
                if(isset($users[$task->lastEditedBy])) $task->lastEditedBy = $users[$task->lastEditedBy];

                $task->openedDate     = substr($task->openedDate,     0, 10);
                $task->assignedDate   = substr($task->assignedDate,   0, 10);
                $task->finishedDate   = substr($task->finishedDate,   0, 10);
                $task->canceledDate   = substr($task->canceledDate,   0, 10);
                $task->closedDate     = substr($task->closedDate,     0, 10);
                $task->lastEditedDate = substr($task->lastEditedDate, 0, 10);

                /* Set related files. */
                if(isset($relatedFiles[$task->id]))
                {
                    foreach($relatedFiles[$task->id] as $file)
                    {
                        $fileURL = 'http://' . $this->server->http_host . $this->config->webRoot . "data/upload/$task->company/" . $file->pathname;
                        $task->files .= html::a($fileURL, $file->title, '_blank') . '<br />';
                    }
                }
            }

            $this->post->set('fields', $fields);
            $this->post->set('rows', $tasks);
            $this->post->set('kind', 'task');
            $this->fetch('file', 'export2' . $this->post->fileType, $_POST);
        }

        $this->display();
    }

    public function reportday($projectID)
    {
        /* pChart library inclusions */
        include("../p_chart/class/pData.class.php");
        include("../p_chart/class/pDraw.class.php");
        include("../p_chart/class/pImage.class.php");

        //每日剩余
        $where = "project = $projectID AND deleted = '0' AND status NOT IN ( 'cancel','closed') ";
        $tasks_all = $this->task->getTasksByCondition($where);
        $tasks_all_count = count($tasks_all);
        $this->view->tasks_all_count     = $tasks_all_count;

        $where = "project = $projectID AND deleted = '0'";
        $allFinishedDate = $this->task->getAllFinishedDate($where);

        $tasks_un_finished_x = array();
        $tasks_un_finished_y = array();
        foreach(array_reverse($allFinishedDate) as $v){
            $where = "project = $projectID AND deleted = '0' AND status NOT IN ( 'cancel','closed') AND finishedDate <= '$v->date 23:59:59' AND finishedDate != '0000-00-00 00:00:00'";
            $count = $this->task->getUnFinishedTasksPerDay($where,$tasks_all_count);
            $tasks_un_finished_x[] = date('m-d',strtotime($v->date));
            $tasks_un_finished_y[] = $count;
        }

        /* Create and populate the pData object */
        $MyData = new pData();
        $MyData->addPoints($tasks_un_finished_y,"Probe 1");
        $MyData->setSerieWeight("Probe 1",2);
        $MyData->setAxisName(0,"");
        $MyData->addPoints($tasks_un_finished_x,"Labels");
        $MyData->setSerieDescription("Labels","Months");
        $MyData->setAbscissa("Labels");

        /* Create the pChart object */
        $myPicture = new pImage(700,230,$MyData);

        /* Turn of Antialiasing */
        $myPicture->Antialias = FALSE;

        /* Draw the background */
        $Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
        $myPicture->drawFilledRectangle(0,0,700,230,$Settings);

        /* Overlay with a gradient */
        $Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
        $myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,$Settings);
        $myPicture->drawGradientArea(0,0,700,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));

        /* Add a border to the picture */
        $myPicture->drawRectangle(0,0,699,229,array("R"=>0,"G"=>0,"B"=>0));

        /* Write the chart title */
        $myPicture->setFontProperties(array("FontName"=>"../p_chart/fonts/msyh.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
        $myPicture->drawText(10,16,"每日剩余任务数",array("FontSize"=>10,"Align"=>TEXT_ALIGN_BOTTOMLEFT));

        /* Set the default font */
        $myPicture->setFontProperties(array("FontName"=>"../p_chart/fonts/msyh.ttf","FontSize"=>8,"R"=>0,"G"=>0,"B"=>0));

        /* Define the chart area */
        $myPicture->setGraphArea(60,40,650,200);

        /* Draw the scale */
        $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
        $myPicture->drawScale($scaleSettings);

        /* Turn on Antialiasing */
        $myPicture->Antialias = TRUE;

        /* Enable shadow computing */
        $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

        /* Draw the line chart */
        $myPicture->drawLineChart();
        $myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>80));

        /* Write the chart legend */
        $myPicture->drawLegend(590,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));

        /* Render the picture (choose the best way) */
        $myPicture->autoOutput();

        $img = $myPicture->base64("output.png");
        $this->view->src_line     = $img;

        //每位成员剩余
        $where = "project = $projectID AND deleted = '0' AND (status = 'wait' OR status = 'doing') AND assignedTo !='' ";
        $tasks_un_finished_per_member = $this->task->getUnFinishedTasksPerAssignedTo($where);
        $tasks_un_finished_member_x = array();
        $tasks_un_finished_member_y = array();
        foreach($tasks_un_finished_per_member as $v){
            $tasks_un_finished_member_x[] = $v->value;
            $tasks_un_finished_member_y[] = $v->name;
        }

        /* Create and populate the pData object */
        $MyData = new pData();
        $MyData->addPoints($tasks_un_finished_member_x,"Hits");
        $MyData->setAxisName(0,"剩余任务数");
        $MyData->addPoints($tasks_un_finished_member_y,"Browsers");
        $MyData->setSerieDescription("Browsers","Browsers");
        $MyData->setAbscissa("Browsers");
        //$MyData->setAbscissaName("Browsers");

        /* Create the pChart object */
        $myPicture = new pImage(500,500,$MyData);
        $myPicture->drawGradientArea(0,0,500,500,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
        $myPicture->drawGradientArea(0,0,500,500,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
        $myPicture->setFontProperties(array("FontName"=>"../p_chart/fonts/msyh.ttf","FontSize"=>8));

        /* Draw the chart scale */
        $myPicture->setGraphArea(100,30,480,480);
        $myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Pos"=>SCALE_POS_TOPBOTTOM));

        /* Turn on shadow computing */
        $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

        /* Create the per bar palette */
        $Palette = array("0"=>array("R"=>188,"G"=>224,"B"=>46,"Alpha"=>100),
            "1"=>array("R"=>224,"G"=>100,"B"=>46,"Alpha"=>100),
            "2"=>array("R"=>224,"G"=>214,"B"=>46,"Alpha"=>100),
            "3"=>array("R"=>46,"G"=>151,"B"=>224,"Alpha"=>100),
            "4"=>array("R"=>176,"G"=>46,"B"=>224,"Alpha"=>100),
            "5"=>array("R"=>224,"G"=>46,"B"=>117,"Alpha"=>100),
            "6"=>array("R"=>92,"G"=>224,"B"=>46,"Alpha"=>100),
            "7"=>array("R"=>224,"G"=>176,"B"=>46,"Alpha"=>100));

        /* Draw the chart */
        $myPicture->drawBarChart(array("DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"Rounded"=>TRUE,"Surrounding"=>30,"OverrideColors"=>$Palette));

        /* Write the legend */
        $myPicture->drawLegend(570,215,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

        /* Render the picture (choose the best way) */
        $myPicture->autoOutput();

        $img = $myPicture->base64("output.png");
        $this->view->src_bar     = $img;

        $project_info = $this->loadModel('project')->getById($projectID);
        $this->view->project_info     = $project_info;

        //今日完成
        $where = "project = $projectID AND deleted = '0' AND status = 'done' AND DATE_FORMAT(finishedDate,'%Y-%m-%d') = '".date('Y-m-d')."'";
        $tasks_done_today = $this->task->getTasksByCondition($where);
        $this->view->tasks_done_today     = $tasks_done_today;

        //今日新增
        $where = "project = $projectID AND deleted = '0' AND DATE_FORMAT(openedDate,'%Y-%m-%d') = '".date('Y-m-d')."'";
        $tasks_opened_today = $this->task->getTasksByCondition($where);
        $this->view->tasks_opened_today     = $tasks_opened_today;

        //未完成(迭代期)
        $where = "project = $projectID AND deleted = '0' AND (status = 'wait' OR status = 'doing')";
        $tasks_un_finished = $this->task->getTasksByCondition($where);
        $this->view->tasks_un_finished     = $tasks_un_finished;

        $this->display($this->moduleName,'reportday');
    }

    public function reportToMail($projectID)
    {
        $project   = $this->project->getById($projectID);
        if(!empty($_POST))
        {
            $post = fixer::input('post')->get();
            $mailContent = $this->fetch($this->moduleName, 'reportday', array($projectID));
            $assignedTo = implode(",",$post->assignedTo);
            $mailto = $post->mailto;
            $subject = date("Y年m月d日")."—【".$project->name."】进度统计报表";
            /* Send emails. */
            $this->loadModel('mail')->send($assignedTo, $subject, $mailContent, $mailto,true);
            if($this->mail->isError()) echo js::error($this->mail->getError());



            echo js::alert("邮件发送成功！");
            die(js::locate($this->createLink('project', 'task', "projectID=$projectID"), 'parent'));
        }

        $mailContent = $this->fetch($this->moduleName, 'reportday', array($projectID));
        $this->view->mailContent   = $mailContent;
        $this->view->users    = $this->loadModel('user')->getPairs('noletter');

        $members = $this->project->getTeamMemberPairs($projectID, 'nodeleted');
        unset($members['']);
        $this->view->members  = $members;

        $this->display();
    }

    public function reportweekly($account, $begin, $end, $begin_next, $end_next){
        //自己本周完成的task
        $tasks_me = $this->loadModel('task')->getUserFinishedTasks($account, $begin.' 00:00:00', $end.' 23:59:59');
        //自己截止日期在本周，但是未完成的task
        $tasks_undone_me = $this->loadModel('task')->getUserBeyondDeadlineTasks($account, $begin, $end);
        //自己本周解决的bug
        $bugs_me = $this->loadModel('bug')->getUserResolvedBugs($account, $begin.' 00:00:00', $end.' 23:59:59');
        //自己还未解决的bug
        $bugs_undone_me = $this->loadModel('bug')->getUserUnclosedBugs($account);
        //自己本周的todo
        $todo_me = $this->loadModel('todo')->getList('range', $account, 'all', 0, null, $begin.'*'.$end);
        //自己下周的plan
        $plan_me = $this->loadModel('todo')->getList('range', $account, 'all', 0, null, $begin_next.'*'.$end_next, 'plan');

        $this->view->tasks_undone_me  = $tasks_undone_me;
        $this->view->tasks_me  = $tasks_me;
        $this->view->bugs_me  = $bugs_me;
        $this->view->bugs_undone_me  = $bugs_undone_me;
        $this->view->todo_me  = $todo_me;
        $this->view->plan_me  = $plan_me;

        $tasks_guys = array();
        $tasks_undone_guys = array();
        $bugs_guys = array();
        $bugs_undone_guys = array();
        $todo_guys = array();
        $plan_guys = array();
        $user_info = $this->loadModel('user')->getById($account);
        if($user_info->position == 'leader' || $user_info->position == 'director'){
            $childDeptIds = $this->loadModel('dept')->getAllChildID($user_info->dept);
            $guys = array();
            $guys_list = $this->dept->getUsers($childDeptIds);
            foreach($guys_list as $g){
                $guys[$g->account] = $g->account;
            }
            unset($guys[$account]);
            foreach($guys as $guy){
                $tasks_guys[] = $this->loadModel('task')->getUserFinishedTasks($guy, $begin.' 00:00:00', $end.' 23:59:59');
                $tasks_undone_guys[] = $this->loadModel('task')->getUserBeyondDeadlineTasks($guy, $begin, $end);
                $bugs_guys[] = $this->loadModel('bug')->getUserResolvedBugs($guy, $begin.' 00:00:00', $end.' 23:59:59');
                $bugs_undone_guys[] = $this->loadModel('bug')->getUserUnclosedBugs($guy);
                $todo_guys[] = $this->loadModel('todo')->getList('range', $guy, 'all', 0, null, $begin.'*'.$end);
                $plan_guys[] = $this->loadModel('todo')->getList('range', $guy, 'all', 0, null, $begin_next.'*'.$end_next, 'plan');
            }
        }

        //组员的项目任务和计划外任务
        $this->view->tasks_undone_guys  = $tasks_undone_guys;
        $this->view->tasks_guys  = $tasks_guys;
        $this->view->bugs_guys  = $bugs_guys;
        $this->view->bugs_undone_guys  = $bugs_undone_guys;
        $this->view->todo_guys  = $todo_guys;
        $this->view->plan_guys  = $plan_guys;

        $this->view->begin  = $begin;
        $this->view->end  = $end;

        $this->view->user_info  = $user_info;
        $this->display('task','reportweekly');

    }

}
