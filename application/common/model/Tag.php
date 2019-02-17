<?php

namespace app\common\model;

use think\Model;

class Tag extends Model
{
    protected $table = 'tags';

    public function articles()
    {
    	return $this->belongsToMany(Article::class, 'article_tag');
    }

    public function scopeSearch($query, $name)
    {
    	if($name)
    	{
    		$query->where('name', 'like', $name.'%');
    	}
    }

    public static function init()
    {
    	self::event('after_delete', function($model){
    		$model->articles()->detach();
    	});
    }
}
