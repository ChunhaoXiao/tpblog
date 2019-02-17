<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Validate;
use app\common\model\Category;
use app\common\model\Article as ArticleModel;
use app\admin\services\ArticleService;
//use app\common\model\Article;

class Article extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request, ArticleService $service)
    {
        $datas = $service->listArticles($request->param());
        return view('article/index', ['datas' =>$datas]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('article/create');
    }

    /**
     * 新增文章
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request, ArticleService $service)
    {
        $data = $request->post() + $request->file();
        $result = $this->validate($data, 'app\admin\validate\Article');
        if($result !== true)
        {
            return redirect('admin/article/create')->with('errors', $result);
        }
        $service->saveArticle($data);
        return redirect('admin/article/index');
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read(ArticleModel $id)
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
        $article = ArticleModel::with(['tags', 'cover'])->get($id);
        return view('article/edit', ['article' => $article]);
    }

    /**
     * 更新资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, ArticleService $service, $id)
    {
        $data = $request->post() + $request->file();
        $result = $this->validate($data, 'app\admin\validate\Article');
        if($result !== true)
        {
            return redirect('admin/article/edit', ['id' => $id])->with('errors', $result);
        }
        $service->saveArticle($data, $id);
        return redirect('admin/article/index');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete(ArticleModel $article)
    {   
        $article->delete();
        return json(['message' => '删除成功', 'status' => 1]);
    }
}
