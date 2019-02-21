<?php

namespace wap\index\channel;

use think\Db;
use think\Log;

class Allinpay extends Basechannel
{
    private $regUrl="http://test.allinpay.com/h5pay/registerUser.do";
    private $getUrl="http://test.allinpay.com/walletpn/standardCenterLogin/centerLogin";
    private $appId = "TLmshbm";
    private $merchantId = "008310148160013";
    private $dataPath=APP_PATH . "data" . DIRECTORY_SEPARATOR . "allinpay" . DIRECTORY_SEPARATOR;
    private $TLCert = "TLCert_test.cer";
    private $priKey = "allinpay_key.pem";
    private $priKeyNum = "316093";

    public function go()
    {
        $uuid=$this->getUuid();
        if(empty($uuid)){
            echo ("uuid get error");
        }else {
            $this->doGet($uuid);
        }
    }

    private function getUuid()
    {
        $uuid_find = Db::name('chl_allinpay')->where("phone", $this->phone)->find();
        if (empty($uuid_find)) {
            return $this->doRegist();
        } else {
            return $uuid_find['uuid'];
        }
    }

    private function doRegist()
    {
        $arr = [
            'version' => '1.0',
            'appId' => $this->appId,
            'merchantId' => $this->merchantId,
            'merchantUserId' => $this->phone,
            'accountType' => '1',
            'mobileNo' => base64_encrypt_with_pub($this->phone,  $this->dataPath. $this->TLCert),
            'registerSource' => 'H5',
            'requestDatetime' => date("YmdHis")
        ];
        $signstr = "";
        foreach ($arr as $key => $val) {
            $signstr .= "$key=$val&";
        }
        $signstr = trim($signstr, '&');
        $arr['signMsg']=base64_sign_with_pri_sha1($signstr,$this->dataPath.$this->priKey,$this->priKeyNum);
        $ret=request_post($this->regUrl,$arr);
        parse_str($ret,$output);
        if(isset($output['userId'])&&!empty($output['userId'])){
            Db::name('chl_allinpay')->insert(['phone'=>$this->phone,'uuid'=>$output['userId'],'addtime'=>date("Y-m-d H:i:s")]);
            return $output['userId'];
        }else{
            Log::write("马上有折get uuid error :".$ret,'error');
            return false;
        }
    }

    private function doGet($uuid)
    {
        $timestamp=date("Y-m-d H:i:s");
        $para = array(
            'sysid' => $this->merchantId, //商户号
            'timestamp' => $timestamp, //请求时间戳 YYYY-MM-DD HH:MI:SS
            'v' => '1.0' //接口版本
        );
        $req =array(
            'param' =>array(
                'uuid'=>$uuid,
                'timeStamp'=>$timestamp,
                'mobileNo'=>$this->phone
            ),
            'service' => "", //服务对象
            'method' => ""         //调用方法
        );

        $params_str = $para['sysid'].json_encode($req).$para['timestamp'];
        $para['sign'] = base64_sign_with_pri_sha1($params_str,$this->dataPath.$this->priKey,$this->priKeyNum);
        $finsh_url=$this->getUrl."?".http_build_query($para)."&req=".urlencode(json_encode($req));
        redirect($finsh_url)->send();
    }
}