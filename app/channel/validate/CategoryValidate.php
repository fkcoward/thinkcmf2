<?php

namespace app\channel\validate;

use think\Validate;

class CategoryValidate extends Validate
{
    protected $rule = [
        'cname' => 'require'
    ];

    protected $message=[
        'cname'=>"名称必须"
    ];
}