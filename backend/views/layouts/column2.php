<?php 
use yii\bootstrap\Nav;
use app\components\HelloWidget;
use app\components\userMenuWidget;
use app\components\CategoryWidget;
use kartik\sidenav\SideNav;


$this->beginContent('@app/views/layouts/main.php'); ?>
        <div class="row">
   <div class="col-md-3">
    <div class="pg-sidebar">          
      <?= $this->blocks['sidebar']; ?>
        <?php
       echo SideNav::widget([
    'type' => SideNav::TYPE_DEFAULT,
    'heading' => 'Menu',
    'items' => [
        [
            'url' => '#',
            'label' => 'Search',
            'icon' => 'search'
        ],
        ['label' => 'Categories', 'url' => ['/category/index']],
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
        
        ['label' => 'Elements', 'url' => ['/elements/index']],
       
        ['label' => 'Purchase', 
                'items' => [
                    [
                        'label' => 'Orders',
                        'url' => ['/order/']
                    ],
                    [
                        'label' => 'Resent onstock / Отгрузки',
                        'url' => ['#']
                    ],
                    [
                        'label' => 'Accounts',
                        'url' => ['/accounts/']
                    ],
                    
                ]
                ],
    ],
]);
        ?>

        
    <?= HelloWidget::widget(); ?>   
    <?php //if(!Yii::$app->user->isGuest) $this->widget('UserMenu');?>
       
      <?= $this->blocks['toolbar']; ?>
    </div>      
  </div>
  <div class="col-md-9">
    <?= $content; ?>
  </div>
</div>
<?php $this->endContent();
