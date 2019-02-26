<?php

namespace app\channel\model;

use think\Log;
use think\Model;

class Category extends Model
{
    protected $autoWriteTimestamp = true;
    protected $table = "fsd_channel_category";

    public function addCategory($data)
    {
        if (empty($data['cname'])) {
            return false;
        }
        if (!isset($data['pid'])) {
            $data['pid'] = 0;
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