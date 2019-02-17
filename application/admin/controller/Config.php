<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Validate;
use app\common\model\Config as ConfigModel;

class Config extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create(ConfigModel $config)
    {
        $configFields = ConfigModel::$configFields;
        $data = $config::column('value', 'name');

        return view('config/create', [
            'data' => $data, 
            'config_fields' => $configFields,
        ]);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request, ConfigModel $config)
    {
        $validator = Validate::make([
            'logo' => 'image',
            'cache_time' => 'integer',
            'comment_interval' => 'integer',
        ]);
        $data = $request->post();
        if(!$validator->check($data))
        {
            return redirect()->with('errors', $validator->getError());
        }
        if($request->has('logo', 'file'))
        {
            $data['logo'] = $request->file('logo');
        }
        $config->saveConfig($data);
        return redirect('admin/config/create')->with('status', 'success');
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
        //
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
        //
    }
}
