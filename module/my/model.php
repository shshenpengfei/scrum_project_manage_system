<?php
/**
 * The model file of dashboard module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dashboard
 * @version     $Id: model.php 2605 2012-02-21 07:22:58Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php
class myModel extends model
{
    /**
     * Set menu.
     * 
     * @access public
     * @return void
     */
    public function setMenu()
    {
        $this->lang->my->menu->account = sprintf($this->lang->my->menu->account, $this->app->user->realname);
    }


    public function myworktime($userid=null,$pager = null){
            $uid=is_null($userid)?$this->app->user->id:$userid;
            $myworktimelist = $this->dao->select('*')
                ->from(TABLE_CHECK)
                ->where('id')->eq($uid)->orderBy('pkid desc')->page($pager)->fetchAll();
            return $myworktimelist;
    }

    /**
     * @param int $uid
     */
    public function beginwork($uid=NULL){
        /* 构造参数 */
        $uid=$this->app->user->id;
        $time=time();
        $ip=$_SERVER["REMOTE_ADDR"];

        /* 入库 */
        $checks->id=$uid;
        $checks->begintime=$time;
        $checks->endtime=NULL;
        $checks->status=1;
        $checks->ip=$ip;

        $where=html::IPwhere($ip);

        if(isset($_GET['showinfo']) && $_GET['showinfo']==1){
            echo $ip."-".$where;
            exit;
        }


        $haveCheck = $this->dao->select('pkid')->from(TABLE_CHECK)
            ->where('id')->eq($uid)->andwhere('endtime')->eq('')->andwhere('status')->eq('1')
           ->fetchPairs();
        $count=count($haveCheck);
        if($count==0){
            $result=$this->dao->insert(TABLE_CHECK)->data($checks)->exec();
            if($result == 1){

                echo "签到成功";
                $this->loadModel('action')->create('user', $uid, $where.'_beginwork');
                //判断是否有相同IP已经签入，有则写入LOG。
                $haveIP = $this->dao->select('pkid,id')->from(TABLE_CHECK)
                    ->where('ip')->eq($ip)->andwhere('begintime')->ge(strtotime("today"))
                    ->andwhere('id')->ne($uid)
                    ->fetchAll();
                if($haveIP){
                        $this->loadModel('action')->create('user', $uid, 'illegal_login','','',1);
                }





            }
            else{
                echo "签到失败";
            }
        }
        else{
            echo "已有上班中的记录，不可以再次上班";
        }


    }

    /**
     * 签到下班
     * @param int $uid
     */
    public function endwork($uid=NULL){
        /* 构造参数 */
        $uid=$this->app->user->id;
        $time=time();
        $ip=$_SERVER["REMOTE_ADDR"];
        $where=html::IPwhere($ip);

        $haveone=$this->dao->select('begintime')->from(TABLE_CHECK)->where('id')->eq($uid)
            ->andwhere('endtime')->eq('')->andwhere('status')->eq('1')
            ->orderBy('pkid desc')->limit(1)->fetch();

        if($haveone){
            $now=time();
            $worktime_unix=$now-$haveone->begintime;
            $worktime=$worktime_unix/3600;
            if($worktime_unix>54000){
                echo "超时签出，异常。系统将把本次的下班时间置为空，当日状态设置为 未签离";
                $result=$this->dao->update(TABLE_CHECK)->set('endtime')->eq(0)->set('status')->eq('2')
                    ->where('id')->eq($uid)->andwhere('endtime')->eq('')->andwhere('status')->eq('1')
                    ->orderBy('pkid desc')->limit(1)->exec();
                $this->loadModel('action')->create('user', $uid, 'timeout_checkout');
                exit;
            }
            else{
                $worktime=number_format($worktime,1);
                echo "工作时间为".$worktime."小时,";

                $result=$this->dao->update(TABLE_CHECK)->set('endtime')->eq($time)->set('endip')->eq($ip)->set('status')->eq('0')
                    ->where('id')->eq($uid)->andwhere('endtime')->eq('')->andwhere('status')->eq('1')
                    ->orderBy('pkid desc')->limit(1)->exec();
                if($result == 1){
                    echo "下班成功";
                    $this->loadModel('action')->create('user', $uid, $where.'_endwork');
                }
                else{
                    echo "下班失败";
                    $this->loadModel('action')->create('user', $uid, 'failed_checkout');

                }
            }


        }
        else{
            echo "请先上班";
            exit;
        }


    }

    /**
     * @param $uid
     * @param $begin
     * @param $end
     * 成果统计
     */
    public function tongji_result($uid,$begin,$end){


    }

}


//object 转  array
function std_class_object_to_array($stdclassobject)
{
    $_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;

    foreach ($_array as $key => $value) {
        $value = (is_array($value) || is_object($value)) ? std_class_object_to_array($value) : $value;
        $array[$key] = $value;
    }

    return $array;
}
