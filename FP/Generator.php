<?php
/**
 * @file Generator.php
 * @brief 生成器的 map, reduce, filter
 * @author cheniison
 * @version 1.0.0
 * @date 2017-06-28
 */


/**
 * @brief 生成从0开始的整数
 *
 * @param $length 生成数字的数量
 *
 * @return 
 */
function generateNumerial($length)
{
    for($i = 0; $i < $length; $i++){
        yield $i;
    }
}

// --------- map ----------

function generator_map(Generator $g, callable $callback, int $flag = 0)
{
    if($flag == 0){
        return generator_map_foreach($g, $callback);
    } else {
        return generator_map_iter($g, $callback);
    }
}

function generator_map_foreach(Generator $g, callable $callback)
{
    return function () use ($g, $callback) {
        foreach ($g as $i){
            yield $callback($i);
        }
    };
}

function generator_map_iter(Generator $g, callable $callback)
{
    return function () use ($g, $callback) {
        while($g->valid()){
            yield $callback($g->current());
            $g->next();
        }
    };
}

// Test
echo "generator_map:" . PHP_EOL;
$res = generator_map(generateNumerial(10), function ($item) { return $item * 2; });
foreach($res() as $i){
    echo $i . PHP_EOL;
}

$res = generator_map(generateNumerial(10), function ($item) { return $item * 2; }, 1);
foreach($res() as $i){
    echo $i . PHP_EOL;
}
echo PHP_EOL;


// --------- reduce --------

function generator_reduce(Generator $g, callable $callback, $initial = NULL)
{
    if($initial === NULL && $g->valid()){
        $initial = $g->current();
        $g->next();
    }

    while($g->valid()){
        $initial = $callback($initial, $g->current());
        $g->next();
    }

    return $initial;  
}

// Test
echo "generator_reduce:" . PHP_EOL;
$res = generator_reduce(generateNumerial(10), function ($res, $i) { return $res + $i; });
echo $res . PHP_EOL;
echo PHP_EOL;

// --------- filter ----------

function generator_filter(Generator $g, callable $callback, $flag = 0)
{
    if($flag == 0){
        return generator_filter_foreach($g, $callback);
    }else{
        return generator_filter_iter($g, $callback);
    }
}

function generator_filter_foreach(Generator $g, callable $callback)
{
    return function () use ($g, $callback) {
        foreach($g as $i){
            if($callback($i)){
                yield $i;
            }
        }
    };
}

function generator_filter_iter(Generator $g, callable $callback)
{
    return function () use ($g, $callback) {
        while($g->valid()){
            if($callback($g->current())){
                yield $g->current();
            }
            $g->next();
        }
    };
}

// Test
echo "generator_filter:" . PHP_EOL;
$res = generator_filter(generateNumerial(10), function ($i) { return $i % 2 == 1; });
foreach($res() as $i){
    echo $i . PHP_EOL;
}
$res = generator_filter(generateNumerial(10), function ($i) { return $i % 2 == 1; }, 1);
foreach($res() as $i){
    echo $i . PHP_EOL;
}
echo PHP_EOL;

// Test All
echo "reduce(filter(map())):" . PHP_EOL;
$res = generator_reduce(
            generator_filter(
                generator_map(
                    generateNumerial(10),
                    function ($i) { return $i * 2; }
                )(), 
                function ($i) { return $i % 3 == 0; }
            )(),
            function ($res, $i) { return $res + $i; }
        );
echo $res . PHP_EOL;
