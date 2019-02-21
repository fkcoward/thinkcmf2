<?php

namespace app\channel\validate;

use think\Validate;

class ChannelValidate extends Validate
{
    protected $rule = [
        'nickname' => 'require',
        'name' => 'require',
        'begin_time' => 'require|date',
        'end_time' => 'require|date',
        'type' => 'require',
        'url' => 'require|url',
        'flag' => 'require',
    ];

    protected $message=[
        'nickname'=>"中文名称必须",
        'name'=>"地址名必须",
        'begin_time.require'=>"开始时间必须",
        'end_time.require'=>"开始时间必须",
        'begin_time.date'=>"开始时间错误",
        'end_time.date'=>"开始时间错误",
        'type'=>'类型必须',
        'url.require'=>'H5链接必须',
        'url.url'=>'H5链接格式错误',
        'flag'=>'状态必须'
    ];
}