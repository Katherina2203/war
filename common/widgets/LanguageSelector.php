<?php
namespace common\widgets;

use yii\base\Widget;
use yii;
use yii\helpers\Html;

class LanguageSelector extends Widget 
{
    public function run()
    {
        $route      = yii::$app->controller->route;
        $currentLang = \Yii::$app->language;
        $languages = \Yii::$app->params['languages'];
        $params     = $_GET;
        
        
       echo Html::a($currentLang. ' <b class="caret"></b>', '#', [
            'class'         => 'dropdown-toggle',
            'data-toggle'   => 'dropdown'
        ]);

        array_unshift($params, $route);

        echo '<ul id = "w1" class="dropdown-menu" role="menu" >';
        foreach($languages as $lang)
        {
            if($lang===$currentLang)
                continue;

            $params['language'] = $lang;

            echo '<li>'.Html::a($lang,$params ).'</li>';
        }
        echo '</ul>';
    }
    
}