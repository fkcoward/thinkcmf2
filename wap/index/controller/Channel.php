<?php

namespace wap\index\controller;


use wap\index\channel\Factory;

class Channel
{
    protected static $instance;
    private $name;
    private $phone;

    function __construct($name, $phone)
    {
        $this->name = $name;
        $this->phone = $phone;
    }

    public static function create($name, $phone)
    {
        if (empty($name) || empty($phone)) {
            return false;
        }
        if (is_null(self::$instance)) {
            self::$instance = new static($name, $phone);
        }
        return self::$instance;
    }

    public function go()
    {
        $this->judgeType();

    }

    private function judgeType()
    {
        $model = new \wap\index\model\Channel();
        $find = $model->getChannelByName($this->name);
        if (empty($find)) {
            throw new \think\exception\HttpException(404, '参数错误');
        }
        if ($find->type == '0') {
            //纯h5
            dump(redirect($find->url)->send());
        } elseif ($find->type == '1') {
            //需要加密等操作
            $factory = new Factory();
            $chl = $factory->createChannel(ucfirst(strtolower($find->class_name)), [
                'channel_arr' => $find->toArray(),
                'name' => $this->name,
                'phone' => $this->phone
            ]);
            $chl->go();
        } elseif ($find->type == '2') {
            //自己写的
            //            dump(request());
            redirect(request()->domain() . "/web/" . ucfirst(strtolower($find->class_name)) . "/index?phone=" . $this->phone)->send();
            //            redirect(url('Test111/index'))->send();
        } else {
            throw new \think\exception\HttpException(404, '参数错误');
        }
    }

}