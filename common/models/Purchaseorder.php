<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "purchaseorder".
 *
 * @property integer $idpo
 * @property integer $idaccount
 * @property integer $idelement
 * @property string $quantity
 * @property string $date
 */
class Purchaseorder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchaseorder';
    }

    public function behaviors() {
        return [
           'timestamp' => [
               'class' => TimestampBehavior::className(),
               'value' => new \yii\db\Expression('NOW()'),
           ],
        ];
         
    }
    
    public function rules()
    {
        return [
            [['idrequest', 'idelement', 'quantity'], 'required'],
            [['idrequest', 'idelement'], 'integer'],
            [['quantity', 'date'], 'string', 'max' => 24],
          //  [['delivery'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpo' => Yii::t('app', 'Idpo'),
            'idrequest' => Yii::t('app', '№ заявки'),
            'idelement' => Yii::t('app', 'Idelement'),
            'quantity' => Yii::t('app', 'Соглас-е кол-во'),
            'date' => Yii::t('app', 'Соглас-я дата'),
           // 'idinvoice' => 'Счет',
          //  'delivery' => 'Согласованная поставка'
        ];
    }
    
    public function getElements() {
        return $this->hasOne(Elements::className(), ['idelements' =>'idelement']);
    }
    
    public function getAccounts() {
        return $this->hasMany(Accounts::className(), ['idelem' =>'idelement']);
    }
    
      public function getProcessingrequest() {
        return $this->hasOne(Processingrequest::className(), ['idrequest' =>'idrequest']);
    }
    
    public function getIdprice() {
        return $this->hasOne(Accounts::className(), ['idord' =>'idinvoice']);
    }
    
    public function getRequests(){
        return $this->hasOne(Requests::className(), ['idrequest' => 'idrequest']);
      //  ->viaTable('requests_orders', ['idrequest' => 'ididrequest']);
    }
    
    public function getAccountDate(){
        $accounts = $this->accounts;
       return  '№'. $accounts->account .' от '. $accounts->account_date;
    }
    
    public static function getOrderitem($data = []){
        $request = new Requests();
        $order = Purchaseorder::find()
                ->with(['elements'])
                ->joinWith(['processingrequest'], false)
                ->where(['idrequest' => 'processingrequest'])
             //   ->where(['idrequest' => $request->status = '0'])
                ->all();
        foreach ($order as $key => $value)
        {
           $data[$value->idpo] = $value->idelement. ' '. $value->elements->fulname;
           unset($order[$key]);
        //  $this->getOrderitem($data, $value->idpo);
        }
        return $data;   
    }
    
}
