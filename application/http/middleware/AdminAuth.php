<?php

namespace app\http\middleware;
use think\facade\Session;

class AdminAuth
{
    public function handle($request, \Closure $next)
    {
    	if(!Session::get('admin', 'admin'))
    	{
    		return redirect('admin/login/create');
    	}
    	return $next($request);
    }
}
