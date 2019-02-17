<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\Tag as TagModel;

class Tag extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        $tags = TagModel::search($request->name)->withCount('articles')->order('articles_count', 'desc')->paginate();
        return view('tag/index', ['tags' => $tags]);
        //dump($tags);
    }

   

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        TagModel::destroy($id);
        return json(['status' => 'success']);
    }
}
