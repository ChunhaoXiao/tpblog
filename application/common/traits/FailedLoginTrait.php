<?php
namespace app\common\traits;
use think\facade\Cache;
use think\facade\Session;

trait FailedLoginTrait
{
	public function hasTooManyFailedLoginCounts($identity = '')
    {
    	$key = empty($identity) ? ip2long(request()->ip()) : ip2long(request()->ip()).$identity;
    	if(Cache::get($key) > 5)
    	{
    		Session::flash('errors', '错误次数太多，稍后再试');
    		return true;
    	}
    	return false;
    }

    public function setLoginFailedCounts($identity = '')
    {
    	$key = empty($identity) ? ip2long(request()->ip()) : ip2long(request()->ip()).$identity;
        $count = Cache::get($key);
        $count = $count ? $count + 1 : 1;
        Session::flash('errors', '用户名或密码错误!');
        Cache::set($key, $count, 120);
        return true;
    }
}