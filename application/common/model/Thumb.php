<?php

namespace app\common\model;

use think\Model;

class Thumb extends Model
{
    protected $table = 'thumbs';

   	protected $createTime = 'created_at';

   	protected $updateTime = 'updated_at';

   	public function article()
   	{
   		return $this->belongsTo(Article::class, 'article_id');
   	}

   	public function user()
   	{
   		return $this->belongsTo(User::class, 'user_id');
   	}
}
