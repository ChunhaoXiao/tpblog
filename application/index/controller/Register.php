<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Validate;
use app\common\model\User;

class Register extends Controller
{
    

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('user/create');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request, User $user)
    {
        $validator = Validate::make([
            'name' => 'require|min:3|max:20|unique:users',
            'password' => 'require|min:6|max:20|confirm',
            'email' => 'email|unique:users',
        ]); 
        $data = $request->param();
        if(!$validator->check($data))
        {
           return redirect('index/register/create')->with('errors', $validator->getError());
        }
        $user = $user->createUser($data);
        return redirect('/');
    }
}
