<?php 
/**
 * @file Volume.php
 * @brief 测试类
 * @author cheniison
 * @version 1.0
 * @date 2017-06-27
 */

namespace PHPTrial\NewFeatures\T_Trait;

include "../../../Autoloader.php";

echo "Computer:" . PHP_EOL;
$c = new Computer();
$rs = $c->setVol(-1);
echo $rs . PHP_EOL;
echo $c->getVol() . PHP_EOL;
$rs = $c->turnupVol(101);
echo $rs . PHP_EOL;
echo $c->getVol() . PHP_EOL;

echo "Phone:" . PHP_EOL;
$p = new Phone();
$rs = $p->setVol(50);
echo $rs . PHP_EOL;
echo $p->getVol() . PHP_EOL;
