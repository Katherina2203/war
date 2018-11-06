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
        <div class="col-md-4">
            <div class="box box-danger">
                <div class="box-header with-border"><i class="glyphicon glyphicon-signal"></i><h3 class="box-title">Мои заявки</h3></div>

                <div class="box-body">
                <div class="col-sm-3">
                    <center>
                        <h3><?= Html::a(count($modelrequests->idrequest), ['/requests/myrequests', 'iduser'=> yii::$app->user->identity->id])//where status=0 ?></h3>
                        <?= Html::a('Новые', ['/requests/myrequests', 'iduser'=> yii::$app->user->identity->id]) ?>
                    </center>
                </div>
                <div class="col-sm-3">
                    <center>
                        <h3><?= Html::a(count($modelrequests->idrequest), ['/requests/myrequests', 'iduser'=> yii::$app->user->identity->id])//where status=0 ?></h3>
                        <?= Html::a('Активные', ['/requests/myrequests', 'iduser'=> yii::$app->user->identity->id]) ?>
                    </center>
                </div>
                <div class="col-sm-3">
                    <center>
                        <h3><?= Html::a(count($modelrequests->idrequest), ['/requests/myrequests', 'iduser'=> yii::$app->user->identity->id])//where status=0 ?></h3>
                        <?= Html::a('Заблокировано', ['/requests/myrequests', 'iduser'=> yii::$app->user->identity->id]) ?>
                    </center>
                </div>
                </div>  
            </div><!--/.box-->
        </div>
      </div><!--/.row-->
       
      <div class="row">   
        <div class="col-md-8">
            <!--Form for create request-->
           <div class="box box-success">
                <div class="box-header with-border"><i class="glyphicon glyphicon-envelope"></i><h3 class="box-title">Создать заявку</h3>
                    <div class="pull-right box-tools">
                       
                         <button class="btn btn-info" data-widget="collapse"><i class="fa fa-times"></i></button>
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
   
    
        <div class="col-md-4">
            <div class="box">
             <div class="box-solid bg-primary">  <!--style="border: 1px solid #9acfea;"  small-box bg-info-->
                <div class="box-header with-border"><?php echo Yii::t('app', 'Welcome, '), Yii::$app->user->identity->surname. '! ';?></div>
                <div class="box-body">
                    <div class="modal-body">
                        <span>Приветствуем вас в системе. Посмотрите <a href="<?= yii::$app->urlManager->createUrl(['/myaccount/default/instruction'])?>" style="color: red">инструкцию</a> по работе c данной системой. <br/>
                             Если вы не нашли ответа на свой вопрос, обратитесь к администрации. </span>
                        <p>В <?= Html::a('Мои данные', ['users/myprofile', 'id' => yii::$app->user->identity->id], ['style' => 'color:red']) ?> можно внести или отредактировать свои личные данные</p>
                    </div>
               
                </div>
            </div>
            </div>

            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-tree-deciduous"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Языки</span>
                    <span><?= Yii::t('app', 'Current language: ') . '<strong>' . Yii::$app->language . '</strong>';?></span>
                    <span class="info-box-number">
                          <?= LanguageSelector::widget(); ?>
                    </span>
                  
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
              
              
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
       
 
           
            </div><!-- /.box -->
        </div>
            
           
      </div> <!--/.row-->
      <div class="row">
          <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border"><i class="glyphicon glyphicon-tree-tasks"></i><h3 class="box-title">Текущие проекты</h3></div>
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
              <div class="box box-warning">
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
