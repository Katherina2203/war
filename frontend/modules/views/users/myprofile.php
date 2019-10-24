<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\Tabs;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = yii::t('app', 'My profile');
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['department']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">

    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
               <div class="box-body box-profile">
                
                    <img src="<?= Url::to('@web/images/'.'users/no-photo.png')//Yii::$app->user->identity->photo) ?>" class="profile-user-img img-responsive img-circle" alt="<?= Yii::$app->user->identity->surname?>"/>
                    <h3 class="profile-username text-center"><?= $model->userName ?></h3>
                    <p class="text-muted text-center"> <?= $model->role ?></p>
               </div> 
            </div>
            <div class="box box-primary">
               <div class="box-header with-border">
                   <h3 class="box-title"><i class="fa fa-file-text-o"></i> <?= yii::t('app', 'About me') ?></h3>
                     </div> 
                   <div class="box-body">
                       <strong><?= yii::t('app', 'Birthday')?></strong>
                        <p class="text-muted"> <?= $model->birthday ?></p>
                        <strong><?= yii::t('app', 'Email')?></strong>
                        <p class="text-muted"> <?= $model->email ?></p>
                   </div>
             
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="nav-tabs-custom">
                <?= Tabs::widget([
                    'items' => [
                        [
                            'label' => yii::t('app', 'Personal data'),
                            'content' =>  $this->render('viewmyprofile', ['model' => $model]),
                            'active' => true // указывает на активность вкладки
                        ],
                        [
                            'label' => yii::t('app', 'Update photo'),
                            'content' =>  $this->render('_foto', ['model' => $model]),

                        ],
                        [
                            'label' => 'My activities',
                            'content' =>  $this->render('_myactivities', ['model' => $modelout, 'dataProviderout' => $dataProviderout]),
                        ],
                     /*   [
                            'label' => 'Пароль',
                            'content' =>  $this->render('changepassword', ['model' => $model]),
                            'headerOptions' => [
                                'id' => 'someId'
                            ]
                        ],*/
                       /* [
                            'label' => 'Radar site',
                            'url' => 'http:\\www.radar.kharkov.ua',
                        ],*/

                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
</div>