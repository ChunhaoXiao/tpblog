<?php
namespace app\index\behavior;
use app\admin\model\Navigator;
use think\facade\View;
use app\common\model\Article;
use app\common\model\Comment;
use app\common\model\Link;
use think\facade\Cache;
use app\common\model\Advertisement;

class setTemplateSharedValue
{
	public function run()
	{	
		//dump(request()->method());
		$title = $this->getTitle();
		View::share('title', $title);
		//导航栏
		if(!$datas = Cache::get('navs'))
		{
			$datas = Navigator::order('display_order')->all();
			Cache::set('navs', $datas, 600);
		}
		View::share('navs', $datas);

		//最受欢迎的文章
		
		if(!$favoriteArticles = Cache::get('favorites'))
		{
			$favoriteArticles = Article::withCount(['thumbs' => function($query){$query->where('type', 'up');}])->order('thumbs_count', 'desc')->limit(5)->all();
			Cache::set('favorites', $favoriteArticles, 600);
		}
		View::share('favorite_articles', $favoriteArticles);

		//评论最多的文章
		
		if(!$mostCommentedArticles = Cache::get('mostcommented'))
		{
			$mostCommentedArticles = Article::withCount('comments')->order('comments_count', 'desc')->limit(5)->all();
			Cache::set('mostcommented', $mostCommentedArticles, 300);
		}
		
		View::share('most_commented_articles', $mostCommentedArticles);

		//友情链接
		
		if(!$links = Cache::get('links'))
		{
			$links = Link::order('display_order')->enabled()->all();
			Cache::set('links', $links, 600);
		}
		
		View::share('links', $links);

		//广告
		if(!$ads = Cache::get('ads'))
		{
			$ads = Advertisement::valid()->all();
	        $ads = $ads->column(null, 'position');
	        Cache::set('ads', $ads, 600);
		}
		View::share('ads', $ads);
		//最新评论
		$latestComments = Comment::order('created_at', 'desc')->group('article_id')->limit(3)->with('article')->all();
		View::share('latestCommentedArticles', $latestComments);
	}

	private function getTitle()
	{
		if(strpos(request()->baseUrl(), 'admin') === false && request()->method() =='GET'){
			$title = '';
			if($para = request()->param())
			{
				switch(key($para))
				{
					case 'tag':
					$title = $para['tag'];
					break;
					case 'category':
					$title = \app\common\model\Category::where('id', $para['category'])->value('name');
					break;
					case 'id':
					$title = \app\common\model\Article::where('id', $para['id'])->value('title');
					break;
				}
				return $title;
			}

			if(request()->baseUrl() == '/reg')
			{
				return '用户注册';
			}
			if(request()->baseUrl() == '/login')
			{
				return '用户登录';
			}
			return '首页';
	    }
	}
}