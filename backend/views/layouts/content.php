<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper">
    <section class="content-header">
            <h1>
            <small><?= $this->title ?></small>
            </h1>
            <ol class="breadcrumb">
                <?= Breadcrumbs::widget(
                [
                     'itemTemplate' => "<li><i>{link}</i></li>\n",
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);
            ?> 
            </ol>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-right">&copy; Microwave Electronics department <?= date('Y') ?></p>
    </div>
</footer>

