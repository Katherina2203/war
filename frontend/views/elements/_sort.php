<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\elementsSearch */
/* @var $form yii\widgets\ActiveForm */
use common\models\Category;
$getcategory = Category::getHierarchy(); //ArrayHelper::map(common\models\Category::find()->select(['name_ru', 'idcategory'])->all(), 'idcategory', 'name_ru');
$getproduce = ArrayHelper::map(common\models\Produce::find()->select(['manufacture', 'idpr'])->all(), 'idpr', 'manufacture');
?>

<div class="elements-sort">
    <?php $form = ActiveForm::begin([
      //  'action' => ['index'],
      //  'method' => 'get',
    ]); ?>
    
     <?= $form->field($model, 'active')->radioList([ 
                '1' => 'актуально', 
                '2' => 'устарело', ], ['prompt' => 'Выберите актуальность товара']);  ?>
     <?php ActiveForm::end(); ?>
</div>