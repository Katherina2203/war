<?php
use yii\widgets\ListView;
?>
<?= Pjax::begin(['id' => 'project-list']);
ListView::widget([
                            'dataProvider' => $dataProviderTheme,
                            'options' => [
                                'tag' => 'ul',
                                'class' => 'project-list',
                             //   'id' => 'project-list-wrapper',
                            ],
                        //    'layout' => "{pager}\n{items}\n{summary}",
                            'itemView' => function ($modelTheme, $key, $index, $widget) {
                                return $this->render('_projectlist',['modelTheme' => $modelTheme, 'index' => $index
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
