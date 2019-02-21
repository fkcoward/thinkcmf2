<?php

namespace app\channel\controller;

use app\channel\model\Channel;
use cmf\controller\AdminBaseController;
use think\Db;

class IndexController extends AdminBaseController
{
    public function listChannel()
    {
        $where   = [];
        $request = input('request.');

        $keywordComplex = [];
        if (!empty($request['keyword'])) {
            $keyword = $request['keyword'];

            $keywordComplex['name|url']    = ['like', "%$keyword%"];
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
        if(request()->isPost()){
            $result=$this->validate(request()->param(),'app\channel\validate\ChannelValidate');
            if(true!==$result){
                $this->error($result);
            }
            $chl=new Channel();
            if($chl->addChannel($this->request->param())){
                $this->success("添加成功",url("index/listChannel"));
            }else{
                $this->error("添加失败");
            }
        }else{
            $this->assign('default_begin_time',date("Y-m-d H:i",time()));
            $this->assign('default_end_time',date("Y-m-d H:i",strtotime('2022-02-02')));
            return $this->fetch();
        }

    }

    public function editChannel()
    {
        if(request()->isPost()){
            $result=$this->validate(request()->param(),'app\channel\validate\ChannelValidate');
            if(true!==$result){
                $this->error($result);
            }
            $chl=new Channel();
            if($chl->saveChannel($this->request->param())){
                $this->success("更新成功",url("index/listChannel"));
            }else{
                $this->error("更新失败");
            }
        }else{
            $id=$this->request->param('id');
            if(empty($id)){
                $this->error("参数错误");
            }
            $find=Channel::get($id)->toArray();
            $find['begin_time']=date("Y-m-d H:i",$find['begin_time']);
            $find['end_time']=date("Y-m-d H:i",$find['end_time']);
            $this->assign($find);
            return $this->fetch();
        }

    }
}