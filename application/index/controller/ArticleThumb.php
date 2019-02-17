<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\common\model\Article;

class ArticleThumb extends Controller
{
    public function read(Article $article)
    {
        $data['up_thumb_count'] = $article->thumbs()->where('type', 'up')->count();
        $data['down_thumb_count'] = $article->thumbs()->where('type', 'down')->count();
        return json($data);
    }

    public function save(Request $request, Article $article, $type)
    {
        $data['type'] = $type;
        $data['user_id'] = session('user', '', 'user')->id;
        $article->updateThumb($data);
        return json('ok')->code(200);
    }
}
