<?php

namespace wap\index\model;

use think\Log;
use think\Model;

class Channel extends Model
{
    protected $autoWriteTimestamp = true;

    public function addChannel($name, $type = null, $beginTime = "", $endTime = "")
    {
        if (empty($name) || !in_array($type, ['0', '1', '2'])) {
            return false;
        }
        $beginTime = empty($beginTime) ? time() : strtotime($beginTime);
        $endTime = empty($endTime) ? strtotime('2022-02-02') : strtotime($endTime);
        $this->data([
            'name' => $name,
            'begin_time' => $beginTime,
            'end_time' => $endTime,
            'type' => $type,
            'flag' => 0
        ])->save();
        return $this->id;
    }

    public function getChannelByName($name)
    {
        $find = $this->where(['name' => $name, 'flag' => 1])->cache(60 * 60 * 2)->find();
        if (empty($find)) {
            Log::record("$name channel null");
            return false;
        }
        $time = time();
        if ($time < $find->begin_time || $time > $find->end_time) {
            Log::record("$name 通道不在时间范围!");
            return false;
        }
        if ($find->type == '0' && empty($find->url)) {
            return false;
        }
        return $find;
    }
}