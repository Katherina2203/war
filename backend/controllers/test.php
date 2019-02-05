<?php

class MyClass
{
    const myconst = 'value constant';
    
    function getMyconst(){
        return self::myconst. "\n";
    }
}

echo MyClass::myconst();

$cc = "my const class";
echo $cc::myconst;

$cc = new MyClass();
$cc->getMyconst();