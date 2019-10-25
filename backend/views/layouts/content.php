<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper" style="display: table; clear: both; overflow: visible; width: auto; min-width: 100%; margin-left: 0px; padding-left: 230px;">
  <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                if ($this->title !== null) {
                    echo \yii\helpers\Html::encode($this->title);
                } else {
                    echo \yii\helpers\Inflector::camel2words(
                        \yii\helpers\Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                } ?>
            </h1>
        <?php } ?>
         
        <div class="breadcrumb">
            <?= Breadcrumbs::widget(
                ['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]
            ) ?>
        </div>
    </section>

    <section class="content" style="overflow: visible;">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="footer" style="display: table; clear: both; min-width: 100%; width: 100%;">
    <div class="container">
        <p class="pull-right">&copy; <?= yii::t('app', 'Microwave Electronics department') ;?>  <?= date('Y') ?></p>
    </div>
</footer>

