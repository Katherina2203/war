<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'dist/css/AdminLTE.min.css',
        'css/site.css',
    ];
    
    public $js = [
        'dist/js/adminlte.min.js',
        'dist/js/main.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset' // bootstrap.js
    ];
    
    public $jsOptions = [
        'position' =>  View::POS_HEAD,
    ];
      
}
