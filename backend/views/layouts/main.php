<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$this->title = $this->title;
dmstr\web\AdminLteAsset::register($this);
backend\assets\AppAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@web/dist');
   // $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/bower/bootstrap/dist');
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@web/dist');
?>
    <?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
</head>
<body class="hold-transition skin-blue-light sidebar-mini" style="overflow: visible; min-width:100%;">
    <?php $this->beginBody() ?>
    <div class="wrapper" style="display: table; clear: both; overflow: visible; width: auto; min-width:100%;">
        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
</body>
</html>
    <?php $this->endPage(); ?>

