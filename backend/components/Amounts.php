<?php
namespace backend\components;

class TotalColumn {
    
    public static function getAmount($provider, $unitPrice, $forUp)
    {
        $sum = 0;
        
        foreach($provider as $item){
            $sum = ($quantity * $unitPrice) / $forUp;
        }
        
        return $sum;
    }
}

