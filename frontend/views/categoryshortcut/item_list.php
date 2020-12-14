    <?php 
     $dataProvider = new ActiveDataProvider([
                           'query'=> Categoryshortcut::find()->orderBy('id DESC')
                        ]);
    Pjax::begin(['id' => 'item_list']); ?>

<?=  ListView::widget([
    'dataProvider' => $dataProvider,
    'itemOptions' => ['class' => 'item'],
    'itemView' => '_index',
]);?>