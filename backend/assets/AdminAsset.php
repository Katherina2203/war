<?php
namespace backend\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';
    public $js = [
        'datatables/dataTables.bootstrap.min.js',
      
        // more plugin Js here
    //     'js/app.min.js'
    ];
    public $css = [
        'datatables/dataTables.bootstrap.css',
        // more plugin CSS here
    ];
    public $depends = [
       'dmstr\web\AdminLteAsset',
   /*     'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',*/
    ];
    
   //  public $skin = '_all-skins';
    
 /*   public function init()
    {
        // Append skin color file if specified
        if ($this->skin) {
            if (('_all-skins' !== $this->skin) && (strpos($this->skin, 'skin-') !== 0)) {
                throw new Exception('Invalid skin specified');
            }

            $this->css[] = sprintf('css/skins/%s.min.css', $this->skin);
        }

        parent::init();
    }
  * */

}