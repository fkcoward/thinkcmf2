<?php
/*  小哥  */
namespace wap\index\channel;

class Xiaoge extends Basechannel
{
    public function go()
    {
        $url=$this->channel_arr['url'].base64_encode($this->phone);
        redirect($url)->send();
    }
}