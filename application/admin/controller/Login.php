<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Validate;
use app\common\model\Admin;
use think\facade\Session;

class Login extends Controller
{
    public function create()
    {
        return view('login/login');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request, Admin $admin)
    {
        $validator = Validate::make([
            'name' => 'require',
            'password' => 'require',
        ]);
        $data = $request->only(['name', 'password']);
        if(!$validator->check($data))
        {
            return redirect('admin/login/create')->with('errors' , $validator->getError());
        }
        if(!$admin->login($data))
        {
            return redirect('admin/login/create');
        }
        return redirect('admin/index/index');
    }

    /*
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete()
    {
        if(Session::has('admin', 'admin'))
        {
            Session::delete('admin', 'admin');
            return true;
        }
    }
}
