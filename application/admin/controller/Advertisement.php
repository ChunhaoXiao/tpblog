<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Validate;
use app\common\model\Advertisement as AdvertisementModel;

class Advertisement extends Controller
{
    //Pprotected $failException = true;
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        $datas = AdvertisementModel::search($request->type)->all();
        return view('advertisement/index', ['datas' => $datas]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('advertisement/create');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request, AdvertisementModel $advertisement)
    {
        $data = $request->post() + $request->file();
        $result = $this->validate($data, 'app\admin\validate\Advertisement');
        if($result !== true)
        {
            return redirect('admin/advertisement/create')->with('errors', $result);
        }
        $advertisement->saveAdvertisement($data);
        return redirect('admin/advertisement/index');
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
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
        $adv = AdvertisementModel::getOrFail($id);
        return view('advertisement/edit', ['advertisement' => $adv]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, AdvertisementModel $advertisement, $id)
    {
        $data = $request->post() + $request->file();
        $result = $this->validate($data, 'app\admin\validate\Advertisement.edit');
        if($result !== true)
        {
            return redirect('admin/advertisement/edit', ['id' => $id])->with('errors', $result);
        }
        $advertisement->saveAdvertisement($data, $id);
        return redirect('admin/advertisement/index');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        AdvertisementModel::destroy($id);
        return json(['success'])->code(204);
    }
}
