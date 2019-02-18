<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Link extends Model
{
	use SoftDelete;

    protected $table = 'links';

    protected $createTime = 'created_at';

    protected $updateTime = 'updated_at';

    protected $deleteTime = 'deleted_at';

    public function scopeEnabled($query)
    {
    	$query->where('disabled', 0);
    }
}
