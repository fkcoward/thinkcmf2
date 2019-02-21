<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 小夏 < 449134904@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\Db;
use app\admin\model\Menu;

class MainController extends AdminBaseController
{

    /**
     *  后台欢迎页
     */
    public function index()
    {
        $sys_info=$this->osinfo();
        $sys_info['当前浏览器'] = $this->get_broswer();

        //        $this->assign('dashboard_widgets', $dashboardWidgets);
        //        $this->assign('dashboard_widget_plugins', $dashboardWidgetPlugins);
        //        $this->assign('has_smtp_setting', empty($smtpSetting) ? false : true);
        $this->assign('sys_info',$sys_info);
        return $this->fetch();
    }

    public function dashboardWidget()
    {
        $dashboardWidgets = [];
        $widgets = $this->request->param('widgets/a');
        if (!empty($widgets)) {
            foreach ($widgets as $widget) {
                if ($widget['is_system']) {
                    array_push($dashboardWidgets, ['name' => $widget['name'], 'is_system' => 1]);
                } else {
                    array_push($dashboardWidgets, ['name' => $widget['name'], 'is_system' => 0]);
                }
            }
        }

        cmf_set_option('admin_dashboard_widgets', $dashboardWidgets, true);

        $this->success('更新成功!');

    }


    private function get_broswer()
    {
        $sys = $_SERVER['HTTP_USER_AGENT'];  //获取用户代理字符串
        if (stripos($sys, "Firefox/") > 0) {
            preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
            $exp[0] = "Firefox";
            $exp[1] = $b[1];    //获取火狐浏览器的版本号
        } elseif (stripos($sys, "Maxthon") > 0) {
            preg_match("/Maxthon\/([\d\.]+)/", $sys, $aoyou);
            $exp[0] = "傲游";
            $exp[1] = $aoyou[1];
        } elseif (stripos($sys, "MSIE") > 0) {
            preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
            $exp[0] = "IE";
            $exp[1] = $ie[1];  //获取IE的版本号
        } elseif (stripos($sys, "OPR") > 0) {
            preg_match("/OPR\/([\d\.]+)/", $sys, $opera);
            $exp[0] = "Opera";
            $exp[1] = $opera[1];
        } elseif (stripos($sys, "Edge") > 0) {
            //win10 Edge浏览器 添加了chrome内核标记 在判断Chrome之前匹配
            preg_match("/Edge\/([\d\.]+)/", $sys, $Edge);
            $exp[0] = "Edge";
            $exp[1] = $Edge[1];
        } elseif (stripos($sys, "Chrome") > 0) {
            preg_match("/Chrome\/([\d\.]+)/", $sys, $google);
            $exp[0] = "Chrome";
            $exp[1] = $google[1];  //获取google chrome的版本号
        } elseif (stripos($sys, 'rv:') > 0 && stripos($sys, 'Gecko') > 0) {
            preg_match("/rv:([\d\.]+)/", $sys, $IE);
            $exp[0] = "IE";
            $exp[1] = $IE[1];
        } else {
            $exp[0] = "未知浏览器";
            $exp[1] = "";
        }
        return $exp[0] . '(' . $exp[1] . ')';
    }


    private function osinfo()
    {
        $info = array(
            '操作系统'	=>	PHP_OS,
            '运行环境'	=>	$_SERVER["SERVER_SOFTWARE"],
            '主机名'		=>	$_SERVER['SERVER_NAME'],
            'WEB服务端口'	=>	$_SERVER['SERVER_PORT'],
//            '网站文档目录'	=>	$_SERVER["DOCUMENT_ROOT"],
            '浏览器信息'	=>	substr($_SERVER['HTTP_USER_AGENT'], 0, 40),
            '通信协议'	=>	$_SERVER['SERVER_PROTOCOL'],
            '请求方法'	=>	$_SERVER['REQUEST_METHOD'],
            // 'ThinkPHP版本'=>THINK_VERSION,
            'PHP版本'	=>	PHP_VERSION,
            '上传附件限制'	=>	ini_get('upload_max_filesize'),
            '执行时间限制'	=>	ini_get('max_execution_time').'秒',
            '服务器时间'	=>	date("Y年n月j日 H:i:s"),
            '北京时间'	=>	gmdate("Y年n月j日 H:i:s",time()+8*3600),
            '服务器域名/IP'	=>	$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            '剩余空间'	=>	round((disk_free_space(".")/(1024*1024)),2).'M',
            '当前用户的IP地址'=>	$_SERVER['REMOTE_ADDR'],
            '运行方式'=>php_sapi_name(),
            '当前进程'=>Get_Current_User(),
        );

        return $info;
    }


}
