<?php

namespace app\common\model;

use think\Model;
use think\facade\Session;
use think\facade\Cache;
use app\common\traits\FailedLoginTrait;

class Admin extends Model
{
	use FailedLoginTrait;

    protected $table = 'admin';

    protected $createTime = 'created_at';

    protected $updateTime = 'updated_at';

    public function login($credentials)
    {
    	if($this->hasTooManyFailedLoginCounts())
    	{
    		return false;
    	}

    	$where = [
    		'name' => $credentials['name'],
    		'password' => md5($credentials['password']),
    	];

    	if(!$admin = self::where($where)->find())
    	{
    		$this->setLoginFailedCounts();
    		return false;
    	}
    	
    	Session::set('admin', $admin, 'admin');
    	return true;
    }
}
