<?php
/**
 * @file YCombinator.php
 * @brief Y 组合子
 * @author cheniison
 * @version 1.0.0
 * @date 2017-06-28
 */

namespace PHPTrial\FP;

//implement Y Combinator

$Y = function($f){
	$tmp = function($x) use ($f){
		return $f(function($y)use($x){return $x($x)($y);});
	};
	return $tmp($tmp);
};

$almost_factorial = function($f){
	return function($n) use ($f){
		if($n == 0){
			return 1;
		}else{
			return $n * $f($n-1);
		}
	};
};

$factorial = $Y($almost_factorial);

echo $factorial(10) . PHP_EOL;
