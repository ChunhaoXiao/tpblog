<?php
namespace app\common\services;
use app\common\model\Article;
use app\admin\model\Tag;
use think\Db;
class ArticleService
{
	public function listArticles($where = [])
	{
		return Article::search($where)->order('is_top', 'desc')->order('articles.id', 'desc')->with(['cover', 'category', 'tags'])->paginate(10);
	}

	//保存文章(新建/更新)
	public function save($data, $id = null)
	{
		if($id)
		{
			$article = Article::get($id);
			$data['is_top'] = empty($data['is_top']) ? 0 : 1;
			$article->save($data);
		}
		else
		{
			$article = Article::create($data);
		}

		if(!empty($data['tags']))
		{
			$tagIds = $this->saveTags($data['tags']);
			if($tagIds)
			{
				$article->syncTags($tagIds);
			}
		}

		if(!empty($data['path']))
		{
			$article->setCover($data['path']);
		}
		return $article;
	}

	public function find($id)
	{
		return Article::with([
			'category', 
			'cover',
			'tags', 
			'comments' => function($query){
			    $query->with('user')->order('id')->limit(25);
		    }
	    ])->getOrFail($id);
	}

	protected function saveTags($data)
	{
		if(!empty($data))
		{
			$datas = str_replace([' ', ',', '，'], ',', $data);
			$datas = array_map('trim', explode(',', $datas));
			$exists = Tag::whereIn('name', $datas)->column('name', 'id');
			$newTags = array_diff($datas, $exists);
			$newTagsId = [];
		    if($newTags)
			{
				foreach ($newTags as $value) {
					if($value)
					{
						$row['name'] = $value;
					    $tags[] = $row;
					}
				}
				$tag = new Tag;
				$allTags = $tag->saveAll($tags);
				$newTagsId = $allTags->column('id');
			}
			return array_merge(array_keys($exists), $newTagsId);
		}
		return [];
	}
}