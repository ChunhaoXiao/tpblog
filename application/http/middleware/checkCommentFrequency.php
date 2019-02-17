<?php

namespace app\http\middleware;
use think\facade\Cache;
use think\facade\Session;

class checkCommentFrequency
{
    public function handle($request, \Closure $next)
    {
    	if(!Cache::get('config')['allow_comment'])
    	{
    		return json(['评论功能已关闭'])->code(400);
    	}
    	$user_id = Session::get('user', 'user')->id;
    	$commented = Cache::get($user_id);
    	if($commented)
    	{
    		return json(['休息一下吧'])->code(419);
    	}
    	return $next($request);
    }
}
