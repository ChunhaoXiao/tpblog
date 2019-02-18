<?php

namespace app\common\model;

use think\Model;
use think\facade\Session;
use think\Validate;
//use think\facade\
use think\model\concern\SoftDelete;
class Advertisement extends Model
{
    use SoftDelete;

    protected $table = 'advertisements';

    protected $createTime = 'created_at';

    protected $updateTime = 'updated_at';

    protected $deleteTime = 'deleted_at';
    
    public static $types = [
        'top' => [
            'name' => '顶部广告', 
            'size'=> [350, 100],
        ],
        'under_nav_banner' => [
            'name' => '导航栏下方', 
            'size' => [400, 80],
        ],
        'right_side' => [
            'name' => '右侧边栏', 
            'size' => [200, 80],
        ],
        'article' => [
            'name' => '文章内容内广告', 
            'size' => [450, 80],
        ] ,
    ];

    public function saveAdvertisement($data, $id = null)
    {
        if(empty($data['expire_date']))
        {
            unset($data['expire_date']);
        }
        if(!empty($data['picture']))
        {
            $uploaded = $data['picture']->move('./static/advertisement');
            $data['picture'] = $uploaded->getSaveName();
        }
        if($id)
        {
            $advertisement = self::getOrFail($id);
            return $advertisement->save($data);
        }
        return self::create($data);
    }

    public function scopeSearch($query, $type)
    {
    	if($type)
    	{
    		$query->where('position', $type);
    	}
    }

    public function scopeValid($query)
    {
        $now = date('Y-m-d H:i:s', time());
        $query->where('expire_date', '>', $now)->where('disabled', 0);
    }
}
