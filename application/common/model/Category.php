<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Category extends Model
{
	use SoftDelete;

	protected $pk = 'id';

    protected $table = 'categories';

    protected $createTime = 'created_at';

    protected $updateTime = 'updated_at';
    
    protected $deleteTime = 'deleted_at';

    public function articles()
    {
    	return $this->hasMany(Article::class, 'category_id');
    }
}
