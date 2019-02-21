<?php
/*   罚款代缴  */
namespace wap\index\channel;

class Payfine extends Cx580
{
    public function go()
    {
        $url=$this->channel_arr['url']."?tel={$this->phone}&user_id={$this->phone}&user_from={$this->user_from}&token=".$this->getToken($this->phone);
        redirect($url)->send();
    }
}