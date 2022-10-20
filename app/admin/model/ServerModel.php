<?php

namespace app\admin\model;

use think\Model;

class ServerModel extends Model
{
    protected $name = 'server';

    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'addtime';
    protected $updateTime = 'updatetime';
}