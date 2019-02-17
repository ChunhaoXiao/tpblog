<?php
namespace app\common\model;
use think\Model;
use think\Db;
use think\facade\Session;
use think\facade\Cache;

class Article extends Model
{
    protected $table = 'articles';

    protected $createTime = 'created_at';

    protected $updateTime = 'updated_at';

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }

    public function tags()
    {
    	return $this->belongsToMany(Tag::class, 'article_tag');
    }

    public function cover()
    {
    	return $this->hasOne(ArticleCover::class, 'article_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'article_id');
    }

    public function latestComment()
    {
        return $this->hasOne(Comment::class, 'article_id')->order('created_at' ,'desc')->bind(['last' => 'created_at']);
    }

    public function thumbs()
    {
        return $this->hasMany(Thumb::class, 'article_id');
    }

    //删除文章后也把该文章的标签删除
    public static function init()
    {
    	self::event('after_delete', function($model){
    		$model->tags()->detach();
            // laravel， $model->comments()->delete() 就搞定。thinkphp 太low了
            if(!$model->comments->isEmpty())
            {
               foreach($model->comments as $comment)
               {
                    $comment->delete();
               }
            }
    	});
    }


    
    public function scopeSearch($query, $where)
    {
        if(!empty($where))
        {
            $map = [];
            foreach($where as $field => $v)
            {
                if(strlen($v))
                {
                    if($field == 'keyword')
                    {
                        $map[] = ['title|content', 'like', '%'.$v.'%'];
                    }
                    elseif($field == 'category')
                    {
                        $map[] = ['category_id','=', $v];
                    }
                }
            }

            $tag = $where['tag']?? '';

            $query->when(!empty($map), function($query) use($map){
                $query->where($map);
            })->when($tag, function($query) use($tag){
                $tagid = Tag::where('name', $tag)->value('id');
                return $query->join('article_tag', 'articles.id=article_tag.article_id')->where('article_tag.tag_id', $tagid);
            });
        }
    }

    public function syncTags($tagIds)
    {
    	$this->tags()->detach();
		$this->tags()->attach($tagIds);
    }

    public function setCover($fileName)
    {
        if($this->cover)
        {
            $this->cover->path = $fileName;
            return $this->cover->save();
        }
    	return $this->cover()->save(['path' => $fileName]);
    }

    public function addComment($data, $id)
    {
        $article = self::getOrFail($id);
        $data['user_id'] = Session::get('user', 'user')->id;
        $comment = $article->comments()->save($data);
        $interval = intval(Cache::get('config')['comment_interval']) ?? 20;
        Cache::set($data['user_id'], 1, $interval);
        return $comment;
    }

    public function updateThumb($data)
    {
        $where = ['type' => $data['type'], 'user_id' => Session::get('user', 'user')->id];
        if($this->thumbs()->where($where)->find())
        {
            return $this->thumbs()->where($where)->delete();
        }
        return $this->thumbs()->save($data);
    }
}
