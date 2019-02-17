<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Upload extends Controller
{
    /*
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {

        $file = $request->file('image');
        $info = $file->validate(['size'=>2000000,'ext'=>'jpg,png,gif'])->move( './public/upload');
        if($info)
        {
            echo config('app_host').'/upload/'.$info->getSaveName();
        }
        else
        {
            echo $file->getError();
        }
        
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
