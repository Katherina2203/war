<?php
namespace backend\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use backend\models\ElementsSearch;

class SearchByElem extends ElementsSearch {
    
  //  public $idelements;
  //  public $name;
  //  public $nominal;
    
    public function search() {
        
        $this->load(Yii::$app->request->queryParams);
        
        if ($this->validate()) {

            return Yii::$app->response->redirect(Url::to([
                'boards/outof', 
                'idinvoice' => $this->idinvoice,
                'idrequest' => $this->idrequest,
            ]));
        }
        
    }
}
