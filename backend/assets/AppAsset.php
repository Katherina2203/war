<?php

namespace backend\assets;

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
        'dist/css/AdminLTE.min.css',
        'css/site.css',
       // ['css/print.css', 'media' => 'print'],
    ];
    public $js = [
        'dist/js/adminlte.min.js',
        'dist/js/myjs.js',
        'js/vue.js',
        'dist/js/vuejsscript.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset' // bootstrap.js
    ];
    
    public $jsOptions = [
        'position' =>  View::POS_HEAD,
    ];
      
   
}
