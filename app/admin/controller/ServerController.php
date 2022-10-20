<?php

namespace app\admin\controller;

use app\admin\model\ServerModel;
use cmf\controller\AdminBaseController;

/**
 * Class ServerController
 * @package app\admin\controller
 * @adminMenuRoot(
 *     'name'   =>'服务器',
 *     'action' =>'index',
 *     'parent' =>'',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   =>'server',
 *     'remark' =>''
 * )
 */
class ServerController extends AdminBaseController
{
    public function index()
    {
        $model = new ServerModel();
        $list = $model->where('deletetime', 0)->paginate(10);
        // 获取分页显示
        $page = $list->render();

        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }

    public function link()
    {
        $id = input('id');
        if(empty($id)){
            $this->error('id不能为空');
        }

        $model = new ServerModel();
        $data = $model->find($id);
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function add()
    {
        return $this->fetch();
    }

    public function addPost()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();

            $result = $this->validate($data, 'Server');
            if ($result !== true) {
                $this->error($result);
            }

            if(empty($data['pass']) && empty($data['key'])){
                $this->error('服务器密码与服务器证书必须选择一个');
            }

            $model = new ServerModel();
            $res = $model->save($data);
            if($res){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }
    }

    public function edit()
    {
        $id = input('id');
        if(empty($id)){
            $this->error('id不能为空');
        }

        $model = new ServerModel();
        $data = $model->find($id);
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function editPost()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if(empty($data['id'])){
                $this->error('id不能为空');
            }

            $result = $this->validate($data, 'Server');
            if ($result !== true) {
                $this->error($result);
            }

            if(empty($data['pass']) && empty($data['key'])){
                $this->error('服务器密码与服务器证书必须选择一个');
            }

            $model = new ServerModel();
            $res = $model->update($data);
            if($res){
                $this->success('编辑成功');
            }else{
                $this->error('编辑失败');
            }
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

    public function command()
    {
        \Ratchet\Client\connect('ws://mc.test:8080')->then(function($conn) {
            $conn->on('message', function($msg) use ($conn) {
                echo "Received: {$msg}\n";
                $conn->close();
            });

            $conn->send(json_encode(['to'=>['to' => 51, 'data' => 'java --version']]));
            $conn->send(json_encode(['to'=>['to' => 51, 'data' => "\r"]]));
        }, function ($e) {
            echo "Could not connect: {$e->getMessage()}\n";
        });
    }
}