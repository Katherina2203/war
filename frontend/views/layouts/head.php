<?php
use yii\helpers\Html;
use yii\helpers\Url;
//use frontend\widgets\WLang;
use yii\bootstrap\ActiveForm;

use backend\models\ElementsSearch;
use common\widgets\LanguageSelector;
/* @var $this \yii\web\View */
/* @var $content string */
$user = new \common\models\Users();
/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">MW</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">
        
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="search-form col-md-6" style="margin-top: 5px; margin-bottom: -5px;">
          
            <?php $form = ActiveForm::begin([
                        'action' => ['elements/index'],
                        'method' => 'get',
                      ]); ?>
                     <?php $searchElements = new ElementsSearch();
                     echo $form->field($searchElements, 'searchstring', [
                         'template' => '<div class="input-group">{input}<span class="input-group-btn">' .
                             Html::submitButton('Search', ['class' => 'btn btn-default']) .
                             '</span></div>',
                         ])->textInput(['placeholder' => 'Search']);
                         ?>
                <?php ActiveForm::end(); ?>
                    
        </div>
        
        <div class="navbar-custom-menu">
           
            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"><?= yii::t('app', 'Requests')?></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= Url::to('@web/images/'. '0402.jpg')?>" class="img-circle"
                                                 alt="User Image"/>
                                        </div>
                                        <h4>
                                            Заказать через институт
                                            <small><i class="fa fa-clock-o"></i> не срочно</small>
                                        </h4>
                                        <p>Гикалов</p>
                                    </a>
                                </li>
                                <!-- end message -->
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?=  Url::to( '@web/images/'. '0603.jpg') //was $directoryAsset in path?>" class="img-circle"
                                                 alt="user image"/>
                                        </div>
                                        <h4>
                                           Заказать
                                            <small><i class="fa fa-clock-o"></i> сегодня</small>
                                        </h4>
                                        <p>Вовк</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= Url::to('@web/images/'. '0603.jpg')?>" class="img-circle"
                                                 alt="user image"/>
                                        </div>
                                        <h4>
                                           Заказать
                                            <small><i class="fa fa-clock-o"></i> сегодня</small>
                                        </h4>
                                        <p>Вовк</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?=  Url::to('@web/images/'. '0603.jpg')?>" class="img-circle"
                                                 alt="user image"/>
                                        </div>
                                        <h4>
                                            Заказать
                                            <small><i class="fa fa-clock-o"></i> вчера</small>
                                        </h4>
                                        <p>Вовк</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= Url::to('@web/images/'. '0603.jpg')?>" class="img-circle"
                                                 alt="user image"/>
                                        </div>
                                        <h4>
                                            Заказать
                                            <small><i class="fa fa-clock-o"></i> 2 дня назад</small>
                                        </h4>
                                        <p>Вовк</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><?= Html::a('See All Requests', ['requests/index'], ['data-method' => 'post'])?></li>
                    </ul>
                </li>
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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= Url::to('@web/images/'. 'users/no-photo.png') ?>" class="user-image" alt="<?=Yii::$app->user->identity->surname?>"/>
                        <span class="hidden-xs"><?=Yii::$app->user->identity->username?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= Url::to('@web/images/'. 'users/no-photo.png') ?>" class="img-circle"
                                 alt="<?=Yii::$app->user->identity->surname?>"/>

                            <p>
                                <?= Yii::$app->user->identity->surname?>
                                <small> <?= Yii::$app->user->identity->created_at;?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                             <div class="col-xs-4 text-center">
                                <?= Html::a(Yii::t('app', 'Отдел'), ['users/department']) ?>
                            </div>
                            <div class="col-xs-4 text-center">
                                <?= Html::a(Yii::t('app', 'My account'), ['/myaccount/']) ?>
                            </div>
                           
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a(Yii::t('app', 'Мои данные'), ['/myaccount/users/myprofile', 'id' => yii::$app->user->identity->id], ['class' => 'btn btn-default btn-flat']) ?>
                               
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Выйти',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
