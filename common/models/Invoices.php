<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoices".
 *
 * @property integer $idelements
 * @property string $name
 * @property string $nominal
 * @property integer $idproduce
 * @property integer $idcategory
 * @property integer $idord
 * @property string $quantity
 * @property string $account
 * @property string $account_date
 * @property string $delivery
 * @property string $unitPrice
 * @property string $forUP
 * @property string $pdv
 * @property string $usd
 */
class Invoices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idelements', 'idproduce', 'idcategory', 'idord'], 'integer'],
            [['name', 'nominal', 'idproduce', 'idcategory', 'quantity', 'delivery', 'unitPrice', 'forUP', 'pdv', 'usd'], 'required'],
            [['account_date'], 'safe'],
            [['name', 'nominal'], 'string', 'max' => 64],
            [['quantity', 'account'], 'string', 'max' => 48],
            [['delivery'], 'string', 'max' => 10],
            [['unitPrice'], 'string', 'max' => 12],
            [['forUP'], 'string', 'max' => 4],
            [['pdv'], 'string', 'max' => 3],
            [['usd'], 'string', 'max' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idelements' => 'Idelements',
            'name' => 'Name',
            'nominal' => 'Nominal',
            'idproduce' => 'Idproduce',
            'idcategory' => 'Idcategory',
            'idord' => 'Idord',
            'quantity' => 'Количество',
            'account' => 'Счет',
            'account_date' => 'Account Date',
            'delivery' => 'Delivery',
            'unitPrice' => 'Unit Price',
            'forUP' => 'For Up',
            'pdv' => 'Pdv',
            'usd' => 'Usd',
        ];
    }
    
    public function getCategory()
    {
         return $this->hasOne(Category::className(), ['idcategory' =>'idcategory']);
    }
    
    public function getProduce()
    {
         return $this->hasOne(Produce::className(), ['idpr' =>'idproduce']);
    }
}
