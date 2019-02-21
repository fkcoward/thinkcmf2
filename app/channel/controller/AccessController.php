<?php

namespace app\channel\controller;

use cmf\controller\AdminBaseController;
use think\Db;

class AccessController extends AdminBaseController
{
    public function listTodayLogs()
    {
        $where = [];
        $request = input('request.');

        $keywordComplex = [];
        if (!empty($request['keyword'])) {
            $keyword = $request['keyword'];

            $keywordComplex['name|url'] = ['like', "%$keyword%"];
        }
        $channelQuery = Db::name('access_log_today');

        $list = $channelQuery->whereOr($keywordComplex)->where($where)->order("request_time DESC")->paginate(20);
        // 获取分页显示
        $channle = Db::name('channel')->cache(true)->column("nickname", 'name');

        $list->each(function ($item, $key) use ($channle) {
            $item['nickname'] = empty($channle[$item['path_info']]) ? '' : $channle[$item['path_info']];
            return $item;
        });
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('channel', $channle);
        // 渲染模板输出
        return $this->fetch();
    }
}