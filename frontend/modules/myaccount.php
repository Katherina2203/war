<?php
namespace app\modules;

/**
 * myaccount module definition class
 */
class myaccount extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\controllers';

    public $layout = '/myaccount';
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
