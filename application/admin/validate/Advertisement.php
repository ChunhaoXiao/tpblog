<?php

namespace app\admin\validate;

use think\Validate;

class Advertisement extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'name' => 'require|max:100',
        'position' => 'require',
        'link' => 'require',
        'expire_date' => 'date',
        'picture' => 'require|image',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'name.required' => '描述不能为空',
        'position' => '请选择广告位置',
        'name.max' => '描述最多100个字符',
        'link' => '链接地址不能为空',
        'expire_date.date' => '到期时间格式不正确',
        'picture.image' => '只能上传图片格式的文件',
    ];

    public function sceneEdit()
    {
        return $this->remove('picture', 'require');
    }    
}
