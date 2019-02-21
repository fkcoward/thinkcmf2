<?php

namespace wap\index\channel;


class Hello
{
    public function go($find)
    {
        redirect($find['url'])->send();
    }
}