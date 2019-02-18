<?php
namespace app\index\behavior;
use app\common\model\Config;
use think\facade\Cache;

class loadConfig
{
	public function run()
	{
		if(!$configs = Cache::get('config'))
		{
			//初始化
			$keys = array_keys(Config::$configFields);

			$configDatas = Config::column('value', 'name');

			foreach($keys as $key)
			{
				$cacheConfigData[$key] = $configDatas[$key] ?? '';
			}
			Cache::set('config', $cacheConfigData);//永久缓存 除非后台更新设置
		}
	}
}