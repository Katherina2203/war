<?php
use yii\helpers\Html;
?>
<?= Html::submitButton('Сохранить изменения', ['class' => 'btn btn-info', 'name' => 'edit-button']) ?>

<?php $image = isset($model->photo) ?
   //     $model->photo->getImageUrl() 
        : null; ?>

<?php if (isset($image)): ?>

  <?php   echo Html::a('Удалить фото', ['delete-image'], ['class' => 'btn btn-warning'], [
     'data' => [
       
        'confirm' => 'Do you really want to delete this photo?',
        'method' => 'post',
        'params' => [
            'id' => $model->id,
           // 'kind' => $page->kind,
        ],
    ],
]);?>

<?php endif; ?>