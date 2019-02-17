<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Validate;
use app\common\model\Navigator as NavModel;

class Navigator extends Controller
{
    public function index()
    {
        $datas = NavModel::all();
        return view('navigator/index', ['datas' => $datas]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('navigator/create');
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
        $result = $this->validate($data, 'app\admin\validate\Navigator');
      
        if($result !== true)
        {
            return redirect('admin/navigator/create')->with('errors', $result);
        }
        navModel::create($data);
        return redirect('admin/navigator/index');
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit(NavModel $nav)
    {
        return view('navigator/edit', ['nav' => $nav]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, NavModel $nav)
    {
        $data = $request->post();
        $result = $this->validate($data, 'app\admin\validate\Navigator');
        if($result !== true)
        {
            return redirect('admin/navigator/edit', ['id' => $nav->id])->with('errors', $result);
        }
        $nav->save($data);
        return redirect('admin/navigator/index');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        NavModel::destroy($id);
        return json(['success'])->code(200);
    }
}
