<?php
/**
 * The model file of report module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     report
 * @version     $Id: model.php 3358 2012-07-16 08:01:15Z zhujinyonging@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php
class reportModel extends model
{
    /**
     * Create the html code of chart.
     * 
     * @param  string $swf      the swf type
     * @param  string $dataURL  the date url
     * @param  int    $width 
     * @param  int    $height 
     * @access public
     * @return string
     */
    public function createChart($swf, $dataURL, $width = 800, $height = 500)
    {
        $chartRoot = $this->app->getWebRoot() . 'fusioncharts/';
        $swfFile   = "fcf_$swf.swf";
        return <<<EOT
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="$width" height="$height" id="fcf$swf" >
<param name="movie"     value="$chartRoot$swfFile" />
<param name="FlashVars" value="&dataURL=$dataURL&chartWidth=$width&chartHeight=$height">
<param name="quality"   value="high" />
<param name="wmode"     value="Opaque">
<embed src="$chartRoot$swfFile" flashVars="&dataURL=$dataURL&chartWidth=$width&chartHeight=$height" quality="high" wmode="Opaque" width="$width" height="$height" name="fcf$swf" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
EOT;
    }

    /**
     * Create the js code of chart.
     * 
     * @param  string $swf      the swf type
     * @param  string $dataURL  the date url
     * @param  int    $width 
     * @param  int    $height 
     * @access public
     * @return string
     */
    public function createJSChart($swf, $dataXML, $width = 'auto', $height = 500)
    {
        $jsRoot = $this->app->getWebRoot() . 'js/';
        static $count = 0;
        $count ++;
        $chartRoot = $this->app->getWebRoot() . 'fusioncharts/';
        $swfFile   = "fcf_$swf.swf";
        $divID     = "chart{$count}div";
        $chartID   = "chart{$count}";

        $js = '';
        if($count == 1) $js = "<script language='Javascript' src='{$jsRoot}misc/fusioncharts.js'></script>";
        return <<<EOT
$js
<div id="$divID" class='chartDiv'></div>
<script language="JavaScript"> 
function createChart$count()
{
chartWidth = "$width";
if(chartWidth == 'auto') chartWidth = $('#$divID').width() - 10;
if(chartWidth < 300) chartWidth = 300;
var $chartID = new FusionCharts("$chartRoot$swfFile", "{$chartID}id", chartWidth, "$height"); 
$chartID.setDataXML("$dataXML");
$chartID.render("$divID");
}
</script>
EOT;
    }

    public function createJSChartFlot($projectName, $dataJSON, $count, $width = 'auto', $height = 500)
    {
        $this->app->loadLang('project');
        $jsRoot = $this->app->getWebRoot() . 'js/';
        $width  = $width . 'px';
        $height = $height . 'px';
return <<<EOT
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="{$jsRoot}jquery/flot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="{$jsRoot}jquery/flot/jquery.flot.min.js"></script>
<h1>$projectName  {$this->lang->project->burn}</h1>
<div id="placeholder" style="width:$width;height:$height;margin:0 auto"></div>
<script type="text/javascript">
$(function () 
{
    var data = [{data: $dataJSON}];
    function showTooltip(x, y, contents) 
    {
        $('<div id="tooltip">' + contents + '</div>').css
        ({
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    } 
    if($count < 20)
    {
        var options = {
            series: {lines:{show: true,  lineWidth: 2}, points: {show: true},hoverable: true},
            legend: {noColumns: 1},
            grid: { hoverable: true, clickable: true },
            xaxis: {mode: "time", timeformat: "%m-%d", tickSize:[1, "day"]},
            yaxis: {mode: null, min: 0, minTickSize: [1, "day"]}};
    }
    else
    {
        var options = {
            series: {lines:{show: true,  lineWidth: 2}, points: {show: true},hoverable: true},
            legend: {noColumns: 1},
            grid: { hoverable: true, clickable: true },
            xaxis: {mode: "time", timeformat: "%m-%d", ticks:20, minTickSize:[1, "day"]},
            yaxis: {mode: null, min: 0, minTickSize: [1, "day"]}};
    }
    var placeholder = $("#placeholder");

    placeholder.bind("plotselected", function (event, ranges) 
    {
        plot = $.plot(placeholder, data, $.extend(true, {}, options, {xaxis: { min: ranges.xaxis.from, max: ranges.xaxis.to } }));
    });
    var plot = $.plot(placeholder, data, options);
    var previousPoint = null;
    $("#placeholder").bind("plothover", function (event, pos, item) 
    {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));

        if (item) 
        {
            if (previousPoint != item.dataIndex)    
            {
                previousPoint = item.dataIndex;

                $("#tooltip").remove();
                var x = item.datapoint[0].toFixed(2), y = item.datapoint[1].toFixed(2);

                showTooltip(item.pageX, item.pageY, y);
            }
        }
    });
});
</script>
EOT;
    }

    /**
     * Create xml data of single charts.
     * 
     * @param  array  $sets 
     * @param  array  $chartOptions 
     * @param  array  $colors 
     * @access public
     * @return string the xml data.
     */
    public function createSingleXML($sets, $chartOptions = array(), $colors = array())
    {
        $data  = pack("CCC", 0xef, 0xbb, 0xbf); // utf-8 bom.
        $data .="<?xml version='1.0' encoding='UTF-8'?>";

        $data .= '<graph';
        foreach($chartOptions as $key => $value) $data .= " $key='$value'";
        $data .= ">";

        if(empty($colors)) $colors = $this->lang->report->colors;
        $colorCount = count($colors);
        $i = 0;
        foreach($sets as $set)
        {
            if($i == $colorCount) $i = 0;
            $color = $colors[$i];
            $i ++;
            $data .= "<set name='$set->name' value='$set->value' color='$color' />";
        }
        $data .= "</graph>";
        return $data;
    }

    public function createSingleJSON($sets)
    {
        $data = '[';
        foreach($sets as $set)
        {
            $data .= " [$set->name, $set->value],";
        }
        $data = rtrim($data, ',');
        $data .= ']';
        return $data;
    }

    /**
     * Create the js code to render chart.
     * 
     * @param  int    $chartCount 
     * @access public
     * @return string
     */
    public function renderJsCharts($chartCount)
    {
        $js = '<script language="Javascript">';
        for($i = 1; $i <= $chartCount; $i ++) $js .= "createChart$i()\n";
        $js .= '</script>';
        return $js;
    }

    /**
     * Compute percent of every item.
     * 
     * @param  array    $datas 
     * @access public
     * @return array
     */
    public function computePercent($datas)
    {
        $sum = 0;
        foreach($datas as $data) $sum += $data->value;
        foreach($datas as $data) $data->percent = round($data->value / $sum, 2);
        return $datas;
    }

    /**
     * Get projects. 
     * 
     * @access public
     * @return void
     */
    public function getProjects()
    {
        $projects = array();

        $tasks = $this->dao->select('t1.*')
            ->from(TABLE_TASK)->alias('t1')
            ->leftJoin(TABLE_PROJECT)->alias('t2')
            ->on('t1.project = t2.id')
            ->where('t1.status')->ne('cancel')
            ->andWhere('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->fetchAll();
        foreach($tasks as $task)
        {
            $projects[$task->project]->estimate = isset($projects[$task->project]->estimate) ? $projects[$task->project]->estimate + $task->estimate : $task->estimate;
            $projects[$task->project]->consumed = isset($projects[$task->project]->consumed) ? $projects[$task->project]->consumed + $task->consumed : $task->consumed;
            $projects[$task->project]->tasks    = isset($projects[$task->project]->tasks)    ? $projects[$task->project]->tasks + 1 : 1;
            if($task->type == 'devel') $projects[$task->project]->devConsumed  = isset($projects[$task->project]->devConsumed) ? $projects[$task->project]->devConsumed + $task->consumed : $task->consumed;
            if($task->type == 'test')  $projects[$task->project]->testConsumed = isset($projects[$task->project]->testConsumed) ? $projects[$task->project]->testConsumed + $task->consumed : $task->consumed;
        }

        $bugs = $this->dao->select('t1.project')
            ->from(TABLE_BUG)->alias('t1')
            ->leftJoin(TABLE_PROJECT)->alias('t2')
            ->on('t1.project = t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->fetchAll();
        foreach($bugs as $bug)
        {
            if($bug->project)
            {
                $projects[$bug->project]->bugs = isset($projects[$bug->project]->bugs) ? $projects[$bug->project]->bugs + 1 : 1;
            }
        }

        $stories = $this->dao->select('t1.project')
            ->from(TABLE_PROJECTSTORY)->alias('t1')
            ->leftJoin(TABLE_PROJECT)->alias('t2')
            ->on('t1.project = t2.id')
            ->leftJoin(TABLE_STORY)->alias('t3')
            ->on('t1.story = t3.id')
            ->where('t2.deleted')->eq(0)
            ->andWhere('t3.deleted')->eq(0)
            ->fetchAll();
        foreach($stories as $story)
        {
            $projects[$story->project]->stories = isset($projects[$story->project]->stories) ? $projects[$story->project]->stories + 1 : 1;
        }

        $projectPairs = $this->loadModel('project')->getPairs();
        foreach($projects as $id => $project)
        {
            if(!isset($project->stories)) $projects[$id]->stories = 0;
            if(!isset($project->bugs)) $projects[$id]->bugs = 0;
            if(!isset($project->devConsumed)) $projects[$id]->devConsumed = 0;
            if(!isset($project->testConsumed)) $projects[$id]->testConsumed = 0;
            if(!isset($project->consumed)) $projects[$id]->consumed = 0;
            if(!isset($project->estimate)) $projects[$id]->estimate = 0;
            $projects[$id]->name = $projectPairs[$id];
        }
        return $projects;
    }

    /**
     * Get products. 
     * 
     * @access public
     * @return array 
     */
    public function getProducts()
    {
        $products    = $this->dao->select('id, code, name, PO')->from(TABLE_PRODUCT)->where('deleted')->eq(0)->fetchAll('id');
        $plans       = $this->dao->select('*')->from(TABLE_PRODUCTPLAN)->where('deleted')->eq(0)->andWhere('product')->in(array_keys($products))->fetchAll('id');
        $planStories = $this->dao->select('plan, id, status')->from(TABLE_STORY)->where('deleted')->eq(0)->andWhere('plan')->in(array_keys($plans))->fetchGroup('plan', 'id');
        foreach($plans as $plan)
        {
            $products[$plan->product]->plans[$plan->id]->title = $plan->title;
            $products[$plan->product]->plans[$plan->id]->desc  = $plan->desc;
            $products[$plan->product]->plans[$plan->id]->begin = $plan->begin;
            $products[$plan->product]->plans[$plan->id]->end   = $plan->end;
        }
        foreach($planStories as $planID => $stories)
        {
            foreach($stories as $story)
            {
                $plan = $plans[$story->plan];
                $products[$plan->product]->plans[$story->plan]->status[$story->status] = isset($products[$plan->product]->plans[$story->plan]->status[$story->status]) ? $products[$plan->product]->plans[$story->plan]->status[$story->status] + 1 : 1;
            }
        }
        return $products;
    }

    /**
     * Get bugs 
     * 
     * @param  int    $begin 
     * @param  int    $end 
     * @access public
     * @return array
     */
    public function getBugs($begin, $end)
    {
        $end = date('Ymd', strtotime("$end +1 day"));
        $bugs = $this->dao->select('id, resolution, openedBy')->from(TABLE_BUG)
            ->where('deleted')->eq(0)
            ->andWhere('openedDate')->ge($begin)
            ->andWhere('openedDate')->le($end)
            ->fetchAll();
        $bugSummary = array();
        foreach($bugs as $bug)
        {
            $bugSummary[$bug->openedBy][$bug->resolution] = empty($bugSummary[$bug->openedBy][$bug->resolution]) ? 1 : $bugSummary[$bug->openedBy][$bug->resolution] + 1;
            $bugSummary[$bug->openedBy]['all'] = empty($bugSummary[$bug->openedBy]['all']) ? 1 : $bugSummary[$bug->openedBy]['all'] + 1;
        }
        return $bugSummary; 
    }

    /**
     * Get workload. 
     * 
     * @access public
     * @return array
     */
    public function getWorkload()
    {
        $tasks = $this->dao->select('t1.*, t2.name as projectName')
            ->from(TABLE_TASK)->alias('t1')
            ->leftJoin(TABLE_PROJECT)->alias('t2')
            ->on('t1.project = t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t1.status')->notin('cancel, closed, done')
            ->fetchGroup('assignedTo');
        $bugs = $this->dao->select('t1.*, t2.name as productName')
            ->from(TABLE_BUG)->alias('t1')
            ->leftJoin(TABLE_PRODUCT)->alias('t2')
            ->on('t1.product = t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t1.status')->eq('active')
            ->fetchGroup('assignedTo');
        $workload = array();
        foreach($tasks as $user => $userTasks)
        {
            if($user)
            {
                foreach($userTasks as $task)
                {
                    $workload[$user]['task'][$task->projectName]['count']   = isset($workload[$user]['task'][$task->projectName]['count']) ? $workload[$user]['task'][$task->projectName]['count'] + 1 : 1;
                    $workload[$user]['task'][$task->projectName]['manhour'] = isset($workload[$user]['task'][$task->projectName]['manhour']) ? $workload[$user]['task'][$task->projectName]['manhour'] + $task->left : $task->left;
                    $workload[$user]['total']['task']['count']   = isset($workload[$user]['total']['task']['count']) ? $workload[$user]['total']['task']['count'] + 1 : 1;
                    $workload[$user]['total']['task']['manhour'] = isset($workload[$user]['total']['task']['manhour']) ? $workload[$user]['total']['task']['manhour'] + $task->left : $task->left;
                }
            }
        }
        foreach($bugs as $user => $userBugs)
        {
            if($user)
            {
                foreach($userBugs as $bug)
                {
                    $workload[$user]['bug'][$bug->productName]['count'] = isset($workload[$user]['bug'][$bug->productName]['count']) ? $workload[$user]['bug'][$bug->productName]['count'] + 1 : 1;
                    $workload[$user]['total']['bug']['count']   = isset($workload[$user]['total']['bug']['count']) ? $workload[$user]['total']['bug']['count'] + 1 : 1;
                }
            }
        }
        unset($workload['closed']);
        return $workload;
    }

    public function getProject(){
        $projects[-1] = '全部项目';
        $projects[0] = '无关联项目';
        $project = $this->dao->select('*')->from(TABLE_PROJECT)
            ->fetchAll();
        foreach($project as $p){
            $projects[$p->id] = $p->name;
        }
        return $projects;
    }

    public function getDelayStory($begin, $end, $project){
        $delays = $this->dao->select('*')->from(TABLE_DELAYSTORY)
            ->where('delayDate')->ge($begin)
            ->andWhere('delayDate')->le($end)
            ->beginIF($project >= 0)->andWhere('project')->eq($project)->fi()
            ->orderBy('delayDate DESC')
            ->fetchAll();
        foreach($delays as $k=>$v){
            $story = $this->dao->findById((int)$v->story)->from(TABLE_STORY)->fetch();
            $delays[$k]->current_stage = $story->stage;
            $delays[$k]->current_status = $story->status;
        }
        return $delays;
    }

    public function getDelayTask($begin, $end, $project){
        $delays = $this->dao->select('*')->from(TABLE_DELAYTASK)
            ->where('delayDate')->ge($begin)
            ->andWhere('delayDate')->le($end)
            ->beginIF($project >= 0)->andWhere('project')->eq($project)->fi()
            ->orderBy('delayDate DESC')
            ->fetchAll();
        foreach($delays as $k=>$v){
            $story = $this->dao->findById((int)$v->task)->from(TABLE_TASK)->fetch();
            $delays[$k]->current_status = $story->status;
            $delays[$k]->current_deleted = $story->deleted;

        }
        return $delays;
    }


    /** 获取用户的每日数据*/
    public function getUserDayData($uid,$begin, $end){
        $worklist = $this->dao->select('sum(worktime) as sumtime,workday')->from(TABLE_CHECK)
            ->where('id')->eq($uid)->groupBy('workday')->orderBy('pkid asc')->fetchAll();
        $sumtime_arr=array();
        $workday_arr=array();

        foreach($worklist as $k=>$v){
            $sumtime_arr[]=doubleval($v->sumtime);
            $workday_arr[]=$v->workday;
        }


        $result=array('sumtime'=>$sumtime_arr,'workday'=>$workday_arr);

        return $result;
    }

    public function getCharDataForDelayStory($begin, $end){
        $projects = $this->dao->select('project')->from(TABLE_DELAYSTORY)
            ->where('delayDate')->ge($begin)
            ->andWhere('delayDate')->le($end)
            ->groupBy('project')
            ->fetchAll();

        $days = $this->dao->select('delayDate')->from(TABLE_DELAYSTORY)
            ->where('delayDate')->ge($begin)
            ->andWhere('delayDate')->le($end)
            ->groupBy('delayDate')
            ->fetchAll();

        $day_list = array();
        $project_list = array();
        foreach($projects as $p){
            $list_a = array();
            $list = array();
            foreach($days as $d){
                $story = $this->dao->select('COUNT(*) AS story_sum')->from(TABLE_DELAYSTORY)
                    ->where('delayDate')->eq($d->delayDate)
                    ->andWhere('project')->eq($p->project)
                    ->fetch();
                $list[] = intval($story->story_sum);
            }
            if($p->project){$name = $project->name;
            }
            else{
                $name = '无关联项目';
            }
            $list_a['name'] = $name;
            $list_a['data'] = $list;
            $project_list[] = $list_a;
        }

        foreach($days as $d){
            $day_list[] = $d->delayDate;
        }

        $char_data['category'] = $day_list;
        $char_data['series'] = $project_list;


        $assignedTo = $this->dao->select('assignedTo')->from(TABLE_DELAYSTORY)
            ->where('delayDate')->ge($begin)
            ->andWhere('delayDate')->le($end)
            ->groupBy('assignedTo')
            ->fetchAll();

        $assigned_list = array();
        $story_list = array();
        foreach($assignedTo as $a){
            $story = $this->dao->select('COUNT(*) AS story_sum')->from(TABLE_DELAYSTORY)
                ->where('assignedTo')->eq($a->assignedTo)
                ->andWhere('delayDate')->ge($begin)
                ->andWhere('delayDate')->le($end)
                ->fetch();
            $story_list[] = intval($story->story_sum);
            $name = $a->assignedTo ? $this->loadModel('task')->getRealNameByAccount($a->assignedTo) : '未指派';
            $assigned_list[] = $name;
        }

        $char_data['category_2'] = $assigned_list;
        $char_data['series_2'] = $story_list;

        return $char_data;
    }

    public function getCharDataForDelayTask($begin, $end){
        $projects = $this->dao->select('project')->from(TABLE_DELAYTASK)
            ->where('delayDate')->ge($begin)
            ->andWhere('delayDate')->le($end)
            ->groupBy('project')
            ->fetchAll();

        $assign = $this->dao->select('assignedTo')->from(TABLE_DELAYTASK)
            ->where('delayDate')->ge($begin)
            ->andWhere('delayDate')->le($end)
            ->groupBy('assignedTo')
            ->fetchAll();

        $days = $this->dao->select('delayDate')->from(TABLE_DELAYTASK)
            ->where('delayDate')->ge($begin)
            ->andWhere('delayDate')->le($end)
            ->groupBy('delayDate')
            ->fetchAll();

        $project_list = array();
        foreach($projects as $p){
            $list_a = array();
            $list = array();
            foreach($days as $d){
                $task = $this->dao->select('COUNT(*) AS task_sum')->from(TABLE_DELAYTASK)
                    ->where('delayDate')->eq($d->delayDate)
                    ->andWhere('project')->eq($p->project)
                    ->fetch();
                $list[] = intval($task->task_sum);
            }
            if($p->project){
                $project = $this->dao->findById((int)$p->project)->from(TABLE_PROJECT)->fetch();
                $name = $project->name;
            }
            else{
                $name = '无关联项目';
            }
            $list_a['name'] = $name;
            $list_a['data'] = $list;
            $project_list[] = $list_a;
        }

        $assign_list = array();
        foreach($assign as $a){
            $list_a = array();
            $list = array();
            foreach($days as $d){
                $task = $this->dao->select('COUNT(*) AS task_sum')->from(TABLE_DELAYTASK)
                    ->where('delayDate')->eq($d->delayDate)
                    ->andWhere('assignedTo')->eq($a->assignedTo)
                    ->fetch();
                $list[] = intval($task->task_sum);
            }

            $name = $this->loadModel('task')->getRealNameByAccount($a->assignedTo);
            $list_a['name'] = $name;
            $list_a['data'] = $list;
            $assign_list[] = $list_a;
        }

        $day_list = array();
        foreach($days as $d){
            $day_list[] = $d->delayDate;
        }

        $char_data['category'] = $day_list;
        $char_data['series'] = $project_list;
        $char_data['series_1'] = $assign_list;

        $assignedTo = $this->dao->select('assignedTo')->from(TABLE_DELAYTASK)
            ->where('delayDate')->ge($begin)
            ->andWhere('delayDate')->le($end)
            ->groupBy('assignedTo')
            ->fetchAll();

        $assigned_list = array();
        $task_list = array();
        foreach($assignedTo as $a){
            $task = $this->dao->select('COUNT(*) AS task_sum')->from(TABLE_DELAYTASK)
                ->where('assignedTo')->eq($a->assignedTo)
                ->andWhere('delayDate')->ge($begin)
                ->andWhere('delayDate')->le($end)
                ->fetch();
            $task_list[] = intval($task->task_sum);
            $name = $a->assignedTo ? $this->loadModel('task')->getRealNameByAccount($a->assignedTo) : '未指派';
            $assigned_list[] = $name;
        }

        $char_data['category_2'] = $assigned_list;
        $char_data['series_2'] = $task_list;

        return $char_data;
    }


}
