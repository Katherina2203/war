<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "accounts".
 *
 * @property integer $idord
 * @property integer $idelem
 * @property integer $idprice
 * @property string $quantity
 * @property string $account_date
 * @property string $account
 * @property string $delivery
 * @property integer $status
 * @property string $date_receive
 */
class Accounts extends \yii\db\ActiveRecord
{
    const ACCOUNTS_ORDERED = 2;  //ordered
    const ACCOUNTS_ONSTOCK = 3;  //receive onstock
    const ACCOUNTS_CANCEL = 4;  //cancel
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%accounts}}';
    }

    public function behaviors() {
        return [
            'timestamp' => [
               'class' => TimestampBehavior::className(),
               'value' => new \yii\db\Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'edited_by',
            ],
        ];
         
    }
    
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_by = \yii::$app->user->identity->id;
          //  $this->CreatedOn = time();
        } else {
            $this->edited_by = \yii::$app->user->identity->id;
            //$this->ModifiedOn = time();
        }
    
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->status = self::ACCOUNTS_ORDERED;
            }
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idelem', 'idprice', 'quantity', 'delivery', 'date_receive', 'amount'], 'required'],
            [['idelem', 'idprice', 'idinvoice', 'created_by' , 'edited_by'], 'integer'],
            [['date_receive'], 'safe'],
            ['status', 'default', 'value' => self::ACCOUNTS_ORDERED],
            [['quantity','status'], 'string', 'max' => 48],
            [['delivery'], 'string', 'max' => 10],
           // [['amount'], 'number', 'min'=>0,],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idord' => Yii::t('app', 'Idord'),
           // 'idelem' => 'Номенклатура',
             'idelem' => Yii::t('app', 'Номенклатура'),
            'idprice' => Yii::t('app', 'Цена'),
            'quantity' => Yii::t('app', 'Количество'),
            'idinvoice' => Yii::t('app', '№ Счета'),
          //  'account' => 'Счет',
        //    'account_date' => 'Дата счета',
            'delivery' => Yii::t('app', 'Доставка'),
            'status' => Yii::t('app', 'Статус'),
            'amount' => Yii::t('app', 'Сумма'),
         //   'idpayer' => 'Плательщик',
            'date_receive' => Yii::t('app', 'Дата получения'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'created_by' =>  Yii::t('app', 'Кем создано'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
            'edited_by' => Yii::t('app', 'Кем редактировано'),
        ];
    }
    
    public function getElements() {
        return $this->hasOne(Elements::className(), ['idelements' =>'idelem']);
    }
    
  /*  public function getStatus() {
        return $this->hasOne(Status::className(), ['idstatus' =>'status']);
    }*/
    
    public function getPaymentinvoice(){
        return $this->hasOne(Paymentinvoice::className(), ['idpaymenti' => 'idinvoice']);
              //    ->viaTable('paymentinvoice_accounts', ['idpaymentinvoice' => 'idpaymenti']);
    }
    
    public function getProduce(){
        return $this->hasOne(Produce::className(), ['idpr' => 'idproduce'])
                    ->viaTable('elements', ['idelements' => 'idelem']);
    }
    
    public function getPrices() {
        return $this->hasOne(Prices::className(), ['idpr' =>'idprice']);
    }
        
    public function getPurchaseorder(){
        return $this->hasOne(Purchaseorder::className(), ['idelement' =>'idelem']);
    }
    
    public function getRequests(){
        return $this->hasMany(Requests::className(), ['idrequest' => 'idrequest'])
                    ->viaTable('purchaseorder', ['idelement' => 'idelem']);
    }
   
    public function getSupplier(){
        return $this->hasMany(Supplier::className(), ['idsupplier' => 'idsupplier'])
                    ->viaTable('paymentinvoice', ['idpaymenti' => 'idinvoice']);
    }
  
    public static function getStatuses()
    {
        return [
            self::ACCOUNTS_ORDERED => 'В заказе',
            self::ACCOUNTS_ONSTOCK => 'На складе',
            self::ACCOUNTS_CANCEL => 'Отмена'
        ];
    }
    
    
}