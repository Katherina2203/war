<?php
use yii\widgets\ListView;
?>
<?= Pjax::begin(['id' => 'project-list']);
ListView::widget([
                            'dataProvider' => $dataProviderBoard,
                            'options' => [
                                'tag' => 'ul',
                                'class' => 'project-list',
                             //   'id' => 'project-list-wrapper',
                            ],
                        //    'layout' => "{pager}\n{items}\n{summary}",
                            'itemView' => function ($modelBoard, $key, $index, $widget) {
                                return $this->render('_myboards',['modelBoard' => $modelBoard, 'index' => $index
                                    ]);
                                // return $model->title . ' posted by ' . $model->author;
                            },
                            'itemOptions' => ['tag'=>'li', 'class'=>'item'],
                            'pager' => [
                                    'pagination' => $pages,
                                ],        
                            'emptyText' => '<p>Список пуст</p>',
                            'summary' => '',//Показано {count} из {totalCount}
                        ])//;
                    ?>
<?php Pjax::end(); ?>  
