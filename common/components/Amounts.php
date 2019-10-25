<?php
namespace backend\components;

use Yii;

class Amounts {
    
    //to do функция не работает
//    public static function getAmount($provider, $unitPrice, $forUp)
//    {
//        $sum = 0;
//        
//        foreach($provider as $item){
//            $sum = ($quantity * $unitPrice) / $forUp;
//        }
//        
//        return $sum;
//    }
//    
    public static function checkAmount ($modelPrices, $modelAccounts) {
        
        //amount from string to float value
        $dPriceAmound = round(($modelPrices->unitPrice / $modelPrices->forUP) * $modelAccounts->quantity, 2);
        $dAccountAmount = floatval($modelAccounts->amount);

        return ($dAccountAmount == $dPriceAmound);
    }
}

