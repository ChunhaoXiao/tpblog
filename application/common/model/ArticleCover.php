<?php

namespace app\common\model;

use think\Model;

class ArticleCover extends Model
{
    protected $table = 'article_cover';

    protected $createTime = 'created_at';

    protected $updateTime = 'updated_at';

    public function article()
    {
    	return $this->belongsTo(Article::class, 'article_id');
    }
}
