<?php
namespace app\admin\validate;
use think\Validate;
class Navigator extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'name' => 'require|max:10',
        'url' => 'require|max:60',
        'display_order' => 'integer',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'name.require' => '导航名称不能为空',
        'name.max' => '导航名称最多10个字',
        'url.require' => '导航链接不能为空',
        'url.max' => '导航链接最长60个字',
        'display_order' => '导航排序必须是数字',
    ];
}
