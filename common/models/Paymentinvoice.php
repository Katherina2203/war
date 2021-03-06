<?php

namespace common\models;

use Yii;
use \yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "paymentinvoice".
 *
 * @property integer $idpaymenti
 * @property string $invoice
 * @property integer $amount
 * @property integer $idpayer
 * @property string $date_payment
 * @property string $created_at
 * @property string $updated_at
 */
class Paymentinvoice extends \yii\db\ActiveRecord
{
    const CONFIRM_NOT = 0; //by head
    const CONFIRM_AGREE = 1; //yes
    const CONFIRM_CANCEL = 2; //canceled by head or usik
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paymentinvoice';
    }

      public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_by = \Yii::$app->user->identity->id;
          //  $this->CreatedOn = time();
        } else {
            $this->edited_by = \Yii::$app->user->identity->id;
            //$this->ModifiedOn = time();
        }
       if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->confirm = '0';
            }
            //elseif(Paymentinvoice::CONFIRM_CANCEL){
            //    $modelacc = new Accounts;
            //    $modelacc->status = Accounts::ACCOUNTS_CANCEL;
         //   }
            
            return true;
        } else {
            return false;
        }
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
    
    public function rules()
    {
        return [
            [['invoice'], 'required'],
            [['idpayer', 'idsupplier', 'created_by', 'edited_by'], 'integer'],
            [['date_payment', 'date_invoice', 'confirm', 'tracking_number'], 'safe'],
            ['confirm', 'default','value' => self::CONFIRM_NOT],
            [['invoice'], 'string', 'max' => 128],
            [['tracking_number'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpaymenti' => Yii::t('app', 'Idpaymenti'),
            'idsupplier' => Yii::t('app', 'Поставщик'),
            'invoice' => Yii::t('app', '№ Счета'),
            'amount' => Yii::t('app', 'Сумма с НДС'),
            'date_invoice' => Yii::t('app', 'Дата счета'),
            'idpayer' => Yii::t('app', 'Плательщик'),
            'date_payment' => Yii::t('app', 'Дата оплаты'),
            'confirm' => Yii::t('app', 'Подтверждено'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Кем создано'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'edited_by' => Yii::t('app', 'Кем отредактировано'),
            'price' => Yii::t('app', 'Цена'),
            'tracking_number' => Yii::t('app', 'Декларация'),
        ];
    }
    
    public function getPayer()
    {
        return $this->hasOne(Payer::className(), ['idpayer' => 'idpayer']);
    }
    
    public function getAccounts(){
        return $this->hasMany(Accounts::className(), ['idinvoice' => 'idpaymenti']);
                
    }   
    public function getInvoicelist(){
        
        $users = Users::find()
                ->select(['u.id', 'u.username'])
                ->join('JOIN', 'users u', 'users.id = u.id')
                ->distinct(TRUE)
                ->all();
        
        return \yii\helpers\ArrayHelper::map($users, 'id', 'username');
        //return $this->;
    }
    
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['idstatus' => 'status'])
                 ->viaTable('accounts', ['status' => 'idstatus']);
    }
    
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['idsupplier' => 'idsupplier']);
    }
    
    public function getInvoicedate()
    {
     //   return $this->invoice. ' от ' . $this->date_invoice;
        $inv = Paymentinvoice::find()
                ->select(['idpaymenti', 'invoice', 'date_invoice'])
            //    ->join('JOIN', 'paymentinvoice p', 'paymentinvoice.idpayimenti = p.idpayimenti')
              //  ->where(['t.status'=> 'close'])
               // ->distinct(TRUE)
                ->all();
        
        return \yii\helpers\ArrayHelper::map($inv, 'idpaymenti', 'invoice');
    }
    
    public function getInvoiceitem()
    {
        return '№' . $this->invoice. ' от '. $this->date_invoice;
    }
    
    public static function getStatuses()
    {
        return [
            self::CONFIRM_NOT => 'Не просмотрен',
            self::CONFIRM_AGREE => 'Подтвержден',
            self::CONFIRM_CANCEL => 'Отмена'
        ];
    }
}
