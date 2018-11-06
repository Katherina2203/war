<?php
namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class MainAsset extends AssetBundle
{
   // public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $sourcePath = '@vendor/bower/backend';
    public $css = [
        'dist/css/AdminLTE.css',
        'dist/css/AdminLTE.min.css',
    ];
    public $js = [
      //  'dist/js/pages/dashboard.js',
      //  'dist/js/pages/dashboard2.js',
        'dist/js/app.min.js',
       
    ];
    public $depends = [
      //  'dmstr\web\AdminLteAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset' // bootstrap.js
    ];
   
    public $jsOptions = [
        'position' =>  View::POS_HEAD,
    ];

}
