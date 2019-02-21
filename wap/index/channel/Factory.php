<?php

namespace wap\index\channel;


use think\Log;

class Factory
{
    public function createChannel($name,array $arr)
    {
        $classname = 'wap\index\channel\\' . $name;
        try {
            $class = new \ReflectionClass($classname);
            $ch = $class->newInstance($arr);
        } catch (\ReflectionException $exception) {
            Log::record("Factory error $name");
            throw new \InvalidArgumentException('no have');
        }
        return $ch;
    }

}