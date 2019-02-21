<?php
/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv  是否进行高级模式获取（有可能被伪装）
 * @return string
 */
function get_client_ip($type = 0, $adv = true)
{
    return request()->ip($type, $adv);
}

function my_redirect($url = [], $params = [], $code = 302, $with = [])
{
    if (is_integer($params)) {
        $code   = $params;
        $params = [];
    }
    return Response::create($url, 'redirect', $code)->params($params)->with($with);
}

function base64_sign_with_pri_sha1($str,$priKeyPath,$keyNum)
{
    $private_key=file_get_contents($priKeyPath);
    $priKey=openssl_get_privatekey($private_key,$keyNum);
    openssl_sign($str,$signature,$priKey,OPENSSL_ALGO_SHA1);
    return base64_encode($signature);
}


function base64_encrypt_with_pub($str,$pubKeyPath)
{
    $public_key=file_get_contents($pubKeyPath);
    $pubKey=openssl_pkey_get_public($public_key);
    openssl_public_encrypt($str,$signature,$pubKey);
    return base64_encode($signature);
}

function request_post($url, $params)
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