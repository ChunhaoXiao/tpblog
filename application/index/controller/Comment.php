<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Validate;
use app\common\model\Comment as CommentModel;
//use app\common\model\Article;

class Comment extends Controller
{
    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request, $id)
    {
        //exit('asdasdasd');
        $validator = Validate::make([
            'content' => 'require|max:500',
        ]);
        $data = $request->post();
        if(!$validator->check($data))
        {
            return json(['status' => 0, 'errors' => $validator->getError()]);
        }
        $article = new \app\common\model\Article;
        $article->addComment($data, $id);
        return json(['status' => 1]);
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
        $comment = CommentModel::get($id);
        if($comment->canDelete())
        {
            $comment->delete();
            return json(['success'])->code(200);
        }
        return json(['unauthorized'])->code(403);
    }   
}
