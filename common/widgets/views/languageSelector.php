<?php 
    use yii\helpers\Html;
?>

<?php echo Html::beginForm(); ?>
    <div id="language-select">
        <?php 
       
		echo Html::a($currentLang. ' <b class="caret"></b>', '#', [
            'class'         => 'dropdown-toggle',
            'data-toggle'   => 'dropdown'
        ]);
                
     
          
                 echo '<ul id = "w1" class="dropdown-menu" role="menu" >';
        foreach($languages as $lang)
        {
            if($lang===$currentLang)
                continue;

            $params['language'] = $lang;

            echo '<li>'.Html::a($lang,$params ).'</li>';
        }
        echo '</ul>';
          echo '</ul>';
        ?>
        <script type="text/javascript">
        function language_change(selected)
        {
            <?php echo '$.ajax(\''.Yii::$app->getUrlManager()->createUrl("site/language")."',".PHP_EOL; 
                    echo "{'type':'post',".PHP_EOL;
                    echo "success: function(data) {window.location.reload();},".PHP_EOL;
                    echo "'data':'_lang='+selected.value+'&YII_CSRF_TOKEN=" . Yii::$app->request->csrfToken."',";
            ?>
            }
            );
        }
        </script>
    </div>
<?php echo Html::endForm(); 
