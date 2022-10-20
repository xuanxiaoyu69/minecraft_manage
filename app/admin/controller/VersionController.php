<?php

namespace app\admin\controller;

use app\admin\model\VersionModel;
use cmf\controller\AdminBaseController;
use QL\QueryList;
use think\facade\Db;

/**
 * Class VersionController
 * @package app\admin\controller
 * @adminMenuRoot(
 *     'name'   =>'版本',
 *     'action' =>'index',
 *     'parent' =>'',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   =>'paper-plane',
 *     'remark' =>''
 * )
 */
class VersionController extends AdminBaseController
{
    public function index()
    {
        $model = new VersionModel();
        $release_list = $model->where('group', 'release')->where('deletetime', 0)->order('id desc')->select();
        $snapshot_list = $model->where('group', 'snapshot')->where('deletetime', 0)->order('id desc')->select();

        $this->assign('release_list', $release_list);
        $this->assign('snapshot_list', $snapshot_list);
        return $this->fetch();
    }

    public function refresh()
    {
        $model = new VersionModel();
        $insert_all = [];
        $ql = QueryList::get('https://mcversions.net/');

        $data = $ql->find('h5:eq(0)')->_next('div')->find('div')->attrs('id');
        $res = array_reverse(array_values(array_filter($data->all())));
        foreach ($res as $k => $v) {
            $check = $model->where("name = '$v'")->find();
            if(empty($check)){
                $ss = $ql->find('div[id="'.$v.'"]')->find('time')->attr('datetime');
                $ss = strtotime($ss);

//            $download_url = QueryList::get('https://mcversions.net/download/' . $v)->find('a[download="minecraft_server-'.$v.'.jar"]')->attr('href');
                $insert_all[] = [
                    'name' => $v,
                    'release_time' => $ss,
                    'download_url' => '',
                    'group' => 'release',
                    'addtime' => time(),
                    'updatetime' => time(),
                ];
            }
        }

        $data = $ql->find('h5:eq(1)')->_next('div')->find('div')->attrs('id');
        $res = array_reverse(array_values(array_filter($data->all())));
        foreach ($res as $k => $v) {
            $check = $model->where("name = '$v'")->find();
            if(empty($check)) {
                $ss = $ql->find('div[id="' . $v . '"]')->find('time')->attr('datetime');
                $ss = strtotime($ss);

//            $download_url = QueryList::get('https://mcversions.net/download/' . $v)->find('a[download="minecraft_server-'.$v.'.jar"]')->attr('href');
                $insert_all[] = [
                    'name' => $v,
                    'release_time' => $ss,
                    'download_url' => '',
                    'group' => 'snapshot',
                    'addtime' => time(),
                    'updatetime' => time(),
                ];
            }
        }

        if(!empty($insert_all)){
            Db::name('version')->insertAll($insert_all);
            $this->success('更新成功');
        }else{
            $this->error('没有需要更新的数据');
        }
    }

    public function delete()
    {
        $id = input('id');
        if(empty($id)){
            $this->error('id不能为空');
        }

        $model = new ServerModel();
        $server = $model->find($id);
        $server->deletetime = time();
        $server->save();

        $this->success('删除成功');
    }
}