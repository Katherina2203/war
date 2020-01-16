<?php
namespace backend\components;

use \Yii;
use common\models\Currency;

class TotalColumn {

public static function pageTotal($provider, $fieldName)
{
    $invoiceCurrency = null;
    $total=0;
    foreach($provider as $item){
        if (is_null($invoiceCurrency)) {
            $modelCurrency = Currency::findOne($item->prices['idcurrency']);
            $invoiceCurrency = $modelCurrency['currency'];
            Yii::info('<pre>****'. print_r($invoiceCurrency, true).'</pre>', 'ajax');
        }
        $total += $item[$fieldName];
    }
    return $total . (is_null($invoiceCurrency) ? ' грн' : ' ' . $invoiceCurrency);
}

public static function pdvTotal($provider, $fieldName)
{
    $pdv = 0;
    return pageTotal*1.2;
}

}