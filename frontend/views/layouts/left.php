<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use mdm\admin\components\Helper;
use mdm\admin\components\MenuHelper;

?>
<aside class="main-sidebar">

    <section class="sidebar">

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
     <?= dmstr\widgets\Menu::widget([
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => Yii::t('app', 'My profile'), 'options' => ['class' => 'header']],
                    [   
                        'label' => Yii::t('app', 'Main page'), 
                        'icon' => 'fa fa-id-card-o',
                        'url' => ['/myaccount/']
                    ],
                   
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
                              'label' => 'Журнал заявок', 'icon' => 'fa fa-book',
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
                                'url' => ['/myaccount/processingrequest/byexecutor', 'iduser' => yii::$app->user->identity->id],
                              //  'visible' => yii::$app->user->can('admin') or yii::$app->user->can('PurchasegroupAccess'),
                                'visible' => yii::$app->user->identity->role == common\models\Users::USER_TYPE_SUPER_ADMIN || yii::$app->user->identity->role == common\models\Users::USER_TYPE_PURCHASING,
                            ],
                       
                          //  ['label' => 'Текущее состояние заявок', 'url' => ['prices/index']], //для отдела снабжения
                        ]
                    ],
                  
              
                   
                 
                 

                ],
            ])?>
        <?= dmstr\widgets\Menu::widget([
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => Yii::t('app', 'My Menu'), 'options' => ['class' => 'header']],
                    
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
                                'label' => 'Список Текущих проектов',
                                'url' => ['/myaccount/themes/indexshort']
                            ],
                            [
                                'label' => 'Список Всех проектов',
                                'url' => ['/myaccount/themes/index'],
                                'visible' => yii::$app->user->can('admin') or yii::$app->user->can('manager'), 
                            ],
                            [
                              'label' => 'Подмодули проектов',
                             'url' => ['/myaccount/themeunits/index']
                            ],
                            [
                               'label' => 'Список Текущих плат',
                             'url' => ['/myaccount/boards/currentboard']
                            ],
                            [
                               'label' => 'Список Всех плат',
                             'url' => ['/myaccount/boards/index']
                            ],
                            [
                                'label' => 'Мои платы',
                                'url' => ['/myaccount/boards/myboards', 'iduser' => yii::$app->user->identity->id],
                             //???   'visible' => yii::$app->user->can('admin'), 
                            ],
                        ]
                     ],
                     [
                        'label' => 'Список',
                        'items' => [
                            [
                                'label' => 'Производителей',
                                'url' => ['/myaccount/produce/index']
                            ],
                            [
                                'label' => 'Поставщиков',
                                'icon' => 'fa fa-address-book-o',
                                'url' => ['/myaccount/supplier/index']
                            ],
                            [
                                'label' => 'Сотрудники',
                                'icon' => 'fa fa-users',
                                'url' => ['/myaccount/users/index'],
                                'visible' => yii::$app->user->can('admin'), 
                            ],
                            [
                                'label' => 'Плательщики',
                                'icon' => 'fa fa-tty',
                                'url' => ['/myaccount/payer/index']
                            ],
                            [
                                'label' => 'Валют',
                                'url' => ['/myaccount/currency/index']
                            ],
                           
                       ]
                    ],
                    [
                        'label' => Yii::t('app', 'Language'),
                       // 'visible' => yii::$app->user->can('admin') or yii::$app->user->can('manager'),    
                       // 'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->id == common\models\Users::ROLE_ADMIN,
                        'visible' => Yii::$app->user->identity->role == yii::$app->user->can('admin') or yii::$app->user->can('manager'),
                        'items' => [
                            [ 'label' => Yii::t('app', 'Messages'), 'url' => ['/myaccount/message/index']],
                            [ 'label' => Yii::t('app', 'Source Message'), 'url' => ['/myaccount/SourceMessage/index']],
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
