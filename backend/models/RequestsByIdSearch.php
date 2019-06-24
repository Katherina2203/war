<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

use yii\helpers\Url;
use common\models\Requests;
use common\models\Paymentinvoice;

/**
 * Description of RequestsByIdSearch
 *
 * @author Yuliya
 */
class RequestsByIdSearch extends Model {
    
    public $idinvoice;
    
    public $idrequest;
    
    public function rules() {
        return [
            [['idrequest', 'idinvoice'], 'required'],
            ['idrequest', 'integer'],
            ['idrequest', 'trim'],
            ['idrequest', 'isExistReguestId'],
            ['idinvoice', 'isExistInvoiceId'],
        ];
    }


    public function isExistReguestId($attribute, $params)
    {
                          
        if (!$this->hasErrors()) {
            $modelRequests =  Requests::findOne($this->$attribute);
            if(is_null($modelRequests)) {
                $this->addError($attribute, 'This request does not exist.');
            }
        }

    }
    
    public function isExistInvoiceId($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $modelPaymentinvoice = Paymentinvoice::findOne($this->$attribute);
            if(is_null($modelPaymentinvoice)) {
                $this->addError($attribute, 'This invoice does not exist.');
            }
        }
    }
    
    public function search() {
        
        if(is_null(Yii::$app->request->get('RequestsByIdSearch'))) {
            return;
        }
        
        $this->load(Yii::$app->request->queryParams);

        if ($this->validate()) {

            return Yii::$app->response->redirect(Url::to([
                'accounts/addrequest', 
                'idinvoice' => $this->idinvoice,
                'idrequest' => $this->idrequest,
            ]));
        }
    }
}
