<?php
namespace App\Common\Lib;

class Token{
    //加密函数支持url传输，可用cpDecode()函数解密，$data：待加密的字符串或数组；$key：密钥；$expire 过期时间
    public static function createToken($data,$key='',$expire = 0){
        $string=serialize($data);
        $ckey_length = 4;
        $key = md5($key);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = substr(md5(microtime()), -$ckey_length);

        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);

        $string =  sprintf('%010d', $expire ? $expire + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        $result = base64_encode($result);
        $result = str_replace('=', '', $result);
        $result = str_replace('/', '-', $result);
        $result = str_replace('+', '_', $result);
        $result = str_replace('%', '`', $result);

        return rawurlencode($keyc.str_replace('=', '', $result));
    }

//cpEncode之后的解密函数，$string待解密的字符串，$key，密钥
    public static function validateToken($string,$key=''){
        $string=rawurldecode($string);
        $string = str_replace('-','/',  $string);
        $string = str_replace('_','+',  $string);
        $string = str_replace('`','%',  $string);
        $ckey_length = 4;
        $key = md5($key);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = substr($string, 0, $ckey_length);

        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);

//        exit();
        $string =  base64_decode(substr($string, $ckey_length));
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return unserialize(substr($result, 26));
        }else{
            return '';
        }
    }
}
