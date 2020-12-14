  <h3> Заказать</h3> <h4><?= Html::encode($this->title) ?></h4>
          <span style="color: green">
          <?= Html::encode($modelrequests->name) ?>
          <?= Html::encode($modelrequests->quantity) ?>
          </span>
          
           <?php $form = ActiveForm::begin([
                 'action' => ['elements/createquick'],
            
           ]); ?>
            <?= $form->field($modelrequests, 'quantity', [
        'template' => '{label}{input}{hint}{error}'
    ])->textInput() ?>
            <?= $form->field($modelrequests, 'idproject')->dropDownList(ArrayHelper::map(common\models\Themes::find()
                ->select(['name', 'idtheme'])
                ->where(['status' => 'active']) 
            //    ->with('themeunits')
                ->all(),
                'idtheme', 
                'name'),['prompt'=>'Выберете проект']); ?>

             <?= $form->field($modelrequests, 'required_date')->widget(
                    DatePicker::className(), [
                     'clientOptions' => [
                     'autoclose' => true,
                     'format' => 'yyyy-mm-dd'
                    ]
                  ]); ?>
            <div class="form-group">
             <?= Html::submitButton('Создать заявку', ['type' => 'submit', 'class' => 'btn btn-primary']) ?>
            </div>
          <?php ActiveForm::end(); ?>
           <?php
                //beforeSubmit
            $js = "
                  $('.formrequest').on('beforeSubmit', function(e){
                    var \$form = $(this);
                    submitMySecondForm(\$form);
                    }).on('submit', function(e){
                  e.preventDefault();
                    });";
            $this->registerJs($js);
    ?>