<?php use yii\helpers\Url;?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Url::to('@web'.Yii::$app->user->identity->photo) ?>" class="img-circle" alt="<?= Yii::$app->user->identity->surname?>"/>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->identity->username; ?></p>

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
                    
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                 
                    [               
                        'label' => 'Заявки',
                        'items' => [
                            [
                              'label' => 'Мои заявки',
                              'url' => ['/myaccount/requests/myrequests']
                            ],
                            
                            [
                              'label' => 'Все заявки',
                              'url' => ['/myaccount/requests/index']
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
                              'url' => ['/myaccount/themes/index']
                            ],
                      /*      [
                              'label' => 'Подмодули проектов',
                             'url' => ['/myaccount/themeunits/index']
                            ],*/
                            [
                               'label' => 'Список Текущих плат',
                             'url' => ['/myaccount/boards/index']
                            ],
                    /*       [
                               'label' => 'Список Всех плат',
                             'url' => ['/myaccount/boards/index']
                            ],*/
                    
                        ]
                     ],
                  
                
                   [
                              'label' => 'Мой профиль',
                              'items' => [
                                  [
                                    'label' => 'Мои данные',
                                    'url' => ['/myaccount/users/myprofile']
                                  ],
                                  
                                 
                                ]
                              
                    ],
                  
                 
                  //  ['label' => 'Взять со склада', 'url' => ['/myaccount/outofstock/userout']],  
                    ['label' => 'Производители', 'url' => ['/myaccount/produce/index']], 
                    ['label' => 'Поставщики', 'url' => ['/myaccount/supplier/index']], 
                        
                    
        
           
                ],
            ]
        ) ?>

    </section>

</aside>
