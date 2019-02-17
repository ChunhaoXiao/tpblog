<?php

namespace app\admin\model;

use think\Model;

class Advertisement extends Model
{
    protected $table = 'advertisements';

    protected $createTime = 'created_at';

    protected $updateTime = 'updated_at';

    public function scopeSearch($query, $type)
    {
    	if($type)
    	{
    		$query->where('position', $type);
    	}
    }
}
