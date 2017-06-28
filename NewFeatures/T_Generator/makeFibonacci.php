<?php
/**
 * @file makeFibonacci.php
 * @brief 从1开始生成斐波那契数列
 * @author cheniison
 * @version 1.0.0
 * @date 2017-06-28
 */

namespace PHPTrial\NewFeatures\T_Generator;

function makeFibonacci($length)
{
    $i = 0;
    $j = 1;

    while($length--){
        yield $j;   // yield $i 即为从0开始生成
        $tmp = $i;
        $i = $j;
        $j = $tmp + $i;
    }
}

// Test
foreach(makeFibonacci(10) as $i){
    echo $i . PHP_EOL;
}
