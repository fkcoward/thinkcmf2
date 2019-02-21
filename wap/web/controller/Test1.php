<?php

namespace wap\web\controller;

use cmf\controller\BaseController;

class Test1 extends BaseController
{
    public function index()
    {
//        $this->redirect("http://www.baidu.com",302);
//        return $this->fetch();
//        dump($this->request->param());
//        echo "11";exit();
//        session('phone',$this->request->param('phone'));
//        echo 1;
        dump(session('phone','123'));
    }

    public function ttt()
    {
        dump(session('phone'));
    }
}