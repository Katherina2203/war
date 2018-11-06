<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Katherina</p>

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
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                  
                  [               
                        'label' => 'Заявки',
                        'items' => [
                            [
                              'label' => 'Журнал заявок',
                              'url' => ['/requests/index']
                            ],
                            [
                              'label' => 'Журнал заявок по исполнителям(выводить отделу снабжения)',
                              'url' => ['/processingrequest/byexecutor']
                            ],
                            [
                                // нужно еще Контролировать каждому члену отдела поставки свои заявки
                                //представление заявки и ответственный
                              'label' => 'Распределение текущих заявок',
                              'url' => ['/processingrequest/index']
                            ],
                            
                            [
                              'label' => 'Журнал заказов',
                              'url' => ['/purchaseorder/index']
                            ],
                             [
                              'label' => 'Оплачиваемые счета',
                              'url' => ['/paymentinvoice/index']
                            ],
                           
                            
                            
                            
                             [
                              'label' => 'Бизнес процесс заявок',
                              'url' => ['/requests/index']
                            ],
                            
                          
                        ]
                    ],
                    
                    ['label' => 'Orders', 'url' => ['orders/index']],
                    ['label' => 'Outofstock', 'url' => ['outofstock/index']],
                    ['label' => 'Category', 'url' => ['category/index']],
                    ['label' => 'Elements', 'url' => ['elements/index']],
                    ['label' => 'Matherials', 'url' => ['matherials/index']],
                    ['label' => 'Prices', 'url' => ['prices/index']],
                    
                    [
                        'label' => 'Catalogs',
                        'items' => [
                    
                            [
                                'label' => 'Manufactures',
                                'url' => ['/produce/index']
                            ],
                            [
                                'label' => 'Suppliers',
                                'url' => ['/supplier/index']
                            ],
                            [
                                'label' => 'Сотрудники',
                                'url' => ['/users/index']
                            ],
                    
                       ]
                    ],
                    
                    
                       ['label' => 'Users', 'options' => ['class' => 'header']],
                    [
                        'label' => 'User Preveleges/RBAC',
                        'items' => [
                    
                            [
                                'label' => 'Assignment',
                                'url' => ['/admin/rbac/assignment']
                            ],
                            [
                                'label' => 'Items',
                                'url' => ['/admin/rbac']
                            ],
                            [
                                'label' => 'Item_child',
                                'url' => ['/admin/rbac/']
                            ],
                            [
                                'label' => 'Rules',
                                'url' => ['/admin/rbac/rule']
                            ],
                    
                       ]
                    ],
                    
                    ['label' => 'Editional tools', 'options' => ['class' => 'header']],
                    
                    ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
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
