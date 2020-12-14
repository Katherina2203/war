 <div class="box box-solid">
                <div class="box-body bg-gray-light language">
                    <div class="box-header with-border"><i class="glyphicon glyphicon-tree-deciduous"></i><h3 class="box-title">Языки</h3></div>
                    <div id="current-lang">
                        <span class="box-title"><?= Yii::t('app', 'Current language:') . Yii::$app->language;?></span>
                        <!--    <div  id="language-selector" class="pull-left" style="position: relative; top: 60px;">
                                <?= common\widgets\LanguageSelector::widget(); ?>
                            </div>-->
                    </div>
                    <div class="small-box-footer">
                        <select>
                            <option>English</option>
                            <option>Русский</option>
                        </select>
                    </div>
                 
                </div>
            </div>





 <div class="box">
                <div class="box-header with-border"><i class="glyphicon glyphicon-signal"></i><h3 class="box-title">Статистика заявок</h3></div>
                <div class="box-body">
                    <div class="col-sm-3">
                        <center><h3><?= Html::a('1', ['requests/index']) ?></h3>
                            <?= Html::a('Новые', ['requests/index']) ?>
                        </center>
                    </div>
                    <div class="col-sm-3">
                        <center><div class="box-request"><h3>2</h3></div>
                           <?= Html::a('Мои  заявки', ['requests/myrequests', 'iduser'=> yii::$app->user->identity->id]) ?>
                        </center>
                    </div>
                    <div class="col-sm-3">
                        <center><h3>0</h3>
                            <?= Html::a('Заблокировано', ['requests/myrequests', 'iduser'=> yii::$app->user->identity->id]) ?>
                        </center>
                    </div>
                </div>
            </div>