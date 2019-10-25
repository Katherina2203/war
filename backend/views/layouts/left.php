<?php
use yii\helpers\Url;

//Sidebar user panel 
if (!\Yii::$app->user->isGuest): ?>
    <div class="user-panel">
        <div class="pull-left image">
            <?php echo \cebe\gravatar\Gravatar::widget(
                [
                    'email'   => (\Yii::$app->user->identity->profile->email === null)
                                ? \Yii::$app->user->identity->email 
                                : \Yii::$app->user->identity->profile->email,
                    'options' => [
                        'alt' => \Yii::$app->user->identity->username
                    ],
                    'size'    => 64
                ]
            ); ?>
        </div>
        <div class="pull-left info">
            <p><?= \Yii::$app->user->identity->username ?></p>

            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
<?php endif; ?>

<?php

// prepare menu items, get all modules
$menuItems = [];

$favouriteMenuItems[] = ['label'=>'MAIN NAVIGATION', 'options'=>['class'=>'header']];
$developerMenuItems = [];
/*
foreach (Metadata::getModules() as $name => $module) {
    $role                        = $name;

    $defaultItem = [
        'icon' => 'cube',
        'label'   => $name,
        'url'     => ['/' . $name],
        'visible' => Yii::$app->user->can($role) || (Yii::$app->user->identity && Yii::$app->user->identity->isAdmin),
        'items'   => []
    ];

    // check for module configuration and assign to favourites
    $moduleConfigItem = (is_object($module)) ?
        (isset($module->params['menuItems']) ? $module->params['menuItems'] : []) :
        (isset($module['params']['menuItems']) ? $module['params']['menuItems'] : []);
    switch (true) {
        case (!empty($moduleConfigItem)):
            $moduleConfigItem            = array_merge($defaultItem, $moduleConfigItem);
            $moduleConfigItem['visible'] = \dmstr\helpers\RouteAccess::can($moduleConfigItem['url']);
            $favouriteMenuItems[]        = $moduleConfigItem;
            continue 2;
            break;
        default:
            $defaultItem['icon'] = 'circle-o';
            $developerMenuItems[] = $defaultItem;
            break;
    }
}
*/
// create developer menu, when user is admin
if (Yii::$app->user->identity && Yii::$app->user->identity->isAdmin) {
    $menuItems[] = [
        'url' => '#',
        'icon' => 'cog',
        'label'   => 'Developer',
        'items'   => $developerMenuItems,
        'options' => ['class' => 'treeview'],
        'visible' => Yii::$app->user->identity->isAdmin
    ];
}

echo dmstr\widgets\Menu::widget([
    'options' => ['class' => 'sidebar-menu'],
    'items' => \yii\helpers\ArrayHelper::merge($favouriteMenuItems, $menuItems),
]);
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
               <img src="<?= Url::to('@web/images/'.'users/no-photo.png')//Yii::$app->user->identity->photo)?>" 
                     width="160px" class="img-circle" alt="<?= Yii::$app->user->isGuest ? 'guest' : Yii::$app->user->identity->surname?>"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->isGuest ? 'guest' : Yii::$app->user->identity->username?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    [   
                        'label' => Yii::t('app', 'My profile'), 
                        'icon' => 'fa fa-id-card-o',
                        'url' => ['/site/index'],
                        
                    ],
                    ['label' => Yii::t('app', 'Menu'), 'options' => ['class' => 'header']],
                    [              
                        'label' => Yii::t('app', 'Requests'),
                        'items' => [
                            [
                              'label' => Yii::t('app', 'Create request'),
                              'url' => ['/requests/create', 'iduser' => Yii::$app->user->isGuest ? 'guest' : Yii::$app->user->identity->id],
                            ],
                         /*   [
                              'label' => Yii::t('app', 'My requests'), //'Мои заявки'
                              'url' => ['/myaccount/requests/myrequests', 'iduser' => yii::$app->user->identity->id],
                            ],*/
                            [
                                'label' => Yii::t('app', 'All requests'), //'Журнал заявок'
                                'icon' => 'fa fa-book',
                                'url' => ['/requests/index']
                            ],
                            [
                                'label' => 'Заявки к обработке',
                                'url' => ['/processingrequest/byexecutor', 'iduser' => Yii::$app->user->isGuest ? 'guest' : yii::$app->user->identity->id],
                                'visible' => yii::$app->user->can('admin') or yii::$app->user->can('Purchasegroup'),
                            ],
                            [
                                'label' => yii::t('app', 'Change status'),
                                'url' => ['/requests/changestatus', 'iduser' => Yii::$app->user->isGuest ? 'guest' : yii::$app->user->identity->id],
                                'visible' => yii::$app->user->can('admin') or yii::$app->user->can('Purchasegroup'),
                            ],
                          /*  [
                                'label' => 'Распределение текущих заявок',
                                'url' => ['/processingrequest/index'],
                                'visible' => yii::$app->user->can('admin') or yii::$app->user->can('head'),
                            ],*/
                            [
                                'label' => 'Назначить исполнителя',
                                'url' => ['/requests/checkprocess'],
                               // 'visible' => yii::$app->user->roles->head,
                                'visible' => yii::$app->user->can('admin') or yii::$app->user->can('head'), //was or instead &&
                             //  'visible' =>!Yii::$app->user->isGuest && Yii::$app->user->identity->role == common\models\User::findIdentity($this->id = 33),
                            ],
                         /*   [
                                'label' => 'Журнал заказов',
                                'url' => ['/purchaseorder/index']
                            ],*/
                         //   ['label' => 'Цены', 'url' => ['prices/index']],
                           // ['label' => 'Новые заявки', 'url' => ['prices/index']], //для отдела снабжения
                         //   ['label' => 'Текущее состояние заявок', 'url' => ['prices/index']], //для отдела снабжения
                           
                        ]
                    ],
                    [
                        'label' => Yii::t('app', 'Invoices'),
                        'icon' => 'fa fa-abacus',
                       'url' => ['/paymentinvoice/index'],
                        /*    'items' => [
                                [
                                    'label' => 'Текущие счета',
                                    'url' => ['/paymentinvoice/index']
                                ],
                             /*   [
                                    'label' => 'Товары в счете',
                                    'url' => ['/accounts/index', 'iduser' => yii::$app->user->identity->id],
                                    'visible' => yii::$app->user->can('admin') or yii::$app->user->can('Purchasegroup'),   
                                ],
                                [
                                    'label' => 'Недостачи по поставщикам',
                                    'url' => ['/accounts/shortage']
                                  ],
                            ]*/
                    ],
                    ['label' => yii::t('app', 'Elements'), 'icon' => 'fa fa-bars', 'url' => ['/elements/index']],
                    ['label' => yii::t('app', 'Categories'), 'url' => ['/category/index']],
                    [               
                        'label' => 'Sked tools',
                        'items' => [
                            [
                              'label' => yii::t('app', 'Recent receipts'),
                              'url' => ['/receipt/lastreceive']
                            ],
                            [
                              'label' => yii::t('app', 'Receipt to the warehouse'),
                              'url' => ['/receipt/index']
                            ],
                            [
                              'label' => yii::t('app', 'Returns on stock'),
                              'url' => ['/returnitem/index']
                            ],
                           //параметры для поиска, свойства к категориям
                        ]
                    ],
                    
                    [
                        'label' => yii::t('app', 'Projects'),
                        'items' => [
                            [
                                'label' => yii::t('app', 'Current projects'),
                                'url' => ['/themes/indexshort']
                            ],
                            [
                                'label' => yii::t('app', 'All projects'),
                                'url' => ['/themes/index'],
                                'visible' => yii::$app->user->can('admin') or yii::$app->user->can('manager'), 
                            ],
                            [
                              'label' => 'Подмодули проектов',
                             'url' => ['/themeunits/index']
                            ],
                            [
                               'label' => yii::t('app', 'Current boards'),
                                'url' => ['/boards/currentboard']
                            ],
                            [
                               'label' => 'Список Недостач по платам',
                                'url' => ['/shortage']
                            ],
                            [
                               'label' => yii::t('app', 'All boards'),
                               'url' => ['/boards/index']
                            ],
                            [
                                'label' => yii::t('app', 'My boards'),
                                'url' => ['/boards/myboards', 'iduser' => Yii::$app->user->isGuest ? 'guest' : yii::$app->user->identity->id],
                             //???   'visible' => yii::$app->user->can('admin'), 
                            ],
                        ]
                     ],
                  
                    ['label' => yii::t('app', 'BOM'), 'url' => ['/themes/boardscost']],
                   
                    [
                        'label' => yii::t('app', 'Withdraw'), 
                        'icon' => 'fa fa-external-link',
                        'url' => ['/outofstock/index', 
                        'iduser' => Yii::$app->user->isGuest ? 'guest' : yii::$app->user->identity->id],
                    ], 
                    [
                        'label' => yii::t('app', 'Announcements'), 
                        'url' => ['/adverts/index'], 
                        'visible' => yii::$app->user->can('admin') or yii::$app->user->can('head'), 
                    ],
                    [
                        'label' => yii::t('app', 'Lists'),
                        'items' => [
                            [
                                'label' => yii::t('app', 'Manufacturers'),
                                'url' => ['/produce/index']
                            ],
                            [
                                'label' => yii::t('app', 'Suppliers'),
                                'icon' => 'fa fa-address-book-o',
                                'url' => ['/supplier/index']
                            ],
                            [
                                'label' => yii::t('app', 'Co-workers'),
                                'icon' => 'fa fa-users',
                                'url' => ['/users/index'],
                                'visible' => yii::$app->user->can('admin'), 
                            ],
                            [
                                'label' => yii::t('app', 'Payers'),
                                'icon' => 'fa fa-tty',
                                'url' => ['/payer/index']
                            ],
                            [
                                'label' => yii::t('app', 'Currency'),
                                'url' => ['/currency/index']
                            ],
                            [
                                'label' => yii::t('app', 'Types of requests'),
                                'url' => ['/typerequest/index'],
                                'visible' => yii::$app->user->can('admin'), 
                            ],
                       ]
                    ],
                    [               
                        'label' => yii::t('app', 'Users tools'),
                        'items' => [
                            [
                                'label' => 'RBAC-access rules',
                                'url' => ['/rbac/default/index'],
                                'visible' => yii::$app->user->can('admin'), 
                            ],
                        ]
                    ],
                    [               
                        'label' => 'Component tools',
                        'items' => [
                            
                            [
                                'label' => yii::t('app', 'Attribute'),
                                'url' => ['/attributes/index']
                            ],
                            [
                                'label' => 'Elements_cases',
                                'url' => ['/ElementsCases/index']
                            ],
                            [
                                'label' => yii::t('app', 'Case'),
                                'url' => ['/cases/index']
                            ],
                        ]
                    ],
                    [
                        'label' => Yii::t('app', 'Language'),
                        'items' => [
                            [
                                'label' => Yii::t('app', 'Messages'),
                                'url' => ['/message/index']
                            ],
                            [
                                'label' => Yii::t('app', 'Source Message'),
                                'url' => ['/sourcemessage/index']
                            ],
                        ]
                    ],
                    [
                        'label' => 'Menu Yii2', 'options' => ['class' => 'header'],
                        'visible' => yii::$app->user->can('admin'), 
                        ],
                    ['label' => 'Category shortcut', 'icon' => 'fa fa-file-code-o', 'url' => ['/categoryshortcut'],],
                    ['label' => 'Project shortcut', 'icon' => 'fa fa-file-code-o', 'url' => ['/projectshortcut'],],
                    [
                        'label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],
                        'visible' => yii::$app->user->can('admin'), 
                        ],
                    [
                        'label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],
                        'visible' => yii::$app->user->can('admin'),
                        ],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Same tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                          
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'fa fa-circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'fa fa-circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
