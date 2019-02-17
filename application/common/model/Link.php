<?php

namespace app\common\model;

use think\Model;

class Link extends Model
{
    protected $table = 'links';

    protected $createTime = 'created_at';

    protected $updateTime = 'updated_at';

    public function scopeEnabled($query)
    {
    	$query->where('disabled', 0);
    }
}
