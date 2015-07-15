##Getui-php-sdk

个推开放平台php开发包,细化各项接口操作,欢迎Fork此项目  
getui developer SDK.
项目地址：**https://github.com/fanrong33/getui-php-sdk**  

##Getui.class.php 官方API类库

### Functions
- pushMessageToSingle($client_id, $template) 指定用户推送消息
- pushMessageToApp($template, $phone_type_list, $province_list) 对单个应用下的所有用户进行推送，可根据机型、省份、标签过滤推送
- createNotificationTemplate($options) 创建通知透传功能模板
- createTransmissionTemplate($options) 创建透传功能模板

### Demo
##### 1.初始化对象
```php
require_once('Getui.class.php');

$options = array(
    'appid'        => 'cYme4PGDzz99dHt24tRAl3',
    'appkey'       => 'eL4DY8DIQJ8YLDQlxEKzK8',
    'mastersecret' => 'EM1Ta7nizJ8hQ424cA5G82',
);
$getui = new Getui($options);
//TODO 调用$getui类方法
```

##### 2.推送通知透传消息模板给指定用户
```php
$template_options = array(
    'transmission_content' => '透传内容，跳转到对应的订单详情页面',    // 透传内容
    'title'                => '应用名称',    // 通知栏标题
    'text'                 => '你有一个新的付款订单，点击查看！',    // 通知栏内容
);
$template = $getui->createNotificationTemplate($template_options);

$client_id = '5a2547f6d56749932736837a3e60bd35';
$response = $getui->pushMessageToSingle($client_id, $template);
print_r($response);
```

##### 3.推送透传消息模板给单个应用的所有用户
```php
// 创建透传消息模板
$template_options = array(
    'transmission_content' => '透传内容，跳转到对应的订单详情页面',    // 透传内容
);
$template = $getui->createTransmissionTemplate($template_options);

$response = $getui->pushMessageToApp($template, array('ANDROID'), array('上海', '福建'));
print_r($response);
```


##History

v1.1.0 Build 20150714

- 发布基础版本

##TODO
对单个应用下的多个用户进行推送




##License

The MIT License (MIT)
