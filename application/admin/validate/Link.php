<?php

namespace app\admin\validate;

use think\Validate;

class Link extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'name' => 'require|max:20',
        'url' => 'require|max:60',
        'display_order' => 'number',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'name.require' => '链接名称不能为空',
        'name.max' => '链接名称最多 20 个字',
        'url.require' => '链接地址不能为空',
        'url.max' => '链接地址最长60字符',
        'display_order.number' => '链接排序必须是数字',
    ];
}
