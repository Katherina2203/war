<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;

use yii\helpers\Url;

use backend\models\RequestsByIdSearch;
use common\models\Requests; 
?>

<div class="search-form">
           
    <?php $form = ActiveForm::begin([
            'action' => Url::to([
                'paymentinvoice/itemsin', 
                'idinvoice' => $modelRequestsByIdSearch->idinvoice,
            ]),
            'id' => 'form-requests-by-id-search',
            'method' => 'get',
        ]);
    ?>
        <?php
        echo $form->field($modelRequestsByIdSearch, 'idinvoice', ['template' => '{input}',])->input('hidden');
        echo $form->field($modelRequestsByIdSearch, 'idrequest', [
            'template' => '{error}'
            . '<div class="input-group" style="width: 200px;">{input}<span class="input-group-btn">' .
            Html::submitButton('Search', ['class' => 'btn btn-success']) .
            '</span></div>',
        ])->textInput(['placeholder' => '№ of request'])->label('№ of request');
        ?>
    <?php ActiveForm::end(); ?>

</div>
