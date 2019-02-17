<?php

namespace app\http\middleware;
use think\facade\Session;

class Auth
{
    public function handle($request, \Closure $next)
    {
    	if(!Session::get('user', 'user'))
    	{
    		if($request->isAjax())
    		{
    			return json(['unauthorized'])->code(401);
    		}
    		return redirect('index/login/create');
    	}
    	return $next($request);
    }
}
