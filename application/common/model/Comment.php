<?php

namespace app\common\model;

use think\Model;

class Comment extends Model
{
    protected $table = 'comment';

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

    public function scopeKeyword($query, $word = '')
    {
        if(!empty($word))
        {
            $query->where('content', 'like', '%'.$word.'%');
        }
    }

    public function scopeArticle($query, $article_id = null)
    {
        if(!empty($article_id))
        {
            $query->where('article_id', $article_id);
        }
    }

    public function scopeUser($query, $user)
    {
        if(!empty($user))
        {
            $user_id = is_numeric($user)? $user : (User::where('name', $user)->value('id')?? 0);
            $query->where('user_id', $user_id);
        }
    }

    //是否允许删除评论 只能删除自己的
    public function canDelete()
    {
        $user = session('user', '', 'user');
        if(!$user)
        {
            return false;
        }

        return $user->id == $this->user_id;
    }
}
