<?php

namespace app\common\model;

use think\Model;
use think\File;
use think\facade\Cache;

class Config extends Model
{
    protected $table = 'config';

    protected $createTime = 'created_at';

    protected $updateTime = 'updated_at';

    //需要配置的内容
    public static $configFields = [
    	'title' => [
	    	'type' => 'text', 
	    	'label' => '网站名称',
    	], 
    	'keywords' => [
    	    'type' => 'text',
    	    'label' => '关键字',
    	], 
    	'description' => [
    	    'type' => 'textarea',
    	    'label' => '描述',
    	], 
    	'logo' => [
    	    'type' => 'file',
    	    'label' => 'logo',
    	],
    	'cache_time' => [
    	    'type' => 'text',
    	    'label' => '缓存时长',
    	], 
    	'comment_interval' => [
    	    'type' => 'text',
    	    'label' => '评论间隔时长',
    	],

    	'allow_comment' => [
    		'type' => 'radio', 
    		'label' => '是否开始评论',
    		'options' => ['1' => '开启', '0' => '禁止'],
    	], 

    	'denied_register_ip' => [
    	    'type' => 'textarea',
    	    'label' => '禁止注册IP',
    	],
    ];

    
    public function saveConfig($data)
    {
    	if(!empty($data['logo']))
    	{
    		$logo = $data['logo']->move('./public/static/logo');
    		$data['logo'] = $logo->getSaveName();
    	}
    	$existsConfigs = self::column(null, 'name');
    	$allow_fields = array_keys(self::$configFields);
    	if(!empty($data))
    	{
    		foreach($data as $key => $v)
	    	{
	    		if(in_array($key, $allow_fields))
	    		{
	    			if(isset($existsConfigs[$key]))
		    		{
		    			self::update(['id' => $existsConfigs[$key]['id'], 'value' => $v]);
		    		}
		    		else
		    		{
		    			self::create(['name' => $key, 'value' => $v]);
		    		}
	    		}
	    	}

	    	Cache::rm('config');
    	}
    }

    // public static function init()
    // {
    // 	self::event('after_update', function(){

    // 	});
    // }
}
