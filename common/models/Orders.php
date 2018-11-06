<?php

namespace common\models;

use Yii;
use \yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "orders".
 *
 * @property integer $idorder
 * @property string $name
 * @property integer $req_quantity
 * @property integer $idproduce
 * @property integer $idsupplier
 * @property string $req_date
 * @property integer $executor
 * @property string $aggr_date
 * @property integer $qty
 * @property string $amount
 * @property string $suppl_date
 * @property string $date_payment
 * @property string $contract
 * @property string $date_onstock
 * @property string $date_recept
 * @property string $created_at
 * @property string $updated_at
 * @property integer $idtheme
 * @property integer $iduser
 * @property integer $idstatus
 * @property string $additional
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    public function behaviors() {
        return [
           'timestamp' => [
               'class' => TimestampBehavior::className(),
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
            [['idorder', 'name', 'req_quantity', 'req_date', 'idtheme', 'iduser', 'idstatus'], 'required'],
            [['idorder', 'req_quantity', 'idproduce', 'idsupplier', 'executor', 'qty', 'idtheme', 'iduser', 'idstatus'], 'integer'],
            [['req_date', 'aggr_date', 'suppl_date', 'date_payment', 'date_onstock', 'date_recept', 'created_at', 'updated_at'], 'safe'],
            [['amount'], 'number'],
            [['name', 'additional'], 'string', 'max' => 128],
            [['contract'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idorder' => 'Idorder',
            'name' => 'Наименование',
            'req_quantity' => 'Требуемое количество',
            'idproduce' => 'Производитель',
            'idsupplier' => 'Поставщик',
            'req_date' => 'Ожидаемая дата',
            'executor' => 'Исполнитель',
            'aggr_date' => 'Согласованная дата поставки',
            'qty' => 'Поставляемое кол-во',
            'amount' => 'Общая стоимость',
            'suppl_date' => 'Дата получения от поставщика',
            'date_payment' => 'Дата оплаты',
            'contract' => '№ договора',
            'date_onstock' => 'Дата получения на склад',
            'date_recept' => 'Дата получения',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирования',
            'idtheme' => 'Проект',
            'iduser' => 'Заказчик',
            'idstatus' => 'Idstatus',
            'additional' => 'Дополнительно',
        ];
    }
    
    public function getUsers() {
        return $this->hasOne(Users::className(), ['id' =>'iduser']);
    }
    
    public function getProduce() {
        return $this->hasOne(Produce::className(), ['idpr' =>'idproduce']);
    }
    
    public function getSupplier() {
        return $this->hasOne(Supplier::className(), ['idsupplier' =>'idsupplier']);
    }
    
    public function getThemes() {
        return $this->hasOne(Themes::className(), ['idtheme' =>'idtheme']);
    }
}
