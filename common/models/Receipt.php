<?php

namespace common\models;
use \yii\behaviors\TimestampBehavior;
use Yii;

use common\models\Accounts;
/**
 * This is the model class for table "receipt".
 *
 * @property integer $idreceipt
 * @property integer $id
 * @property integer $quantity
 * @property integer $idinvoice
 * @property string $date_receive
 */
class Receipt extends \yii\db\ActiveRecord
{
    /* public function afterSave($insert, $changedAttributes){
         parent::afterSave($insert, $changedAttributes);
        
        $statusacc = new Accounts();
        
        if ($this->credit->amount <= 0) {
            $this->credit->status = Requests::REQUEST_DONE;
        }
        if ($this->quantity == $statusacc->quantity) {
        $statusacc->status = Accounts::ACCOUNTS_ONSTOCK;//'3';
        $this->updateAttributes(['status']); 
        }else{
            
        }
       
    }
    public function beforeSave($insert){
        Accounts::updateAccount($this->status);
        return parent::beforeSave($insert);
    }*/
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'receipt';
    }
    
    public $request;

    public function behaviors() {
        return [
           'timestamp' => [
               'class' => TimestampBehavior::className(),
               'createdAtAttribute' => 'date_receive',
               'updatedAtAttribute' => 'date_receive',
               'value' => new \yii\db\Expression('NOW()'),
           ],
        ];
         
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'quantity', 'date_receive'], 'required'],
            [['id', 'quantity', 'idinvoice'], 'integer'],
            [['date_receive'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idreceipt' => Yii::t('app', 'Idreceipt'),
            'id' => Yii::t('app', '# товара'),
            'quantity' => Yii::t('app', 'Количество'),
            'idinvoice' => Yii::t('app', '# Счета'),
            'date_receive' => Yii::t('app', 'Дата получения'),
        ];
    }
    
    public function getAccounts() {
        return $this->hasOne(Accounts::className(), ['idord' =>'idinvoice']);
    }
    
    public function getPaymentinvoice(){
        return $this->hasOne(Paymentinvoice::className(), ['idpaymenti' => 'idinvoice'])
                    ->viaTable('accounts', ['idord' => 'idinvoice']);
    }
    
    public function getRequests(){
        return $this->hasOne(Requests::className(), ['idrequest' => 'idrequest'])
                    ->viaTable('purchaseorder', ['idelement' => 'id']);
    }
    
    public function getElements() {
        return $this->hasOne(Elements::className(), ['idelements' =>'id']);
    }
    
    public function getIdproduce() {
        return $this->hasOne(Produce::className(), ['idpr' =>'idproduce']);
    }
    
   
    
}
