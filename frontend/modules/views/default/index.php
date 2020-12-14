<?php
use kartik\form\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\widgets\NewExecutorWidget; 
use yii\helpers\Url;
use common\widgets\LanguageSelector;
use yii\widgets\ListView;



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
    <section class="connectedSortable">
        <div class="search-form">
           
            <?php $form = ActiveForm::begin([
                        'action' => ['elements/index'],
                        'method' => 'get',
                      ]); ?>
                     <?= $form->field($searchElements, 'searchstring', [
                         'template' => '<div class="input-group col-md-6">{input}<span class="input-group-btn" >' .
                             Html::submitButton('Search', ['class' => 'btn btn-default']) .
                             '</span></div>',
                         ])->textInput(['placeholder' => 'Поиск по номенклатуре товаров']);
                         ?>
            <?php ActiveForm::end(); ?>
            <?php $form = ActiveForm::begin([
                        'action' => ['requests/index'],
                        'method' => 'get',
                      ]); ?>
                     <?= $form->field($searchElements, 'searchstring', [
                         'template' => '<div class="input-group col-md-6">{input}<span class="input-group-btn" >' .
                             Html::submitButton('Search', ['class' => 'btn btn-default']) .
                             '</span></div>',
                         ])->textInput(['placeholder' => 'Поиск по заявкам']);
                         ?>
            <?php ActiveForm::end(); ?>
        </div> 
      
    <div class="row">
        <div class="col-md-6">
          
            <div class=" box box-warning">
                <div class="box-header with-border"><i class="glyphicon glyphicon-signal"></i><h3 class="box-title">Мои заявки</h3></div>
                <div class="box-body">
                    <div class="col-sm-4 border-right">
                        <center>
                            <h3><?= Html::a($statusactive = 1, ['requests/myrequests', 'iduser' => yii::$app->user->identity->id])//where status=0 ?></h3>
                            <span class="description-text">Не обработаны</span>
                            
                        </center>
                    </div>
                    <div class="col-sm-4 border-right">
                        <center>
                            <h3><?= Html::a($statusactive = 4, ['requests/myrequests', 'iduser' => yii::$app->user->identity->id])//where status=1 ?></h3>
                            <span class="description-text">Активные</span>
                        </center>
                    </div>
                    <div class="col-sm-4">
                        <center>
                            <h3><?= Html::a(count($modelrequests->idrequest), ['requests/myrequests', 'iduser' => yii::$app->user->identity->id])//where status=2 ?></h3>
                            <span class="description-text">Заблокировано</span>        
                        </center>
                    </div>
                </div>  
            </div><!--/.box-->
        </div>
        <div class="col-md-6">
             <div class="box bg-info box-danger">  
                <div class="box-header with-border">
                    <div class="box-title"><?php echo Yii::t('app', 'Welcome, '), Yii::$app->user->identity->surname. ' '. Yii::$app->user->identity->name. '! ';?></div>
                    <div class="box-tools pull-right" >
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="modal-body">
                        <span>Приветствуем вас в системе. Посмотрите <a href="<?= yii::$app->urlManager->createUrl(['/myaccount/default/instruction'])?>" style="color: red">инструкцию</a> по работе c данной системой. <br/>
                            </span>
                        <p>В <?= Html::a('Мои данные', ['users/myprofile', 'id' => yii::$app->user->identity->id], ['style' => 'color:red']) ?> можно внести или отредактировать свои личные данные</p>
                    </div>
               
                </div>
            </div>
        </div>
        <div class="col-md-6">
            
        </div>
        
    </div><!--/.row-->
       
      <div class="row">   
        <div class="col-md-6">
            <!--Form for create request-->
            <div class="box box-success">
                <div class="box-header with-border"><i class="glyphicon glyphicon-envelope"></i><h3 class="box-title">Создать заявку</h3>
                    <div class="pull-right box-tools">
                       
                        <button type="button" class="btn btn-info" data-widget="collapse"><i class="fa fa-times"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="requests-create">
                        <?php Pjax::begin(); ?>
                            <?php /* $this->render('_formrequest', [
                                        'model' => $modelrequests,
                            ])*/ ?>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
   
        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header with-border"><i class="glyphicon glyphicon-tree-tasks"></i><h3 class="box-title">Мои платы</h3></div>
                <div class="box-body">
                     <?php Pjax::begin(); ?>
                            <?= $this->render('_myboards', [
                                        'model' => $modelBoard,
                                        'dataProviderBoard'=>$dataProviderBoard,
                                       // 'searchModelTheme'=>$searchModelBoard
                            ]) ?>
                    <?php Pjax::end(); ?>
                
                 <div class="box-footer pull-left">
                    <?=  Html::a(Html::encode('Create new board'), Url::to(['boards/create', 'iduser' => yii::$app->user->identity->id]), ['class' => 'btn btn-success']);?>
                </div>
                    </div>
            </div><!-- /.box -->
        </div>
            
        <div class="col-md-3">
            <div class="box box-default">
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

            </div><!-- /.box -->
        </div>
         
            
           
      </div> <!--/.row-->
      <div class="row">
          <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border"><i class="glyphicon glyphicon-tree-tasks"></i><h3 class="box-title">Текущие проекты</h3>
                    <div class="pull-right box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                   
                    <?php Pjax::begin(); ?>
                            <?= $this->render('_projectlist', [
                                        'model' => $modelTheme,
                                        'dataProviderTheme'=>$dataProviderTheme,
                                        'searchModelTheme'=>$searchModelTheme
                            ]) ?>
                    <?php Pjax::end(); ?>
                </div>
                </div>
          </div>
          <div class="col-md-6">
              <div class="box box-info">
                <div class="box-header with-border"><i class="glyphicon glyphicon-tree-tasks"></i><h3 class="box-title">My requests</h3></div>
                <div class="box-body">
                    <?php Pjax::begin(); ?>
                            <?= $this->render('_requestlist', [
                                        'model' => $modelrequests,
                                        'dataProviderreq' => $dataProviderreq,
                                        'searchModelreq' => $searchModelreq
                            ]) ?>
                    <?php Pjax::end(); ?>
                </div>
                <div class="box-footer text-center">
                    <?=  Html::a(Html::encode('View all Requests'), Url::to(['requests/myrequests', 'iduser' => yii::$app->user->identity->id]));?>
                </div>
                </div>
          </div>
      </div>
</section>
</div>

<script>
//$(document).ready(function(){
  //  .change(function(){
      //  if(yii::$app->user->can('admin') or yii::$app->user->can('head')){
        //    $('#paymentinvoice-index').style.display="block"; 
     //   }
 //   });
//});
</script>
