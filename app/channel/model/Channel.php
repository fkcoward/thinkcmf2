<?php

namespace app\channel\model;

use think\Log;
use think\Model;

class Channel extends Model
{
    protected $autoWriteTimestamp = true;
    protected $table = "fsd_channel";

    public function addChannel($data)
    {
        if (empty($data['name']) || !in_array($data['type'], ['0', '1', '2'])) {
            return false;
        }
        $data['begin_time'] = empty($data['begin_time']) ? time() : strtotime($data['begin_time']);
        $data['end_time'] = empty($data['end_time']) ? strtotime('2022-02-02') : strtotime($data['end_time']);
        if (isset($data['url'])) {
            $data['url'] = htmlspecialchars_decode($data['url']);
        }
        $this->data($data)->allowField(true)->save();
        return $this->id;
    }

    public function getChannelByName($name)
    {
        $find = $this->where(['name' => $name, 'flag' => 1])->find();
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

    public function getChannelById($id)
    {
        $find = $this->where("id", $id)->find();
        return $find->toArray();

    }

    public function saveChannel($data)
    {
        $id = $data['id'];
        unset($data['id']);
        $i = $this->allowField(true)->save($data, ['id' => $id]);
        return $i;
    }
}