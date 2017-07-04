<?php

namespace PHPTrial\Mix\T_Reflection;

class Person{
    
    /* comment above*2 */
    /**
     * comment above 
     */
    /** anothor comment */
    public $name;   // comment right
    /**
     * comment below 
     */
    /* comment below*2 */
    protected $age; // age
    private $salary;  // salary

    public function __construct($name, $age, $salary)
    {
        $this->name = $name;
        $this->age = $age;
        $this->salary = $salary;
    }

    /**
     * @brief a public method
     *
     * @param $a 
     *
     * @return 
     */
    public function publicmtd($a)
    {
        return $a;
    }


    /**
     * @brief a protected method
     *
     * @param $a
     * @param $b
     *
     * @return 
     */
    protected function protectedmtd($a, $b)
    {
        return $a . $b;
    }

    
    /**
     * @brief a private method
     *
     * @return 
     */
    private function privatemtd()
    {

    }
}


// Test

// instantiate class
var_dump(new Person('John', 20, 8000));

$class = new \ReflectionClass('PHPTrial\Mix\T_Reflection\Person');  //必须输入命名空间全名

$instance = $class->newInstanceArgs(['John', 20, 8000]);
var_dump($instance);

var_dump(\ReflectionClass::export('PHPTrial\Mix\T_Reflection\Person'));

// --------------
// get properties
// --------------

// get all attr
$properties = $class->getProperties();
foreach($properties as $k => $property) {
    echo $property->getName() . PHP_EOL;
}

// get private and protected attr
$private_properties = $class->getProperties(\ReflectionProperty::IS_PRIVATE | \ReflectionProperty::IS_PROTECTED);
foreach($private_properties as $k => $property) {
    echo $property->getName() . PHP_EOL;
}

// --------------
// get comment
// --------------

echo PHP_EOL;
foreach($properties as $property) {
    if ($property->isPublic()) {
        echo $property->getName() . PHP_EOL;
        echo $property->getDocComment() . PHP_EOL;  // 只识别属性上方第一个/**  */这样的注释
    }
}

// --------------
// get methods
// --------------

echo PHP_EOL;
$methods = $class->getMethods();
foreach($methods as $method) {
    echo $method->getName() . PHP_EOL;
}


