<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Validate;
use app\common\model\User;
use think\facade\Session;

class Login extends Controller
{
    

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('user/login');
    }

    public function save(Request $request, User $user)
    {
        $validator = Validate::make([
            'name' => 'require',
            'password' => 'require',
        ]);
        $data = $request->only(['name', 'password']);
        if(!$validator->check($data))
        {
            return redirect('index/login/create')->with('errors', $validator->getError());
        }
    
        if(!$user->login($data))
        {
            return redirect('index/login/create');
        }
        return redirect('/');
    }


    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete()
    {
        if(Session::has('user', 'user'))
        {
            Session::delete('user', 'user');
        }
        return true;
    }
}
