<?php

namespace PHPTrial\Message;

include "../../Autoloader.php";
include "../../config.php";

if($argc != 2) {
    echo "usage: $argv[0] [phone number]\n";
    exit(1);
}

$phone = $argv[1];

$p = new ServerAPI($settings['AppKey'],$settings['AppSecret']);     //fsockopen伪造请求

//发送模板短信
$result = $p->sendSMSTemplate($settings['templateId'],$phone,6);
 
print_r($result);

exit(0);
