<?php
//use common\widgets\CategoriesWidget;
use kartik\form\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\widgets\NewExecutorWidget; 
use yii\helpers\Url;

use common\models\Themes;
use common\models\Produce;
use common\models\Supplier;
use common\models\Users;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    
    ];

$this->title = 'Мой профиль';
?>
   
<div class="site-index">
    <div class="col col-md-6">
        <div class="search-form">
            <?php $form = ActiveForm::begin([
                       'action' => ['elements/index'],
                            'method' => 'get',
                          ]); ?>
                         <?php echo $form->field($searchElements, 'searchstring', [
                             'template' => '<div class="input-group">{input}<span class="input-group-btn">' .
                                 Html::submitButton('Search in', ['class' => 'btn btn-default']) .
                                 '</span></div>',
                             ])->textInput(['placeholder' => 'Search in elements']);
                             ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="col col-md-6">
         <div class="search-form">
                    <?php $form = ActiveForm::begin([
                            'action' => ['elements/index'],
                            'method' => 'get',
                          ]); ?>
                         <?php echo $form->field($searchElements, 'searchstring', [
                             'template' => '<div class="input-group">{input}<span class="input-group-btn">' .
                                 Html::submitButton('Search in', ['class' => 'btn btn-default']) .
                                 '</span></div>',
                             ])->textInput(['placeholder' => 'Here will be Search in requests']);
                             ?>
                    <?php ActiveForm::end(); ?>
            </div>
    </div>
    <section class="connectedSortable">
       
    <div class="row">
        <div class="col col-md-4">
        <div class="box">
            <div class="box-header with-border"><i class="glyphicon glyphicon-signal"></i><h3 class="box-title">Статистика заявок</h3></div>
                <div class="box-body">
                    <div class="col-sm-3">
                        <center><h3><?= Html::a('1', ['/requests/myrequests', 'iduser'=> yii::$app->user->identity->id]) ?></h3>
                            <?= Html::a('Новые', ['/requests/myrequests', 'iduser'=> yii::$app->user->identity->id]) ?>
                        </center>
                    </div>
                    <div class="col-sm-3">
                        <center><div class="box-request"><h3>2</h3></div>
                           <?= Html::a('Мои  заявки', ['/requests/myrequests', 'iduser'=> yii::$app->user->identity->id]) ?>
                        </center>
                    </div>
                    <div class="col-sm-3">
                        <center><h3>0</h3>
                            <?= Html::a('Заблокировано', ['/requests/myrequests', 'iduser'=> yii::$app->user->identity->id]) ?>
                        </center>
                    </div>
                </div>
        </div>
        </div> <!-- end class col-md-6-->
        <div class="col col-md-2">
            <div class="box box-solid">
                <div class="box-body bg-gray-light language">
                    <div class="box-header with-border"><i class="glyphicon glyphicon-tree-deciduous"></i><h3 class="box-title">Языки</h3></div>
                    <div id="current-lang">
                        <span class="box-title"><?= Yii::t('app', 'Current language:') . Yii::$app->language;?></span>
                        <!--    <div  id="language-selector" class="pull-left" style="position: relative; top: 60px;">
                                <?= common\widgets\LanguageSelector::widget(); ?>
                            </div>-->
                    </div>
                    <div class="small-box-footer">
                        <select>
                            <option>English</option>
                            <option>Русский</option>
                        </select>
                    </div>
                 
                </div>
            </div>
        </div> <!-- end class col-md-2-->
        <div class="col col-md-3">
            <div class="box-solid bg-info">  <!--style="background: #d7ecf7; border: 1px solid #9acfea;"   small-box bg-info-->
                <div class="box-header with-border"><?php echo Yii::t('app', 'Welcome, '), Yii::$app->user->identity->surname. '! ';?></div>
                <div class="box-body">
                    
                    <div class="modal-body">

                      <span>Приветствуем вас в системе. Вы можете посмотреть инструкции по работе базы данных 
                          <a href="<?= yii::$app->urlManager->createUrl(['/myaccount/default/instruction'])?>">здесь</a>. <br/>
                          Если вы не нашли ответа на свой вопрос, обратитесь к администрации.</span>
                     </div>
                     <!--     <div class="box-footer">
                            <a href="<?= yii::$app->urlManager->createUrl(['/myaccount/default/instruction'])?>">More <i class="fa fa-arrow-circle-right"></i> </a>
                        </div>-->
                </div>
            </div>
        </div>
        
        
    </div>   <!-- end class row-->
    
    <div class="row">
        <div class="col col-md-6">
            <div class="box">
                    <div class="box-header with-border"><i class="glyphicon glyphicon-envelope"></i><h3 class="box-title">Создать заявку</h3>
                        <div class="pull-right box-tools">
                            <?= Html::a('<i class="fa fa-times"></i>', ['remove', 'id' => $modelrequests->idrequest], ['class' => 'btn btn-info btn-xs']) ?>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="requests-create">
                            <?php Pjax::begin(); ?>
                                <?= $this->render('_formrequest', [
                                            'model' => $modelrequests,
                                ]) ?>
                            <?php Pjax::end(); ?>
                        </div>
                    </div>
            </div>
        </div>
        <div class="col col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border"><i class="glyphicon glyphicon-tree-tasks"></i><h3 class="box-title">Объявления</h3></div>
                <div class="box-body">
                    <?php 
                        $model = common\models\Adverts::find()->all();
                        if(count($model)):?>
                        <?php foreach ($model as $advert):?>
                            <div class="block-advert" style="border: 1px solid #ccc; border-radius: 4px; margin-bottom: 15px; background-color: #F7F7F7">
                       <div class="adverts-date" style="color: grey; padding-left: 20px;padding-top: 10px;"><?= $advert->created_at?></div>
                       <div class="textadvert" style="padding: 10px; ">
                                   <p><?= $advert->content?></p>
                            </div>       
                        </div>
                    <?php endforeach;?>
               <?php endif ?> 
               </div>
            </div>
        </div>
    </div>    <!-- end class row-->    
    
    <div class="row"> 
            <div class="col col-md-8">
               
            <?php Pjax::begin(['id' => 'requests-index']); ?>  
                <?php GridView::widget([
                    'dataProvider' => $dataProviderreq,
                    'filterModel' => $searchModelreq,
                    'tableOptions' => [
                        'class' => 'table table-striped table-bordered'
                    ],
                     'rowOptions' => function($model, $key, $index, $grid){
                        if($model->status == '0'){  // not active
                            return ['class' => 'warning'];  //active class => 'sucess'   label label-primary glyphicon glyphicon-ok
                        }elseif($model->status == '1'){  //active
                             return ['class' => 'success']; //unactive color: #b2b2b2 label label-danger glyphicon glyphicon-remove
                        }elseif($model->status == '2'){ //cancel
                            return ['style' => 'label label-default glyphicon glyphicon-time']; //cancel f97704 - orange color:#c48044
                        }elseif($model->status = '3'){ //done
                            return ['style' => 'color:#b2b2b2'];
                        }
                    },
                    'pjax' => true,
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'hover' => true,
               //     'columns' => $gridColumns,
                    'resizableColumns'=>true,
                    'panel'=>['type'=>'primary', 'heading'=>'Новые заявки'],
                    'columns' => [
                      //  ['class' => 'yii\grid\SerialColumn'],
                        [
                          'attribute' => 'idrequest',
                          'label' =>'#Заявки'
                        ],
                        [
                          'attribute' => 'name',
                          'format'=>'raw',
                           'value' => function ($model, $key, $index) { 
                                return Html::a($model->name, ['requests/view', 'id' => $model->idrequest]);
                            },
                        ],
                        [
                            'attribute' => 'quantity',
                            'format'=>'raw',
                            'value'=>function ($data){
                            return '<center><strong>'.$data->quantity.'</strong></center>';
                            }
                        ],
                        'required_date',
                        [
                            'attribute' => 'idproject',
                            'value' => 'themes.name',
                            'format' => 'text',
                            'filter' => Html::activeDropDownList($searchModelreq, 'idproduce', Themes::find()->select(['name', 'idtheme'])->indexBy('idtheme')->where(['status' => 'active'])->column(), ['class' => 'form-control', 'prompt' => 'Выберите проект']),
                            'contentOptions'=>['style'=>'width: 80px;'],
                        ],
                        [
                            'attribute' => 'iduser',
                            'value' => 'users.surname',
                            'format' => 'text',
                            'filter' => Html::activeDropDownList($searchModelreq, 'iduser',Users::find()->select(['surname', 'id'])->indexBy('id')->column(), ['class' => 'form-control', 'prompt' => 'Select user'])
                        ],
                        'note',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
           <?php Pjax::end(); ?> 
                 
        </div>

    
            
    </section>
   
            
            
           
            
        

   
  
    </div>


