<h1 align="center"> phprookiehbb/umeng </h1>

<p align="center">:calling: 集成友盟推送的composer插件包</p>


## 环境需求

- PHP >= 5.6

## 安装

```shell
$ composer require "phprookiehbb/umeng":dev-master
```

## 使用
```php
use CraspHb\Umeng\Umeng;
use CraspHb\Umeng\Config;

$key = 'appkey';
$secret = 'App Master Secret';

//初始化
$push = new Umeng($key, $secret);

```
### 方法一
  直接定义发送数据的结构，然后发送
```php
   $data = [
           'payload' => [
                "aps" => [
                    "alert" => [
                        'title'  => '测试',
                        'subtitle' => '测试2',
                        'body' => $body
                    ],
                    "badge" => 0,
                ],
           ],
           'filter' => [
                'where' => [
                    'and'  => [
                          'tag' => 343
                     ]
                ]
           ],
           'production_mode' => "false",
           
       ];
    $res = $push->send(Config::IOS_GROUPCAST, $data);
```
### 方法二
   内置了添加filter，policy的函数以及拼接常规参数的方法，故使用如下方式
```php
    $data = [
        'production_mode' => "false", 
    ];
   $res = $push->set(Config::IOS_GROUPCAST, $data)
              ->setPredefine('title','测试')
              ->setPredefine('subtitle','Cesjk')
              ->setPredefine('body',$body)
              ->setPredefine('badge',0)
              ->setCustomizedField('aboutme','crasphb')
              ->setFilter(['or'=>[['tag' => '6401'],['tag' => '343']]])
              ->setPolicy(['start_time' => date('Y-m-d H:i:s',time()+30)])
              ->run();
```
此处可配合$data数组。
其中`setPredefine`为定义内置的参数，`setCustomizeField`为定义额外自定义的参数,`setFilter`为方便过滤的方法，出入数组，`setPolicy`为定时的方法,
其中`setFilter`，`setPolicy`均可使用`setPredefine`来代替，只不过这两个提供了更为便捷的方式，如下所示。
```php
    $data = [
        'production_mode' => "false", 
        'filter' => [
                        'where' => [
                            'and'  => [
                                  'tag' => 343
                             ]
                        ]
         ],
    ];
   $res = $push->set(Config::IOS_GROUPCAST, $data)
              ->setPredefine('title','测试')
              ->setPredefine('subtitle','Cesjk')
              ->setPredefine('body',$body)
              ->setPredefine('badge',0)
              ->setCustomizedField('aboutme','crasphb')
              ->setPolicy(['start_time' => date('Y-m-d H:i:s',time()+30)])
              ->run();
```
## License

MIT
