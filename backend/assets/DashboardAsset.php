<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
     //   'dist/css/skins/_all-skins.min.css',
    ];
    public $js = [
        'dist/js/myjs.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset', // bootstrap.js
   //     'dmstr\web\AdminLteAsset',
      //  'kartik\grid\GridViewAsset',
    ];
}
