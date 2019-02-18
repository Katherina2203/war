<?php
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "processingrequest".
 *
 * @property integer $idprocessing
 * @property integer $idresponsive
 * @property string $date_processing
 * @property integer $idpayer
 */
class Processingrequest extends \yii\db\ActiveRecord
{
    public $purchaseorder_count;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'processingrequest';
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
            [['idresponsive',  'idpurchasegroup'], 'required'],
            [['idresponsive', 'idpurchasegroup', 'idrequest'], 'integer'],
           // [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idprocessing' => Yii::t('app', 'Idprocessing'),
            'idpurchasegroup' => Yii::t('app', 'Отдел снабжения'),
            'idresponsive' => Yii::t('app', 'Ответственный'),
            'idrequest' => Yii::t('app', 'Заявка'),
            'created_at' => Yii::t('app', 'Дата обработки'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
        ];
    }
    
    public function getUsers() {
        return $this->hasOne(Users::className(), ['id' =>'idresponsive']);
    }
    
     public function getUser() {
        return $this->hasOne(Users::className(), ['id' =>'idpurchasegroup']);
    }
    
    public function getRequests() {
        return $this->hasOne(Requests::className(), ['idrequest' =>'idrequest']);
    }
    
    public function getPurchaseorder() {
        return $this->hasMany(Purchaseorder::className(), ['idrequest' =>'idrequest']);
    }
    
    public function getSupplier() {
        return $this->hasMany(Supplier::className(), ['idsupplier' =>'idsupplier'])->viaTable('requests', ['idrequest' => 'idrequest']);
    }
    
    public function getElements() 
    {
        return $this->hasMany(Elements::className(), ['idelements' => 'idelement'])
                ->viaTable('purchaseorder', ['idrequest' => 'idrequest']);
    }
    
    public function getAccounts() 
    {
        return $this->hasMany(Accounts::className(), ['idelem' => 'idelement'])
                ->viaTable('purchaseorder', ['idrequest' => 'idrequest']);
    }
}
