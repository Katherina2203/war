<?php
namespace frontend\components;

use yii;

use yii\base\Widget;
use yii\helpers\Html;
 
class languageselector extends Widget
{
     public function run()
    {
        $route      = yii::$app->controller->route;
        $languages  = yii::$app->params['languages'];
        $language   = yii::$app->language; //current language
        $params     = $_GET;

        echo Html::a($language. ' <b class="caret"></b>', '#', [
            'class'         => 'dropdown-toggle',
            'data-toggle'   => 'dropdown'
        ]);

        array_unshift($params, $route);

        echo '<ul id = "w1" class="dropdown-menu" role="menu" >';
        foreach($languages as $lang)
        {
            if($lang===$language)
                continue;

            $params['language'] = $lang;

            echo '<li>'.Html::a($lang,$params ).'</li>';
        }
        echo '</ul>';
    }
}
