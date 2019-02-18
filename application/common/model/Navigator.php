<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;
class Navigator extends Model
{
	use SoftDelete;

    protected $table = 'navigator';

    protected $createTime = 'created_at';

    protected $updateTime = 'updated_at';

    protected $deleteTime = 'deleted_at';
}
