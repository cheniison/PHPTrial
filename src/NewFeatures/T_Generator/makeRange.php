<?php
/**
 * @file makeRange.php
 * @brief 产生一串连续整数
 * @author cheniison
 * @version 1.0.0
 * @date 2017-06-28
 */

namespace PHPTrial\NewFeatures\T_Generator;

function makeRange($length)
{
    for($i = 0; $i < $length; $i++){
        yield $i;
    }
}

// Test
foreach (makeRange(100) as $i){
    echo $i . PHP_EOL;
}
