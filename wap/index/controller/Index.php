<?php

namespace wap\index\controller;

use wap\index\controller\Record;
use think\Request;

class Index
{

    public function index(Request $request)
    {
        $channel = $request->param('myparam');
        if (empty($channel)) {
            Record::throwOut();
        }
        $t = $request->get('t');
        $ch = $request->get('ch');
        $value = $request->get('value');
//        if ($t != '0' || $ch != '01') {
//            Record::throwOut();
//        }
        $phone="";
        if(!empty($value)) {
            $phone = self::decrypt($value);
        }
//        if (empty($phone)) {
//            Record::throwOut();
//        }
        if (empty(($c = \wap\index\controller\Channel::create($channel,$phone)))) {
            Record::throwOut();
        }
        Record::record($phone);
        $c->go();
    }

    public static function decrypt($value)
    {
        $privateKey = file_get_contents(config('pem'));
        $pkeyId = openssl_pkey_get_private($privateKey);
        $i = openssl_private_decrypt(base64_decode($value), $signature, $pkeyId);
        openssl_free_key($pkeyId);
        if (empty($i)) {
            return false;
        } else {
            $myArr = explode('=', $signature);
            return $myArr[count($myArr) - 1];
        }
    }
}
