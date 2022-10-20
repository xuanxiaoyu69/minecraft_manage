<?php

namespace app\admin\validate;

use think\Validate;

class ServerValidate extends Validate
{
    protected $rule = [
        'name' => 'require',
        'host' => 'require',
        'port' => 'require',
        'user' => 'require',
    ];
    protected $message = [
        'name.require' => '请输入服务器名称！',
        'host.require' => '请输入服务器ip！',
        'port.require' => '请输入服务器端口！',
        'user.require' => '请输入服务器账号！',
    ];

    protected $scene = [
//        'add'  => ['user_login,user_pass,user_email'],
//        'edit' => ['user_login,user_email'],
    ];
}