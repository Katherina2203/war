<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper" style="display: table; clear: both; overflow: visible; width: auto; min-width: 100%; margin-left: 0px; padding-left: 230px;">
    <section class="content-header">
            <h1>
            <small><?= $this->title ?></small>
            </h1>
            <ol class="breadcrumb" style="float: left; margin-right: 200px;">
                <?= Breadcrumbs::widget(
                [
                     'itemTemplate' => "<li><i>{link}</i></li>\n",
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);
            ?> 
            </ol>
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

