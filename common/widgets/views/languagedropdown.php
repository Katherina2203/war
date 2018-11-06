 <?= Html::beginForm() ?>
                        <?= Html::dropDownList('language', Yii::$app->language, ['en-US' => 'English', 'ru-RU' => 'Russian']) ?>
                        <?= Html::submitButton('Change') ?>
                        <?= Html::endForm() ?>