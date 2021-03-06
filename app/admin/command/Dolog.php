<?php

namespace app\admin\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;
use think\Log;

class Dolog extends Command
{
    protected function configure()
    {
        $this->setName("dolog")->setDescription("hahah");
        parent::configure(); // TODO: Change the autogenerated stub
    }

    protected function execute(Input $input, Output $output)
    {
        $output->writeln("fffff");
        $this->doMyLog($output);
        $this->deleteLog();
    }

    private function doMyLog($output)
    {
        $startTime = strtotime(date("Y-m-d H:i:00", strtotime("-10 minutes")));
        $endTime = strtotime(date("Y-m-d H:i:00"));
        $output->writeln($startTime);
        $output->writeln($endTime);
        Log::record("beginTime=" . $startTime . " and endTime=" . $endTime);
        $list=Db::name('access_log_today')->where('request_time','between',[$startTime,$endTime])->group('path_info')->field("path_info,count(*) as num")->select();
        $insert_data=['begin'=>$startTime,'end'=>$endTime];
        foreach ($list as $value){
            if(in_array($value['path_info'],['/','favicon.ico'])){
                continue;
            }
            $insert_data['path_info']=$value['path_info'];
            $insert_data['num']=$value['num'];
            Db::name('access_log_count')->insert($insert_data);
        }
    }

    private function deleteLog()
    {
        $time=strtotime("-1 day");
        Db::name('access_log_today')->where('request_time','<',$time)->delete();
    }
}