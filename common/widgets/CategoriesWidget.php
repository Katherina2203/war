<?php
namespace common\widgets;
use \yii\bootstrap\Widget;

class CategoriesWidget extends Widget{
    
    public function init(){
       parent::init();
    } 
   
    public function run() {
       
      $models = \common\models\Category::find()->where(['parent'=> 0])->All();
       return $this->render('categories', array(
           'models' => $models,
       ))  ;
    }
   
   
                  
}
            
                

