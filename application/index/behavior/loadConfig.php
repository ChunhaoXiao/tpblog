<?php
namespace app\index\behavior;
use app\common\model\Config;
use think\facade\Cache;

class loadConfig
{
	public function run()
	{
		/*if(!$configs = Cache::get('config'))
		{
			$configs = Config::column('value', 'name');
			Cache::set('config', $configs);//永久缓存 除非后台更新设置
		}*/
	}
}