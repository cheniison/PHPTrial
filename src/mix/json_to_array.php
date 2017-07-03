<?php
/**
 * @file json_to_array.php
 * @brief 将json字符串转成数组
 * @author cheniison
 * @version 1.0.0
 * @date 2017-07-03
 */

// 递归将json和json里的所有元素都转化成数组
function json_to_array($json_str)
{
    if(! (is_object($json_str) || is_array($json_str))) {
        $json_str = json_decode($json_str);
    }

    if(is_null($json_str)) {
        return array();
    }

    $json_arr = array();

    if(! ($json_str instanceof Traversable || is_array($json_str) || is_object($json_str))) {
        return $json_str;
    }

    foreach($json_str as $k => $v) {
        if (is_object($v) || is_array($v)) {
            $json_arr[$k] = json_to_array($v);
        } else {
            $json_arr[$k] = $v;
        }
    }
    
    return $json_arr;
}


// Test
$res = json_to_array(json_encode(['a'=>1, 'b'=>2]));
var_dump($res);

$res = json_to_array(json_encode(['a'=>['a'=>1, 'b'=>2], 'b'=>2]));
var_dump($res);

class Test{
    public $a;
    public $b;

    public function __construct($a, $b)
    {
        $this->a = $a;
        $this->b = $b;
    }
}

$res = json_to_array(json_encode(['a'=>new Test(1, 2), 'b'=>2]));
var_dump($res);

$res = json_to_array(json_encode(['a'=>new Test(new Test(1, [1, 2]), ['a'=>1, 'b'=>2]), 'b'=>2]));
var_dump($res);

$res = json_to_array("123");
var_dump($res);

$res = json_to_array("abc");
var_dump($res);

$res = json_to_array("");
var_dump($res);

