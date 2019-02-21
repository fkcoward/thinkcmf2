<?php
function get_sign($str)
{
    $private_key=file_get_contents("./allinpay_key.pem");
    $priKey=openssl_get_privatekey($private_key,'316093');
    openssl_sign($str,$signature,$priKey,OPENSSL_ALGO_SHA1);
    return base64_encode($signature);
}
/*
$url="http://test.allinpay.com/h5pay/registerUser.do";
//$url="http://test.allinpay.com/walletpn/standardCenterLogin/centerLogin";
function jiami_pub($str)
{
    $public_key=file_get_contents("./allinpay_cer.pem");
    $pubKey=openssl_get_publickey($public_key);
    openssl_public_encrypt($str,$signature,$pubKey);
    return base64_encode($signature);
}

function sign_phone($str)
{
    $public_key=file_get_contents("./TLCert_test.cer");
    $pubKey=openssl_pkey_get_public($public_key);
    openssl_public_encrypt($str,$signature,$pubKey);
    return base64_encode($signature);
}



function request($url, $params)
{
    $ch = curl_init();
    $this_header = array("content-type: application/x-www-form-urlencoded;charset=UTF-8");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//如果不加验证,就设false,商户自行处理
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

$arr=[
    'version'=>'1.0',
    'appId'=>'TLmshbm',
    'merchantId'=>'008310148160013',
    'merchantUserId'=>'13052295828',
    'accountType'=>'1',
    'mobileNo'=>sign_phone("13052295828"),
    'registerSource'=>'H5',
    'requestDatetime'=>date("YmdHis")
];

var_dump($arr);

$signMsg="";
$signstr="";

foreach ($arr as $key=>$val){
    $signstr.="$key=$val&";
}
$signstr=trim($signstr,'&');
var_dump($signstr);


$arr['signMsg']=get_sign($signstr);

var_dump($arr);

var_dump(request($url,$arr));

*/

$url="http://test.allinpay.com/walletpn/standardCenterLogin/centerLogin";
$para = array(
    'sysid' => ('008310148160013'), //商户号
    'timestamp' => (date("Y-m-d H:i:s")), //请求时间戳 YYYY-MM-DD HH:MI:SS
    'v' => ('1.0'), //接口版本
    //'signtype' => 'sha1', //签名类型

);
$req =array(
    'param' =>array(
        'uuid'=>'190114550247530',
        'timeStamp'=>date("Y-m-d H:i:s"),
        'mobileNo'=>'13052295828'
    ),
    'service' => "", //服务对象
    'method' => ""         //调用方法
);

$params_str = $para['sysid'].json_encode($req).$para['timestamp'];
$sign = get_sign($params_str);
$para['sign'] = ($sign);
$finsh_url=$url."?".http_build_query($para)."&req=".urlencode(json_encode($req));
header("Location:{$finsh_url}");