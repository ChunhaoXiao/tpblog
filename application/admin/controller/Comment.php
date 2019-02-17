<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\Comment as CommentModel;

class Comment extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        $comments = CommentModel::keyword($request->keyword)->article($request->article_id)->user($request->user)->with(['article', 'user'])->order('id','desc')->paginate();
        return view('comment/index', ['datas' => $comments]);
    }


    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete(CommentModel $comment)
    {
        $comment->delete();
        return json(['success'])->code(200);
    }
}
