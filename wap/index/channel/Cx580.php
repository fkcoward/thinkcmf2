<?php

namespace wap\index\channel;


class Cx580 extends Basechannel
{
    protected $key="1234567890123456";
    protected $user_from="HBYDHSH2019";

    protected function getToken($user_id)
    {
        return urlencode(base64_encode(openssl_encrypt($user_id.$this->user_from,'AES-128-ECB',$this->key,OPENSSL_RAW_DATA)));

    }
}