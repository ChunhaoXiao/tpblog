<?php
namespace app\admin\services;
use app\common\model\Article;
use app\common\model\Tag;
use think\Db;
class ArticleService
{
	public function listArticles($where = [])
	{
		return Article::search($where)->order('is_top', 'desc')->order('articles.id', 'desc')->with('category')->paginate(10);
	}

	//保存文章(新建/更新)
	public function saveArticle($data, $id = null)
	{
		if($id)
		{
			$article = Article::get($id);
			$data['is_top'] = empty($data['is_top']) ? 0 : 1;
			$article->save($data);
		}
		else
		{
			$article = Article::create($data, true);
		}

		if(!empty($data['tags']))
		{
			$tagIds = $this->saveTags($data['tags']);
			if($tagIds)
			{
				$article->syncTags($tagIds);
			}
		}

		if(!empty($data['cover_picture']))
		{
			$fileName = $data['cover_picture']->move('./public/static/uploads')->getSaveName();
			//dump($fileName);
			$article->setCover($fileName);
		}
		return $article;
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