<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">
        
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
    
            <ul class="nav navbar-nav">

             
               
               <?php
                 NavBar::begin([
                   'options' => [
                         'class' => 'navbar navbar-fixed-top',
                         ],
                    ]);
    
                  $menuItems = [
                       ['label' => 'Главная', 'url' => ['/site/index']],
                       ['label' => 'Товары', 'url' => ['/myaccount/elements/index']],
                       ['label' => 'Последнее поступление', 'url' => ['/myaccount/receipt/index']],
         
                    ];

                echo Nav::widget([
                      'options' => ['class' => 'navbar-nav navbar-top'],
                      'items' => $menuItems,
                     ]);
               NavBar::end();
                 ?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">                     
                       
                    </a>
               
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= Url::to('@web'.Yii::$app->user->identity->photo) ?>" class="user-image" alt="<?=Yii::$app->user->identity->surname?>"/>
                        <span class="hidden-xs">katherina</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= Url::to('@web'.Yii::$app->user->identity->photo) ?>" class="img-circle"
                                 alt="<?=Yii::$app->user->identity->surname?>"/>

                            <p>
                                
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                   
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Профиль</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Выход',
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

         
    