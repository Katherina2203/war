<?php
namespace backend\components;

class TotalColumn {

public static function pageTotal($provider, $fieldName)
{
    $total=0;
    foreach($provider as $item){
        $total += $item[$fieldName];
    }
    return $total . ' грн';
}

public static function pdvTotal($provider, $fieldName)
{
    $pdv = 0;
    
   return pageTotal*1.2;
}

}