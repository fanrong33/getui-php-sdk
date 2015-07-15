<?php
/**
 * 个推开放平台PHP-SDK
 * @author  fanrong33 <fanrong33@qq.com>
 * @link    https://github.com/fanrong33/getui-php-sdk
 * @version 1.1.0 build 20150714
 */
require_once(dirname(__FILE__) . '/' . 'IGt.Push.php');

class Getui{

    const API_URL          = 'http://sdk.open.api.igexin.com/apiex.htm';

    private $_appid        = '';
    private $_appkey       = '';
    private $_mastersecret = '';
    public  $debug         = false;

    public function __construct($options){
        $this->_appid        = isset($options['appid']) ? $options['appid'] : '';
        $this->_appkey       = isset($options['appkey']) ? $options['appkey'] : '';
        $this->_mastersecret = isset($options['mastersecret']) ? $options['mastersecret'] : '';
        $this->debug         = isset($options['debug']) ? $options['debug'] : false;
        // TODO 可从数据库获取配置信息，使用的时候就不需要每次都进行赋值
        
    }

    /**
     * 指定用户推送消息
     * @param  string       $client_id   客户端client_id
     * @param  IGtTemplate  $template    消息模板
     * @return array  { 
     *           'taskId' => 'OSS-0714_G3stFVcUoP7hvK2Du158Q1',
     *           'result' => 'ok',
     *           'status' => 'successed_online'
     *         }
     */
    public function pushMessageToSingle($client_id, $template){

        $igt = new IGeTui(self::API_URL, $this->_appkey, $this->_mastersecret);
        $igt->debug = $this->debug;

        //1. 消息模版：
        // a.TransmissionTemplate: 透传功能模板
        // b.LinkTemplate:         通知打开链接功能模板
        // c.NotificationTemplate：通知透传功能模板
        // d.NotyPopLoadTemplate： 通知弹框下载功能模板
        
        //$template = IGtNotyPopLoadTemplateDemo();
        //$template = IGtLinkTemplateDemo();
        //$template = IGtNotificationTemplateDemo();
        //$template = IGtTransmissionTemplateDemo();
        
        //2. 个推信息体
        $message = new IGtSingleMessage();
        $message->set_isOffline(true);                  // 是否离线
        $message->set_offlineExpireTime(3600*12*1000);  // 离线时间
        $message->set_data($template);                  // 设置推送消息类型
        $message->set_PushNetWorkType(0);               // 设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
        
        //3. 接收方
        $target = new IGtTarget();
        $target->set_appId($this->_appid);
        $target->set_clientId($client_id);
        
        $response = $igt->pushMessageToSingle($message, $target);

        return $response;
    }
    
    /**
     * 对单个应用下的所有用户进行推送，可根据机型，省份，标签过滤推送
     * @param  IGtTemplate  $template           消息模板
     * @param  array        $phone_type_list    手机类型列表，['ANDROID', 'IOS']
     * @param  array        $province_list      省份列表,['福建', '上海']
     * @return array  Array ('result' => ok, 'contentId' => OSA-0714_wlhCOZ7r078DZ5muXRg1Y4 )
     */
    public function pushMessageToApp($template, $phone_type_list, $province_list){

        $igt = new IGeTui(self::API_URL, $this->_appkey, $this->_mastersecret);
        $igt->debug = $this->debug;

        //1. 消息模版：
        // a.TransmissionTemplate: 透传功能模板
        // b.LinkTemplate:         通知打开链接功能模板
        // c.NotificationTemplate：通知透传功能模板
        // d.NotyPopLoadTemplate： 通知弹框下载功能模板
        
        //$template = IGtNotyPopLoadTemplateDemo();
        //$template = IGtLinkTemplateDemo();
        //$template = IGtNotificationTemplateDemo();
        //$template = IGtTransmissionTemplateDemo();
        
        //2. 个推信息体
        $message = new IGtAppMessage();
        $message->set_isOffline(true);                  // 是否离线
        $message->set_offlineExpireTime(3600*12*1000);  // 离线时间
        $message->set_data($template);                  // 设置推送消息类型
        $message->set_PushNetWorkType(0);               // 设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
        $message->set_appIdList(array($this->_appid));
        $message->set_phoneTypeList($phone_type_list);
        $message->set_provinceList($province_list);

        $response = $igt->pushMessageToApp($message);

        return $response;
    }

    /**
     * 创建通知透传功能模板
     * 注：IOS离线推送需通过APN进行转发，需填写pushInfo字段，目前仅不支持通知弹框下载功能
     * @param array $options array(
     *     'transmission_content' => '',    // 透传内容
     *     'title'                => '',    // 通知栏标题
     *     'text'                 => '',    // 通知栏内容
     *     'is_ring'              => true,  // 是否响铃
     *     'is_vibrate'           => true,  // 是否震动
     *     'push_info' => array(
     *         'action_loc_key' => '',
     *         'badge'          => 0,
     *         'message'        => '',
     *         'sound'          => '',
     *         'payload'        => '',
     *         'loc_key'        => '',
     *         'loc_args'       => '',
     *         'launch_image'   => '',
     *     )
     *   )
     */
    public function createNotificationTemplate($options){
        $_options = array(
            'transmission_content' => isset($options['transmission_content']) ? $options['transmission_content'] : '透传内容',
            'title'                => isset($options['title']) ? $options['title'] : '个推',
            'text'                 => isset($options['text']) ? $options['text'] : '个推最新版点击下载',
            'is_ring'              => isset($options['is_ring']) ? $options['is_ring'] : true,
            'is_vibrate'           => isset($options['is_vibrate']) ? $options['is_vibrate'] : true,
            'push_info'            => isset($options['push_info']) ? $options['push_info'] : '',
        );

        $template = new IGtNotificationTemplate();
        $template->set_appId($this->_appid);                // 应用appid
        $template->set_appkey($this->_appkey);              // 应用appkey
        $template->set_transmissionType(1);                 // 透传消息类型
        $template->set_transmissionContent($_options['transmission_content']);  // 透传内容
        $template->set_title($_options['title']);           // 通知栏标题
        $template->set_text($_options['text']);             // 通知栏内容
        $template->set_isRing($_options['is_ring']);        // 是否响铃
        $template->set_isVibrate($_options['is_vibrate']);  // 是否震动
        $template->set_isClearable(true);                   // 通知栏是否可清除

        // iOS推送需要设置的pushInfo字段
        if($_options['push_info']){
            $push_info = $_options['push_info'];
            $template ->set_pushInfo(
                $push_info['action_loc_key'],
                $push_info['badge'],
                $push_info['message'],
                $push_info['sound'],
                $push_info['payload'],
                $push_info['loc_key'],
                $push_info['loc_args'],
                $push_info['launch_image']);
            //$template ->set_pushInfo("test",1,"message","","","","","");
        }
        return $template;
    }

    /**
     * 创建透传功能模板
     * 注：IOS离线推送需通过APN进行转发，需填写pushInfo字段，目前仅不支持通知弹框下载功能
     * @param array $options array(
     *     'transmission_content' => '',    // 透传内容
     *     'push_info' => array(
     *         'action_loc_key' => '',
     *         'badge'          => 0,
     *         'message'        => '',
     *         'sound'          => '',
     *         'payload'        => '',
     *         'loc_key'        => '',
     *         'loc_args'       => '',
     *         'launch_image'   => '',
     *     )
     *   )
     */
    public function createTransmissionTemplate($options){
        $_options = array(
            'transmission_content' => isset($options['transmission_content']) ? $options['transmission_content'] : '透传内容',
            'push_info'            => isset($options['push_info']) ? $options['push_info'] : '',
        );

        $template = new IGtTransmissionTemplate();
        $template->set_appId($this->_appid);    // 应用appid
        $template->set_appkey($this->_appkey);  // 应用appkey
        $template->set_transmissionType(1);     // 透传消息类型
        $template->set_transmissionContent($_options['transmission_content']);  // 透传内容

        //iOS推送需要设置的pushInfo字段
        if($_options['push_info']){
            $push_info = $_options['push_info'];
            $template ->set_pushInfo(
                $push_info['action_loc_key'],
                $push_info['badge'],
                $push_info['message'],
                $push_info['sound'],
                $push_info['payload'],
                $push_info['loc_key'],
                $push_info['loc_args'],
                $push_info['launch_image']);
            //$template ->set_pushInfo("test",1,"message","","","","","");
        }
        return $template;
    }

}
?>