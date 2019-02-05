<?php

namespace admin\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $sourcePath = '@vendor/bower/backend';
    public $css = [
   //    'dist/css/skins/_all-skins.min.css',
    //   'css/site.css',
       'dist/css/AdminLTE.css',
       'dist/css/AdminLTE.min.css',
    ];
    public $js = [
        'dist/js/pages/dashboard.js',
        'dist/js/pages/dashboard2.js',
        'dist/js/app.js',
        'dist/js/app.min.js',
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
       // 'yii\bootstrap\BootstrapAsset',
      //  'yii\bootstrap\BootstrapPluginAsset' // bootstrap.js
    ];
    
    public $jsOptions = [
        'position' =>  View::POS_HEAD,
    ];
      
   
}
