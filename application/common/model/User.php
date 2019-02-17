<?php

namespace app\common\model;

use think\Model;
use think\facade\Session;
use app\common\traits\FailedLoginTrait;


class User extends Model
{
    use FailedLoginTrait;

    protected $table = 'users';

    protected $createTime = 'created_at';

    protected $updateTime = 'updated_at';

    public static function init()
    {
        self::event('after_delete', function($user){
            if(!$user->comments->isEmpty())
            {
                foreach($user->comments as $comm)
                {
                    $comm->delete();
                }
            }
            foreach ($user->thumbs as $key => $thumb) {
                $thumb->delete();
            }
        });
    }

    public function setPasswordAttr($value)
    {
    	return md5($value);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function thumbs()
    {
        return $this->hasMany(Thumb::class, 'user_id');
    }

    public function createUser($data)
    {
    	$user = self::create($data);
    	$this->login($data);
    	return $user;
    }

    public  function login($data)
    {
        if($this->hasTooManyFailedLoginCounts($data['name']))
        {
            return false;
        }
        
    	if(!$user = self::where(['name' => $data['name'], 'password' => md5($data['password'])])->find())
    	{
            $this->setLoginFailedCounts($data['name']);
    		return false;
    	}
		Session::set('user', $user, 'user');
		return true;
    }

    public function scopeListUsers($query, $user = '')
    {
        if(!empty($user))
        {
            $query->where('name', 'like', '%'.$user.'%');
        }
    }
}
