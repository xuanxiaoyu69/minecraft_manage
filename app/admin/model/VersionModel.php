<?php

namespace app\admin\model;

use think\Model;

class VersionModel extends Model
{
    protected $name = 'version';

    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'addtime';
    protected $updateTime = 'updatetime';
}