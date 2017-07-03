<?php

namespace PHPTrial\Message;

class ServerApi
{
    private $AppKey;
    private $AppSecret;
    private $Nonce; //随机数（最大长度128个字符）
    private $CurTime; //当前UTC时间戳，从1970年1月1日0点0 分0 秒开始到现在的秒数(String)
    private $CheckSum;//SHA1(AppSecret + Nonce + CurTime),三个参数拼接的字符串，进行SHA1哈希计算，转化成16进制字符(String，小写)
    const   HEX_DIGITS = "0123456789abcdef";

    public function __construct($key, $secret){
        $this->AppKey    = $key;
        $this->AppSecret = $secret;
    }

    /**
     * API checksum校验生成
     * @param  void
     * @return $CheckSum(对象私有属性)
     */
    public function checkSumBuilder(){
        //此部分生成随机字符串
        $hex_digits = self::HEX_DIGITS;
        $this->Nonce;
        for($i=0;$i<128;$i++){          //随机字符串最大128个字符，也可以小于该数
            $this->Nonce.= $hex_digits[rand(0,15)];
        }
        $this->CurTime = (string)(time());  //当前时间戳，以秒为单位

        $join_string = $this->AppSecret.$this->Nonce.$this->CurTime;
        $this->CheckSum = sha1($join_string);
        //print_r($this->CheckSum);
    }

    /**
     * 将json字符串转化成php数组
     * @param  $json_str
     * @return $json_arr
     */
    public function json_to_array($json_str){
        if(is_null(json_decode($json_str))){
            $json_str = $json_str;
        }else{
            $json_str = json_decode($json_str);
        }
        $json_arr=array();

        foreach($json_str as $k=>$w){
            if(is_object($w)){
                $json_arr[$k]= $this->json_to_array($w); //判断类型是不是object
            }else if(is_array($w)){
                $json_arr[$k]= $this->json_to_array($w);
            }else{
                $json_arr[$k]= $w;
            }
        }
        return $json_arr;
    }

    /**
     * 使用FSOCKOPEN方式发送post请求
     * @param  $url     [请求地址]
     * @param  $data    [array格式数据]
     * @return $请求返回结果(array)
     */
    public function postDataFsockopen($url,$data){
        $this->checkSumBuilder();       //发送请求前需先生成checkSum

        $postdata = '';
        foreach ($data as $key=>$value){
            $postdata.= ($key.'='.urlencode($value).'&');
        }
        // building POST-request:
        $URL_Info=parse_url($url);
        if(!isset($URL_Info["port"])){
            $URL_Info["port"]=80;
        }
        $request = '';
        $request.="POST ".$URL_Info["path"]." HTTP/1.1\r\n";
        $request.="Host:".$URL_Info["host"]."\r\n";
        $request.="Content-type: application/x-www-form-urlencoded;charset=utf-8\r\n";
        $request.="Content-length: ".strlen($postdata)."\r\n";
        $request.="Connection: close\r\n";
        $request.="AppKey: ".$this->AppKey."\r\n";
        $request.="Nonce: ".$this->Nonce."\r\n";
        $request.="CurTime: ".$this->CurTime."\r\n";
        $request.="CheckSum: ".$this->CheckSum."\r\n";
        $request.="\r\n";
        $request.=$postdata."\r\n";

//        print_r($request);
        $fp = fsockopen($URL_Info["host"],$URL_Info["port"]);
        fputs($fp, $request);
        $result = '';
        while(!feof($fp)) {
            $result .= fgets($fp, 128);
        }
        fclose($fp);

        $str_s = strpos($result,'{');
        $str_e = strrpos($result,'}');
        $str = substr($result, $str_s,$str_e-$str_s+1);
//        print_r($result);
        return $this->json_to_array($str);
    }

    /**
     * 发送模板短信
     * @param  $templateid       [模板编号(由客服配置之后告知开发者)]
     * @param  $mobiles          [验证码]
     * @param  $params          [短信参数列表，用于依次填充模板，JSONArray格式，如["xxx","yyy"];对于不包含变量的模板，不填此参数表示模板即短信全文内容]
     * @return $result      [返回array数组对象]
     */
    public function sendSMSTemplate($templateId,$mobile,$codeLen=4){
        $url = 'https://api.netease.im/sms/sendcode.action';
        $data= array(
            'mobile' => $mobile,
            'templateid' => $templateId,
            'codeLen' => $codeLen
        );
        $result = $this->postDataFsockopen($url,$data);
        return $result;
    }

}
