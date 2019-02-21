<?php

namespace wap\index\channel;

class Basechannel
{
    protected $channel_arr;
    protected $name;
    protected $phone;

    function __construct(array $arr)
    {
        $this->channel_arr=$arr['channel_arr'];
        $this->phone=$arr['phone'];
        $this->name=$arr['name'];
    }
}