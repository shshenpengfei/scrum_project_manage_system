<?php
/**
 * 封装除oauth外的openapi类
 */
class QqeimApi {

    const RETURN_TYPE = 'json';
    const OAUTH_VERSION = 2;
    const URL_BASE = 'http://openapi.b.qq.com/api/';
    //消息推送 API
    const API_SEND_SMS = 'sms/send'; //给员工帐号登记的手机发送手机短信（需消费短信）
    const API_SEND_TIPS = 'tips/send'; //给员工帐号发送客户端提醒
    const API_SEND_BROADCAST = 'broadcast/send'; //给员工帐号发送广播通知消息
    const API_NOTIFY_CLIENTPUSH_CENTER = 'clientpush/notifycenter'; //客户端主面板通知中心消息＊
    const API_MSG_CLIENTPUSH = 'clientpush/msg'; //给客户端发送有行为响应的消息＊
    //企业基本资料 API
    const API_GET_CORPORATION_INFO = 'corporation/get'; //获取企业的基本资料
    //员工帐号基本资料 API
    const API_GET_USER_LIST = 'user/list'; //获取员工基本资料列表
    const API_GET_USER_EMAIL = 'user/email'; //获取用户Email地址（敏感）
    const API_GET_USER_MOBILE = 'user/mobile'; // 获取用户手机号码（敏感）
    const API_GET_USER_QQ = 'user/qq'; //获取用户企业QQ号码（敏感）
    const API_GET_USER_ONLINE = 'user/online'; //获取用户企业QQ在线状态（敏感）
    //组织架构 API
    const API_GET_DEPT_LIST = 'dept/list'; //获取组织架构列表
    const API_ADD_USER = 'dept/adduser'; //新增普通员工
    const API_MOD_USER = 'dept/moduser'; //修改普通员工
    const API_DEL_USER = 'dept/deluser'; //删除普通员工
    const API_SET_USER_STATUS = 'dept/setuserstatus'; //修改员工状态
    const API_ADD_DEPT = 'dept/adddept'; //新增组织
    const API_MOD_DEPT = 'dept/moddept'; //修改组织
    const API_DEL_DEPT = 'dept/deldept'; //删除组织
    //单点登录 API
    const API_VERIFY_LOGIN_HASHSKEY = 'login/verifyhashskey'; //检验企业QQ跳转到第三方页面的有效性
    //与企业QQ交谈按钮 API
    const API_GET_WPA = 'wpa/generate'; //获取带有富文本上下文信息的“与企业QQ交谈”按钮
    //其他API
    const API_URL_LONG2SHORT = 'url/longtoshort';
    const API_URL_SHORT2LONG = 'url/shorttolong';

    private $_appId;
    private $_appSecret;

    public function __construct($app_id, $app_secret) {
        $this->_appId = $app_id;
        $this->_appSecret = $app_secret;
    }

    /**
     * 公共参数
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @return array 公共参数列表
     */
    protected function getBaseQuery($company_id, $company_token, $client_ip) {
        return array(
            'oauth_version' => self::OAUTH_VERSION,
            'app_id' => $this->_appId,
            'company_id' => $company_id,
            'company_token' => $company_token,
            'client_ip' => $client_ip,
        );
    }

    /**
     * 获取员工基本资料列表
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param string $open_id 成员唯一标示符
     * @param int $timestamp 时间戳（上次拉取获得的时间戳，首次拉取或全量拉取请传0） 
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     *      'data' => array(
     *          'timestamp' => int 当前服务器时间戳 ,
     *          'items' => array 员工元素 ,
     *      )
     * )
     * items[0]格式 
     * array(
     *      'open_id' => char(32) 用户id,
     *      'gender' => int 性别（1男2女）,
     *      'account' => string 帐号,
     *      'realname' => string 姓名,
     *      'p_dept_id' => array 父组织id，单个或者多个,
     *      'mobile' => int 0 无手机号 1有手机号,
     *      'hidden' => int 0 不隐藏 1 隐藏（需要第三方应用根据该状态来显示还是隐藏该成员），如果一个成员处于隐藏状态，他可以看到所有的成员，否则只能看到非隐藏的成员,
     *      'p_open_id' => char(32) 直接上司的open_id,
     *      'role_id' => int 0: 企业管理员 1: 系统管理员 2: 信息管理员 4: 普通员工 其他: 自定义角色
     * )
     */
    public function getUserList($company_id, $company_token, $client_ip, $timestamp = 0) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['timestamp'] = $timestamp;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_GET_USER_LIST, $basequery, false);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 获取用户Email地址
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param string $open_ids 用户的open_id列表，通过英文逗号分隔，一次请求限定128个
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     *      'data' => object 对象，键是请求参数open_ids中的每个open_id，值是该open_id对应的Email地址
     * )  
     */
    public function getUserEmail($company_id, $company_token, $client_ip, $open_ids) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['open_ids'] = $open_ids;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_GET_USER_EMAIL, $basequery, false);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 获取用户手机号码
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param string $open_ids 用户的open_id列表，通过英文逗号分隔，一次请求限定128个
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     *      'data' => object 对象，键是请求参数open_ids中的每个open_id，值是该open_id对应的手机号码
     * )  
     */
    public function getUserMobile($company_id, $company_token, $client_ip, $open_ids) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['open_ids'] = $open_ids;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_GET_USER_MOBILE, $basequery, false);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 获取用户企业QQ号码
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param string $open_ids 用户的open_id列表，通过英文逗号分隔，一次请求限定128个
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     *      'data' => object 对象，键是请求参数open_ids中的每个open_id，值是该open_id对应的企业QQ号码
     * )  
     */
    public function getUserQq($company_id, $company_token, $client_ip, $open_ids) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['open_ids'] = $open_ids;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_GET_USER_QQ, $basequery, false);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 获取用户企业QQ在线状态
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param string $open_id 成员唯一标示符
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     *      'data' => object 对象，{ 'pc' => boolean } 
     *      true表示电脑（PC，笔记本）在线，false表示不在线 注：如果用户为隐身，隐藏，或者未初始化，都被认为不在线）注：暂时不支持对移动端在线状态的查询
     * )  
     */
    public function getUserOnline($company_id, $company_token, $client_ip, $open_id) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['open_id'] = $open_id;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_GET_USER_ONLINE, $basequery, false);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 获取企业基本信息
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     *      'data' => array(
     *          'company_name' => string 公司简称,
     *          'company_fullname' => string 公司全称,
     *      )
     * )
     */
    public function getCorporationInfo($company_id, $company_token, $client_ip) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $data = $this->doHttpRequest(self::URL_BASE . self::API_GET_CORPORATION_INFO, $basequery, false);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 获取组织架构列表
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param int $timestamp 时间戳（上次拉取获得的时间戳，首次拉取或全量拉取请传0） 
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     *      'data' => array(
     *          'timestamp' => int 当前服务器时间戳 ,
     *          'items' => array 组织元素 ,
     *      )
     * )
     * items[0]格式 
     * array(
     *      'dept_id' => int 组织id ,
     *      'p_dept_id' => int 父组织id,
     *      'dept_name' => string 组织名称,
     * )
     */
    public function getDeptList($company_id, $company_token, $client_ip, $timestamp = 0) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['timestamp'] = $timestamp;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_GET_DEPT_LIST, $basequery, false);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 在组织架构根节点新增员工
     * 在根组织节点下，新增一名员工，QQ号码为默认分配，角色为系统缺省角色，密码为系统缺省密码。
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param string $account 必填，由字母、数字组成，点(.)减号(-)下划线(_) 不能放在开头或结尾，也不能连续出现
     * @param string $name 必填，中文名字等，长度24字节，UTF-8编码
     * @param int $gender 非必填，1-男；2-女；默认值 1
     * @param string $mobile 非必填，中国大陆手机号码格式，11位数字，不支持别的
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     *      'data' => object 只有一个键open_id，表示新添加成功的帐号的open_id。
     * )
     */
    public function addUser($company_id, $company_token, $client_ip, $account, $name, $gender = null, $mobile = null) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['account'] = $account;
        $basequery['name'] = $name;
        if ($gender !== null) {
            $basequery['gender'] = $gender;
        }
        if ($mobile !== null) {
            $basequery['mobile'] = $mobile;
        }
        $data = $this->doHttpRequest(self::URL_BASE . self::API_ADD_USER, $basequery);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 修改某个员工的资料
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param string $open_id 成员唯一标示符
     * @param string $account 必填，由字母、数字组成，点(.)减号(-)下划线(_) 不能放在开头或结尾，也不能连续出现
     * @param string $name 必填，中文名字等，长度24字节，UTF-8编码
     * @param int $gender 1-男；2-女；默认值 1
     * @param string $mobile 中国大陆手机号码格式，11位数字，不支持别的
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     * )
     */
    public function modUser($company_id, $company_token, $client_ip, $open_id, $account, $name, $gender = null, $mobile = null) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['open_id'] = $open_id;
        $basequery['account'] = $account;
        $basequery['name'] = $name;
        if ($gender !== null) {
            $basequery['gender'] = $gender;
        }
        if ($mobile !== null) {
            $basequery['mobile'] = $mobile;
        }
        $data = $this->doHttpRequest(self::URL_BASE . self::API_MOD_USER, $basequery);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 删除一个员工帐号
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param string $open_id 成员唯一标示符
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     * )
     */
    public function delUser($company_id, $company_token, $client_ip, $open_id) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['open_id'] = $open_id;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_DEL_USER, $basequery);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 设定一个员工帐号的状态
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param string $open_id 成员唯一标示符
     * @param int $status 1代表启用，2代表停用
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     * )
     */
    public function setUserStatus($company_id, $company_token, $client_ip, $open_id, $status) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['open_id'] = $open_id;
        $basequery['status'] = $status;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_SET_USER_STATUS, $basequery);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 新增组织
     * 增加新的组织架构，默认在根组织下追加。
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param string $dept_name 必填，组织架构名称，限定长度60个字符（1个中文占2个），由大小写英文字母、数字、汉字、小数点和横杠线组成，UTF-8编码     
     * @param int $p_dept_id 非必填，父组织id，即在哪个组织下新增，默认为根组织1
     * @param int $position 非必填，排序，即指定组织架构的具体位置，0为最前面，取值范围0~200，默认值200
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     *      'data' => object 只有一个键dept_id，表示新添加成功的组织id。
     * )
     */
    public function addDept($company_id, $company_token, $client_ip, $dept_name, $p_dept_id = 1, $position = 200) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['dept_name'] = $dept_name;
        $basequery['position'] = $position;
        $basequery['p_dept_id'] = $p_dept_id;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_ADD_DEPT, $basequery);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 修改组织
     * 通过该api，可以修改组织名称，移动组织到其他组织下，或者调整其排序。
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param int $dept_id 必填，需要进行修改操作的组织id
     * @param string $dept_name 必填，组织架构名称，限定长度60个字符（1个中文占2个），由大小写英文字母、数字、汉字、小数点和横杠线组成，UTF-8编码
     * @param int $p_dept_id 非必填，父组织id，通过指定该字段，可以把组织移动到这个组织下
     * @param int $position 非必填，排序，即指定组织架构的具体位置，0为最前面，取值范围0~200，默认值200, 移动操作的时候需要同时指定p_dept_id的值
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     * )
     */
    public function modDept($company_id, $company_token, $client_ip, $dept_id, $dept_name, $p_dept_id = 1, $position = 200) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['dept_id'] = $dept_id;
        $basequery['dept_name'] = $dept_name;
        $basequery['position'] = $position;
        $basequery['p_dept_id'] = $p_dept_id;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_MOD_DEPT, $basequery);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 删除组织
     * 删除指定的组织架构，值得注意的是，只能够删除空组织，即如果该组织下存在员工或者子组织，将删除失败。
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param int $dept_id 必填，组织id    
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     * )
     */
    public function delDept($company_id, $company_token, $client_ip, $dept_id) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['dept_id'] = $dept_id;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_DEL_DEPT, $basequery);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 发送客户端tips
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param string $receivers 消息接收人，逗号分隔的id字符串
     * @param string $window_title Tips弹出窗口的标题，限长24字符
     * @param string $tips_title Tips的消息标题，限长42字符
     * @param string $tips_content Tips的正文内容，限长264字符
     * @param string $tips_url 如果有链接，使用此参数，url，限长1024字节
     * @param int $receive_type Tips消息的类型 0 表示对方离线也发送，1表示只在对方在线时候发送 
     * @param int $to_all   0 否，只发给制定的receivers; 1 全员发送，忽略receivers
     * @param int $need_verify 是否需要单点登录：0 代表不需要，直接进入tips_url指示的网址 1 代表跳转过去的时候，传送company_id，open_id，hashskey等用于身份校验和识别的信息 ；
     * @param int $display_time tips窗口显示的时间，  0:一直显示不会自动消失; >0: 显示相应时间后自动关闭（单位：秒），上限为512秒
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     * )
     */
    public function sendTips($company_id, $company_token, $client_ip, $receivers, $window_title, $tips_title, $tips_content, $tips_url, $receive_type = 1, $to_all = 0, $need_verify = 0, $display_time = 5) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['receive_type'] = $receive_type;
        $basequery['receivers'] = $receivers;
        $basequery['window_title'] = $window_title;
        $basequery['tips_title'] = $tips_title;
        $basequery['tips_content'] = $tips_content;
        $basequery['tips_url'] = $tips_url;
        $basequery['to_all'] = $to_all;
        $basequery['need_verify'] = $need_verify;
        $basequery['display_time'] = $display_time;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_SEND_TIPS, $basequery);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 发送客户端广播
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param string $title 消息标题，限长31字符
     * @param string $content 消息内容，限长450字符
     * @param string $recv_dept_ids 组织列表，用英文逗号”,”分隔
     * @param string $recv_open_ids 用户open id列表，用英文逗号”,”分隔(以上两参数不能都为空)
     * @param string $open_id 发广播人身份 非必填
     * @param int $is_online 默认为0, 0 离线也发送 1 只发送在线
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     * )
     */
    public function sendBroadCast($company_id, $company_token, $client_ip, $title, $content, $recv_dept_ids, $recv_open_ids, $open_id = null, $is_online = 0) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['title'] = $title;
        $basequery['content'] = $content;
        $basequery['is_online'] = $is_online;
        $basequery['recv_dept_ids'] = $recv_dept_ids;
        $basequery['recv_open_ids'] = $recv_open_ids;
        if (isset($open_id)) {
            $basequery['open_id'] = $open_id;
        }
        $data = $this->doHttpRequest(self::URL_BASE . self::API_SEND_BROADCAST, $basequery);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 客户端通知中心
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param string $open_id 成员唯一标示符
     * @param array $items 通知条目，格式：[[名称, 数目], … ] 条目数量不可超过16个；单个条目的名称长度限长32个字符；
     * @param int $timestamp 当前时间戳 
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     * )
     */
    public function pushNotifyCenter2Client($company_id, $company_token, $client_ip, $open_id, $items = null, $timestamp = 0) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['open_id'] = $open_id;
        $basequery['timestamp'] = $timestamp;
        if(!empty($items)){
            $basequery['items'] = $items;
        }        
        $data = $this->doHttpRequest(self::URL_BASE . self::API_NOTIFY_CLIENTPUSH_CENTER, $basequery);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 推送定制化消息给客户端
     * 使用该API，可以给当前在线的企业QQ客户端推送一个消息，客户端可以依据该消息产生一定的行为。 但是该消息通道的使用，需要由第三方和企业QQ研发人员共同协商制定。
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param string $open_id 成员唯一标示符
     * @param int $msg_id 消息的ID，该ID需要跟企业QQ侧客户端研发人员协商制定 
     * @param int $timestamp 当前时间戳
     * @param object $data 扩展的消息内容，非必填，需要跟企业QQ侧研发人员协商制定 
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     * )
     */
    public function pushMsg2Client($company_id, $company_token, $client_ip, $open_id, $msg_id, $timestamp, $data) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['open_id'] = $open_id;
        $basequery['msg_id'] = $msg_id;
        $basequery['timestamp'] = $timestamp;
        $basequery['data'] = $data;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_MSG_CLIENTPUSH, $basequery);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 发送手机短信
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param string $recv_phones 手机号列表，用英文逗号”,”分隔
     * @param string $recv_open_ids 接收者open id列表，用英文逗号”,”分隔(以上两参数不能都为空)
     * @param string $content 短信内容，限长232字符
     * @param string $signature 短信签名，限长32字符
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     * )
     */
    public function sendSms($company_id, $company_token, $client_ip, $recv_phones, $recv_open_ids, $content, $signature = '') {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['recv_phones'] = $recv_phones;
        $basequery['recv_open_ids'] = $recv_open_ids;
        $basequery['content'] = $content;
        $basequery['signature'] = $signature;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_SEND_SMS, $basequery);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 长网址转换为短网址
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param array $urls [url1, url2, url3] 每次请求的网址限定在32个以内
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     *      'data' => array(
     *          'items' => array(long1 => short1, long2 => short2, …) 键是长网址，值是对应的短网址
     *      ),
     * )
     */
    public function urlLong2Short($company_id, $company_token, $client_ip, $urls) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['urls'] = $urls;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_URL_LONG2SHORT, $basequery);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 短网址转换为长网址
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param array $urls [url1, url2, url3] 每次请求的网址限定在32个以内
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     *      'data' => array(
     *          'items' => array(short1 => long1, short2 => long2, …) 键是短网址，值是长网址
     *      ),
     * )
     */
    public function urlShort2Long($company_id, $company_token, $client_ip, $urls) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['urls'] = $urls;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_URL_SHORT2LONG, $basequery);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 登录态校验
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param string $open_id 成员唯一标示符
     * @param string $hashskey 登录标识（通过企业QQ带登录态跳转到第三方应用获得，验证通过后，第三方应用种上并维护自己的登录态）
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     * )
     */
    public function verifyLoginHashskey($company_id, $company_token, $client_ip, $open_id, $hashskey) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['open_id'] = $open_id;
        $basequery['hashskey'] = $hashskey;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_VERIFY_LOGIN_HASHSKEY, $basequery, false);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 通知企业QQ服务开通状态
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param int $status 状态：0：成功
     * @param string $desc 描述
     * @return array
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     * )
     */
    public function notifyAppOpenCallBack($company_id, $company_token, $client_ip, $status, $desc) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['status'] = $status;
        $basequery['desc'] = $desc;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_APP_OPENCALLBACK, $basequery);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 获取带有富文本上下文信息的wpa按钮
     * @param string $company_id 企业唯一标示符
     * @param string $company_token 企业认证token
     * @param string $client_ip 用户ip（如果是服务器发起的请求，请传服务器ip；如果是用户发起的请求，请传用户的ip）
     * @param string $to_open_id （必填）会话对象的open_id
     * @param string $format 默认normal（必填）普通：normal，富文本：rich（rich需要企业QQ客户端1.81或以上版本）
     * @param string $title （rich选填）富文本标题，限长20字
     * @param string $desc （rich必填）富文本描述信息，限长60字
     * @param string $link （rich选填）富文本链接落地页面网址，限长255字节
     * @param string $image （rich选填）富文本图片Url，限长255字节
     * @param int $auto_send （rich选填）富文本信息是否自动发送给对方，默认0，不自动发送，1，表示自动发送
     * array(
     *      'ret' => int 返回码，0正常， >0异常,
     *      'msg' => string 如果ret不为0，会有相应的错误信息提示，UTF-8编码,
     *      'data' => array(
     *          'gender' => int 1-代表男；2-代表女 
     *          'href' => string qqeim://message?uin=….形如此形式的WPA激活用协议 
     *          'account' => string 被呼叫人的帐号，如：lucywang 
     *          'name' => string 被呼叫人的姓名，如：王小丽 
     *          'link' => string 完整的link形式，可以直接输出：<a href=”” onclick=””><img src=”” />lucywang(王小丽)</a> 
     *      ),
     * )
     */
    public function getWpaButton($company_id, $company_token, $client_ip, $to_open_id, $format = 'normal', $title = '', $desc = '', $link = '', $image = '', $auto_send = 0) {
        $basequery = $this->getBaseQuery($company_id, $company_token, $client_ip);
        $basequery['to_open_id'] = $to_open_id;
        $basequery['format'] = $format;
        $basequery['title'] = $title;
        $basequery['description'] = $desc;
        $basequery['link'] = $link;
        $basequery['image'] = $image;
        $basequery['auto_send'] = $auto_send;
        $data = $this->doHttpRequest(self::URL_BASE . self::API_GET_WPA, $basequery);
        return $data === false ? false : @json_decode($data, true);
    }

    /**
     * 根据参数发起curl请求
     * @param string $url url
     * @param $array $query 参数array('key' => 'value')
     * @param boolean $usePost 是否使用post请求 默认true使用post方式 
     * @return string result or false
     */
    public function doHttpRequest($url, $query, $usePost = true) {
        $result = false;
        if ($usePost) {
            $options = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($query),
            );
        } else {
            $options = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 10,
            );
            $url = $url . '?' . http_build_query($query);
        }
        $curl = curl_init($url);
        if (curl_setopt_array($curl, $options)) {
            $result = curl_exec($curl);
        }
        curl_close($curl);
        return $result;
    }

}
