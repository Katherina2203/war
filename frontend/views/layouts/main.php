<?php
use yii\helpers\Html;

if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    if (class_exists('frontend\assets\AppAsset')) {
        frontend\assets\AppAsset::register($this);
    } else {
        backend\assets\mainAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);
      
    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@web/dist'); //@vendor/bower/bootstrap/dist
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
<body class="hold-transition skin-blue-light sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">
       <?= $this->render(
            'head.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>
       <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>
       
        <?php
        echo $this->render(           
            'right.php',            
            ['directoryAsset' => $directoryAsset]          )
        ?>
    </div>

    <?php $this->endBody() ?>
</body>
</html>
    <?php $this->endPage() ?>
<?php } ?>
