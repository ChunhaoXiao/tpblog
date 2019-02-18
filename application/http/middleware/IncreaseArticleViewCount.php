<?php

namespace app\http\middleware;
use app\common\model\Article;
use think\facade\Session;

class IncreaseArticleViewCount
{
    public function handle($request, \Closure $next)
    {
    	$id = $request->param('id');
    	$article = Article::get($id);
    	if($article)
    	{
    		if(!Session::has('viewed_'.$id))
    		{
    			$article->setInc('view_times');
    			Session::set('viewed_'.$id, 1);
    		}
    	}
    	return $next($request);
    }
}
