<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\Article;

class ArticleStatus extends Controller
{
    
    public function update(Request $request, $id)
    {
        $data = array_filter($request->only(['is_top', 'is_show']), 'strlen');
        $id = $id?? $request->param('id');
        $article = Article::get($id);
        $article->save($data);
        return 'ok';
    }
}
