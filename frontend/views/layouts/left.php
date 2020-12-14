<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use mdm\admin\components\Helper;
use mdm\admin\components\MenuHelper;

use kartik\form\ActiveForm;
use backend\models\ElementsSearch;

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <?php if (!\Yii::$app->user->isGuest): ?>
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?= Url::to('@web/images/'.'users/no-photo.png')//Yii::$app->user->identity->photo)?>" 
                     width="160px" class="img-circle" alt="<?= Yii::$app->user->identity->surname?>"/>
                </div>
                <div class="pull-left info">
                    <p><?= Yii::$app->user->identity->username;?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
        <?php endif; ?>
        <!-- search form -->
       <?php $form = ActiveForm::begin([
                        'action' => ['elements/index'],
                        'method' => 'get',
                        'class' => 'sidebar-form',
                      ]); ?>
                     <?php $searchElements = new ElementsSearch();
                     echo $form->field($searchElements, 'name', [
                         'template' => '<div class="input-group">{input}<span class="input-group-btn">' .
                             Html::submitButton('<i class="fa fa-search"></i>', ['id' => 'search-btn', 'class' => 'btn btn-flat']) .
                             '</span></div>',
                         ])->textInput(['placeholder' => 'Search element name']);
                         ?>
                <?php ActiveForm::end(); ?>
        
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => Yii::t('app', 'My profile'), 'options' => ['class' => 'header']],
                    [   
                        'label' => Yii::t('app', 'Main page'), 
                        'icon' => 'fa fa-id-card-o',
                        'url' => ['/myaccount/']
                    ],
                    
                    
                  
                 ],
            ])?>
        <?= dmstr\widgets\Menu::widget([
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => Yii::t('app', 'My Menu'), 'options' => ['class' => 'header']],
                    
                    [               
                        'label' => Yii::t('app', 'Requests'),
                        'items' => [
                            [
                                'label' => Yii::t('app', 'Create request'),
                                'url' => ['/myaccount/requests/create', 'iduser' => yii::$app->user->identity->id]
                            ],
                            [
                                'label' => Yii::t('app', 'My requests'),
                                'url' => ['/myaccount/requests/myrequests', 'iduser' => yii::$app->user->identity->id]
                            ],
                            [
                                'label' => Yii::t('app', 'All requests'), 
                                'icon' => 'fa fa-book',
                                'url' => ['/myaccount/requests/index']
                            ],
                            [
                                'label' => 'Назначить исполнителя',
                                'url' => ['/myaccount/requests/checkprocess'],
                             //    'visible' => yii::$app->user->can('head') || yii::$app->user->can('admin'),
                                 'visible' => yii::$app->user->identity->role == common\models\Users::USER_TYPE_SUPER_ADMIN || yii::$app->user->identity->role == common\models\Users::USER_TYPE_HEAD, //|| yii::$app->user->can('head')
                            ],
                            [
                                'label' => 'Заявки к обработке',
                                'url' => ['/processingrequest/byexecutor', 'iduser' => yii::$app->user->identity->id],
                              //  'visible' => yii::$app->user->can('admin') or yii::$app->user->can('PurchasegroupAccess'),
                                'visible' => yii::$app->user->identity->role == common\models\Users::USER_TYPE_SUPER_ADMIN || yii::$app->user->identity->role == common\models\Users::USER_TYPE_PURCHASING,
                            ],
                       
                          //  ['label' => 'Текущее состояние заявок', 'url' => ['prices/index']], //для отдела снабжения
                        ]
                    ],
                    
                    ['label' =>  Yii::t('app', 'Номенклатура товаров'), 'icon' => 'fa fa-bars', 'url' => ['elements/index']],
                    ['label' => 'Категории товаров', 'url' => ['/myaccount/category/index']],
                  
                 
                    ['label' => 'Последнее поступление', 'url' => ['/myaccount/receipt/lastreceive']],
                    [
                        'label' => 'Счета',
                            'items' => [
                                [
                                    'label' => 'Текущие счета',
                                    'url' => ['/myaccount/paymentinvoice/index']
                                ],
                                [
                                    'label' => 'Товары в счете',
                                    'url' => ['/myaccount/accounts/index', 'iduser' => yii::$app->user->identity->id],
                                  //  'visible' => yii::$app->user->can('admin') or yii::$app->user->can('Purchasegroup'),   
                                    //'visible'=> UserPermissions::canAdminUsers()
                                   
                                ],
                                [
                                    'label' => 'Недостачи по поставщикам',
                                    'url' => ['/myaccount/accounts/shortage']
                                  ],
                            ]
                    ],
                    [
                        'label' => 'Проекты',
                        'items' => [
                            [
                                'label' => yii::t('app', 'Current projects'),
                                'url' => ['/myaccount/themes/indexshort']
                            ],
                            [
                                'label' => yii::t('app', 'All projects'),
                                'url' => ['/myaccount/themes/index'],
                                'visible' => yii::$app->user->can('admin') or yii::$app->user->can('manager'), 
                            ],
                            [
                                'label' => 'Подмодули проектов',
                                'url' => ['/myaccount/themeunits/index']
                            ],
                            [
                                'label' => yii::t('app', 'Current boards'),
                                'url' => ['/myaccount/boards/currentboard']
                            ],
                            [
                               'label' => 'Список Недостач по платам',
                                'url' => ['/myaccount/shortage']
                            ],
                            [
                               'label' => yii::t('app', 'All boards'),
                               'url' => ['/myaccount/boards/index']
                            ],
                            [
                                'label' => yii::t('app', 'My boards'),
                                'url' => ['/myaccount/boards/myboards', 'iduser' => yii::$app->user->identity->id],
                             //???   'visible' => yii::$app->user->can('admin'), 
                            ],
                        ]
                     ],
                     [
                        'label' => 'Список',
                        'items' => [
                            [
                                'label' => yii::t('app', 'Manufacturers'),
                                'url' => ['/myaccount/produce/index']
                            ],
                            [
                                'label' => yii::t('app', 'Suppliers'),
                                'icon' => 'fa fa-address-book-o',
                                'url' => ['/myaccount/supplier/index']
                            ],
                            [
                                'label' => yii::t('app', 'Co-workers'),
                                'icon' => 'fa fa-users',
                                'url' => ['/myaccount/users/index'],
                                'visible' => yii::$app->user->can('admin'), 
                            ],
                            [
                                'label' => yii::t('app', 'Payers'),
                                'icon' => 'fa fa-tty',
                                'url' => ['/myaccount/payer/index']
                            ],
                            [
                                'label' => yii::t('app', 'Currency'),
                                'url' => ['/myaccount/currency/index']
                            ],
                           
                       ]
                    ],
               
                    [   
                        'label' => Yii::t('app', 'Personal details'), 
                        'icon' => 'fa fa-user-circle',
                        'url' => ['/myaccount/users/myprofile', 'id' => yii::$app->user->identity->id]
                    ],

                ],
            ])?>
    </section>

</aside>