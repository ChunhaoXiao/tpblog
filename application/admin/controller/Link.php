<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Validate;
use app\common\model\Link as LinkModel;

class Link extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $links = LinkModel::all();
        return view('link/index', ['links' => $links]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('link/create');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = $request->post();
        $validate_result = $this->validate($data, 'app\admin\validate\Link');
        if($validate_result !== true)
        {
            return redirect('admin/link/create')->with('errors', $validate_result);
        }
        LinkModel::create($data);
        return redirect('admin/link/index');
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
        $link = LinkModel::getOrFail($id);
        return view('link/edit', ['link' => $link]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, LinkModel $link)
    {
        $data = $request->post();
        $validate_result = $this->validate($data, 'app\admin\validate\Link');
        if($validate_result !== true)
        {
            return redirect('admin/link/edit', ['id' => $link->id])->with('errors', $validate_result);
        }
        $link->save($data);
        return redirect('admin/link/index');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete(LinkModel $link)
    {
        $link->delete();
        return json(['success'])->code(204);
    }
}
