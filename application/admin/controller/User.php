<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\User as UserModel;

class User extends Controller
{
    private $user;

    public function __construct(UserModel $user)
    {
        $this->user = $user;
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        $users = $this->user->listUsers($request->name)->withCount(['comments', 'thumbs'])->paginate();
       return view('user/index', ['datas' => $users]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, UserModel $user)
    {
        if(empty($request->email))
        {
            return json(['email不能为空'])->code(422);
        }
        $data['email'] = $request->email;
        if(!empty($request->password))
        {
            $data['password'] = $request->password;
        }
        $user->save($data);
        return json(['修改成功'])->code(200);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete(UserModel $user)
    {
        $user->delete();
        return json(['success'])->code(200);
    }
}
