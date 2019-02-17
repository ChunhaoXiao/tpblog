<?php

namespace app\admin\model;

use think\Model;

class Link extends Model
{
    protected $table = 'links';

    protected $createTime = 'created_at';

    protected $updateTime = 'updated_at';
}
