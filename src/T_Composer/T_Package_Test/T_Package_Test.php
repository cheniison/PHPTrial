<?php

namespace PHPTrial\T_Composer\T_Package_Test;

include "./vendor/autoload.php";

use T_Package\Package;

$obj = new Package();
$obj->hello();
