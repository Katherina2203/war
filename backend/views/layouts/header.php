<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this \yii\web\View */
/* @var $content string */
use yii\bootstrap\ActiveForm;

use backend\models\ElementsSearch;
use common\widgets\LanguageSelector;
/* @var $this \yii\web\View */
/* @var $content string */
$user = new \common\models\Users();
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">MW</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">
        
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="search-form col-md-6" style="margin-top: 5px; margin-bottom: -5px;">
           
                <?php $form = ActiveForm::begin([
                        'action' => ['elements/index'],
                        'method' => 'get',
                      ]); ?>
                     <?php $searchElements = new ElementsSearch();
                     echo $form->field($searchElements, 'name', [
                         'template' => '<div class="input-group">{input}<span class="input-group-btn">' .
                             Html::submitButton('Search', ['class' => 'btn btn-default']) .
                             '</span></div>',
                         ])->textInput(['placeholder' => 'Search']);
                         ?>
                <?php ActiveForm::end(); ?>
                    
        </div>
        <div class="navbar-custom-menu" style="float: left; margin-left: 200px;">
        
       
            <ul class="nav navbar-nav">

                <!-- Languange:  -->
                 <li>
                  <div class="navbar-custom-menu"> 
                      <ul id="w0" class="nav navbar-nav">
                        <li class="dropdown">
                            <?= LanguageSelector::widget(); ?>
                        </li>
                    </ul>
                  </div>
                </li>
                <!-- End Languange:  -->
                 <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <?php 
                    $sUserPhoto = '@web/images/users/no-photo.png';
                    if(is_null(Yii::$app->user->identity)) {
                    ?>
                        <a href="<?= Url::to(['login']); ?>" class="dropdown-toggle">
                            <img src="<?= Url::to($sUserPhoto) ?>" class="user-image" alt=""/>
                            <span class="hidden-xs">Log in</span>
                        </a>
                    <?php
                    } else {
                        $sUserPhoto = (Yii::$app->user->identity->name == 'Ekaterina') ?
                            Url::to('@web/images/users/kat.jpg') : Url::to('@web/images/users/anonim-128.png');
                    ?>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= $sUserPhoto; ?>" class="user-image" alt="" />
                            <span class="hidden-xs"><?= Yii::$app->user->identity->name;?></span>
                        </a>
                    <?php } ?>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= Url::to($sUserPhoto) ?>" class="img-circle"
                                 alt="<?php // Yii::$app->user->identity->surname?>"/>

                            <p>
                                <?php // Yii::$app->user->identity->surname?>
                                <small> <?php // Yii::$app->user->identity->created_at;?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="<?= Yii::$app->urlManager->createUrl(['/myaccount/users/department'])?>">Отдел</a>
                            
                            </div>
                            <div class="col-xs-4 text-center">
                                <?= Html::a(Yii::t('app', 'My account'), ['/myaccount/']) ?>
                            </div>
                           
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?php // Html::a('Мой профиль', ['users/myprofile',  'id' => yii::$app->user->identity->id], ['class' => 'btn btn-default btn-flat']) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    Yii::t('app', 'Logout'),
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
            
            </ul>
        </div>
    </nav>

</header>
