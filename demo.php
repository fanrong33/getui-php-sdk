<?php
header("Content-Type: text/html; charset=utf-8");
/**
 * 个推工具类示例代码
 */
require_once(dirname(__FILE__) . '/' . 'Getui.class.php');

$options = array(
    'appid'        => 'cYme4PGDzz99dHt24tRAl3',
    'appkey'       => 'eL4DY8DIQJ8YLDQlxEKzK8',
    'mastersecret' => 'EM1Ta7nizJ8hQ424cA5G82',
);
$getui = new Getui($options);

// 创建通知透传消息模板
$template_options = array(
    'transmission_content' => '透传内容，跳转到对应的订单详情页面',    // 透传内容
    'title'                => '应用名称',    // 通知栏标题
    'text'                 => '你有一个新的付款订单，点击查看！',    // 通知栏内容
);
$template1 = $getui->createNotificationTemplate($template_options);


// 创建透传消息模板
$template_options = array(
    'transmission_content' => '透传内容，跳转到对应的订单详情页面',    // 透传内容
);
$template2 = $getui->createTransmissionTemplate($template_options);

$client_id = '5a2547f6d56749932736837a3e60bd35';
$response = $getui->pushMessageToSingle($client_id, $template1);
// $response = $getui->pushMessageToApp($template1, array('ANDROID'), array('上海', '福建'));
print_r($response);


?>