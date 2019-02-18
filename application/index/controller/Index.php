<?php
namespace app\index\controller;
use app\common\services\ArticleService;
use think\Request;
use think\facade\Session;
use think\facade\Hook;

class Index
{
	private $articleService;

	public function __construct(ArticleService $service)
	{
		$this->articleService = $service;
	}

    public function index(ArticleService $articleService, Request $request)
    {
        //
    	$articles = $this->articleService->listArticles($request->get());
        return view('index/index', ['articles' => $articles]);
    }

    public function show($id)
    {
    	$article = $this->articleService->find($id);
    	return view('index/show', ['article' => $article]);
    }
}
