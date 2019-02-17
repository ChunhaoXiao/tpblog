<?php

namespace app\admin\model;

use think\Model;

class Category extends Model
{
	protected $pk = 'id';

    protected $table = 'categories';

    protected $createTime = 'created_at';

    protected $updateTime = 'updated_at';

    public function articles()
    {
    	return $this->hasMany(Article::class, 'category_id');
    }
}
