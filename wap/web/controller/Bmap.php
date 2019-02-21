<?php
/**
 * Created by PhpStorm.
 * User: coward
 * Date: 2019-1-28
 * Time: 17:07
 * 百度地图
 */

namespace wap\web\controller;


use cmf\controller\BaseController;
use cmf\controller\HomeBaseController;

class Bmap extends BaseController
{
    public function index()
    {
        $phone=$this->request->param('phone');
        session('phone',$phone);
        $this->assign('phone',$phone);
        return $this->fetch();
    }
}