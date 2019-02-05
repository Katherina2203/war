<?php
use yii\bootstrap\Tabs;

$this->title = 'Project shortcut';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Tabs::widget([
    'items' => [
        [
            'label' => 'Клиентская часть',
            'content' =>  $this->render('clientpart'),
            'active' => true // указывает на активность вкладки
            
        ],
        [
            'label' => 'Админская часть',
            'content' =>  $this->render('adminpart'),
          
        ],
        
    ]
]);
?>



