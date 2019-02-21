<?php

namespace wap\index\controller;

use think\Db;

class Record
{

    public static function record($phone = "")
    {
        $request = request();
        Db::table("fsd_access_log_today")->insert([
            'path_info' => $request->path(),
            't' => $request->get('t'),
            'ch' => $request->get('ch'),
            'phone' => $phone,
            'ip' => get_client_ip(),
            'request_time' => $request->server('request_time'),
            'user_agent' => $request->header('user-agent')
        ]);
        $tableName = "fsd_access_log_" . date("Ym");
        Db::table($tableName)->insert([
            'path_info' => $request->path(),
            't' => $request->get('t'),
            'ch' => $request->get('ch'),
            'phone' => $phone,
            'ip' => get_client_ip(),
            'request_time' => $request->server('request_time'),
            'user_agent' => $request->header('user-agent')
        ]);
    }

    public static function throwOut()
    {
//        self::record();
        throw new \think\exception\HttpException(404, '页面不存在');
    }
}