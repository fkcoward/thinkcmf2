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

    public function countTodayCharts()
    {
        $beginTime = strtotime("-1 day");
        $list = Db::name("access_log_count")->where('begin', '<', $beginTime)->cache(600)->group("path_info")->field("path_info,sum(num) as num")->order("num asc")->select();
        $channle = Db::name('channel')->cache(true)->column("nickname", 'name');

        $list->each(function ($item, $key) use ($channle) {
            $item['path_info'] = empty($channle[$item['path_info']]) ? '' : $channle[$item['path_info']];
            return $item;
        });
        $y_data = [];
        $data = [];
        $bing_data = [];
        foreach ($list as $key => $value) {
            $y_data[] = $value['path_info'];
            $data[] = $value['num'];
            $bing_data[] = ['name' => $value['path_info'], 'value' => $value['num']];
        }
        $this->assign('height', $list->count() * 50);
        $this->assign('y_data', json_encode($y_data));
        $this->assign('data', json_encode($data));
        $this->assign('bing_data', json_encode($bing_data));
        return $this->fetch();
    }

    public function lineChartHours()
    {
        $arr=$this->lineChart("hours");
        $this->assign("keys",json_encode(array_keys($arr)));
        $this->assign("values",json_encode(array_values($arr)));
        return $this->fetch();
    }

    private function lineChart($type = "hours")
    {
        if (strtolower($type) == "hours") {
            $limitTime = strtotime("-1 day");
        }
        $list = Db::name("access_log_count")->where('begin', '>=', $limitTime)->cache(600)->group("begin")->field("begin,sum(num) as num")->order("begin asc")->select();
        $list2 = [];
        foreach ($list as $value) {
            $list2[$value['begin']] = $value['num'];
        }
        $data_arr = [];
        $theTime = time();
        while ($limitTime < $theTime) {
            $h = date("H", $limitTime);
            $data_arr[$h] = 0;
            foreach ($list2 as $key => $val) {
                if ($key >= $limitTime && $key < $limitTime + 3600) {
                    $data_arr[$h] += empty($val) ? 0 : $val;
                } else if ($key >= $limitTime + 3600) {
                    break;
                }
            }

            $limitTime += 3600;
        }
        return $data_arr;
    }
}