<?php

namespace app\channel\controller;

use app\channel\model\Category;
use app\channel\model\Channel;
use cmf\controller\AdminBaseController;
use think\Db;

class IndexController extends AdminBaseController
{
    public function listChannel()
    {
        $where = [];
        $request = input('request.');

        $keywordComplex = [];
        if (!empty($request['keyword'])) {
            $keyword = $request['keyword'];

            $keywordComplex['name|url|nickname'] = ['like', "%$keyword%"];
        }
        if (isset($request['flag']) && $request['flag'] != '-1') {
            $where['flag'] = $request['flag'];
            $this->assign('flag', $where['flag']);
        } else {
            $this->assign('flag', '-1');
        }
        if (isset($request['type']) && $request['type'] != '-1') {
            $where['type'] = $request['type'];
            $this->assign('type', $where['type']);
        } else {
            $this->assign('type', '-1');
        }
        $channelQuery = Db::name('channel');

        $list = $channelQuery->whereOr($keywordComplex)->where($where)->order("create_time DESC")->paginate(20);
        // 获取分页显示
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch();
    }

    public function addChannel()
    {
        if (request()->isPost()) {
            $result = $this->validate(request()->param(), 'app\channel\validate\ChannelValidate');
            if (true !== $result) {
                $this->error($result);
            }
            $chl = new Channel();
            if ($chl->addChannel($this->request->param())) {
                $this->success("添加成功", url("index/listChannel"));
            } else {
                $this->error("添加失败");
            }
        } else {
            $this->assign('default_begin_time', date("Y-m-d H:i", time()));
            $this->assign('default_end_time', date("Y-m-d H:i", strtotime('2022-02-02')));
            return $this->fetch();
        }

    }

    public function editChannel()
    {
        if (request()->isPost()) {
            $result = $this->validate(request()->param(), 'app\channel\validate\ChannelValidate');
            if (true !== $result) {
                $this->error($result);
            }
            $chl = new Channel();
            if ($chl->saveChannel($this->request->param())) {
                $this->success("更新成功", url("index/listChannel"));
            } else {
                $this->error("更新失败");
            }
        } else {
            $id = $this->request->param('id');
            if (empty($id)) {
                $this->error("参数错误");
            }
            $find = Channel::get($id)->toArray();
            $find['begin_time'] = date("Y-m-d H:i", $find['begin_time']);
            $find['end_time'] = date("Y-m-d H:i", $find['end_time']);
            $this->assign($find);
            return $this->fetch();
        }

    }

    public function channelToExcel()
    {
        $type_arr = [
            0 => '直接H5',
            1 => '对接H5',
            2 => '对接api',
            3 => '非对称加密'
        ];

        $where = [];
        $request = input('request.');

        $keywordComplex = [];
        if (!empty($request['keyword'])) {
            $keyword = $request['keyword'];

            $keywordComplex['name|url|nickname'] = ['like', "%$keyword%"];
        }
        if (isset($request['flag']) && $request['flag'] != '-1') {
            $where['flag'] = $request['flag'];
        }
        if (isset($request['type']) && $request['type'] != '-1') {
            $where['type'] = $request['type'];
        }
        $channelQuery = Db::name('channel');

        $list = $channelQuery->whereOr($keywordComplex)->where($where)->field("create_time,update_time,name,nickname,begin_time,end_time,type,flag,url,class_name")->order("create_time DESC")->select();
        $list = $list->toArray();
        foreach ($list as &$value) {
            $value['create_time'] = date("Y-m-d H:i", $value['create_time']);
            $value['update_time'] = date("Y-m-d H:i", $value['update_time']);
            $value['begin_time'] = date("Y-m-d H:i", $value['begin_time']);
            $value['end_time'] = date("Y-m-d H:i", $value['end_time']);
            $value['type'] = $type_arr[$value['type']];
            $value['flag'] = $value['flag'] == '1' ? '正常' : '关闭';
            $value['outurl'] = $_SERVER['SERVER_NAME'] . "/" . $value['name'];
        }
        $head = [
            '创建时间',
            '更新时间',
            '名',
            '中文名',
            '生效时间',
            '失效时间',
            '类型',
            '状态',
            '下游地址',
            '类名',
            '对外地址'
        ];
        arrayToExcel($head, $list);
    }

    public function addCategory()
    {
        if(request()->isPost()){
            $result = $this->validate(request()->param(), 'app\channel\validate\CategoryValidate');
            if (true !== $result) {
                $this->error($result);
            }
            $cat = new Category();
            if ($cat->addCategory($this->request->param())) {
                $this->success("添加成功", url("index/listChannel"));
            } else {
                $this->error("添加失败");
            }
        }else{
            return $this->fetch();
        }
    }
}