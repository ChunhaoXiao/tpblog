<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\Category;
use think\Validate;
use think\facade\App;
class Cate extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $datas = Category::withCount('articles')->all();
        return view('category/index', ['datas' => $datas]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('category/create');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = $request->only('name') + $request->file();
        $result = $this->validate($data, 'app\admin\validate\Cate');
        if($result !== true)
        {
            return redirect('admin/cate/create')->with('errors', $result);
        }
        if(!empty($data['icon']))
        {
            $data['icon'] = $data['icon']->move('./static/cate')->getSaveName();
        }
        Category::create($data);
        return redirect('/admin/cate');
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        return Category::get($id);
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit(Category $cate)
    {
        return view('category/create', ['cate' => $cate]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->only('name') + $request->file();
        $result = $this->validate($data, 'app\admin\validate\Cate');

        if($result !== true)
        {
            return redirect('admin/cate/create')->with('errors', $result);
        }
        if(!empty($data['icon']))
        {
            $data['icon'] = $data['icon']->move('./static/cate')->getSaveName();
        }
        $category->save($data);
        return redirect('admin/cate/index');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete(Category $category)
    {

        if($a = $category->articles()->find())
        {
            return json(['请先删除分类下的文章'])->code(400);
        }
        $category->delete();
        return json(['success'])->code(200);
    }
}
