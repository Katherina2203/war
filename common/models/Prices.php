<?php

namespace common\models;
use \yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "prices".
 *
 * @property integer $idpr
 * @property string $idel
 * @property string $idsup
 * @property string $unitPrice
 * @property string $forUP
 * @property string $pdv
 * @property string $usd
 * @property string $date
 */
class Prices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prices';
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
            [['idel', 'idsup', 'unitPrice', 'forUP', 'pdv', 'usd', 'idcurrency'], 'required'],
          //  [['date'], 'safe'],
            [['idel', 'idsup', 'idcurrency'], 'integer'],
            [['forUP'], 'string', 'max' => 4],
            [['unitPrice'], 'string', 'max' => 12],
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
            'idpr' => Yii::t('app', 'Idpr'),
            'idel' => Yii::t('app', '# Элемента'),
            'idsup' => Yii::t('app', 'Поставщик'),
            'unitPrice' => Yii::t('app', 'Цена'),
            'forUP' => Yii::t('app', 'за шт'),
            'idcurrency' => Yii::t('app', 'Валюта'),
            'pdv' => Yii::t('app', 'ПДВ'),
            'usd' => Yii::t('app', 'Дол'),
            'created_at' => Yii::t('app', 'Создано'),
        ];
    }
    
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['idsupplier' => 'idsup']);
    }
    
    public function getElements()
    {
        return $this->hasOne(Elements::className(), ['idelements' => 'idel']);
    }
    
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['idcurrency' => 'idcurrency']);
    }
    
    public function getPrice()
    {
        return $this->unitPrice. '/'. $this->forUP;
    }
    
     public static function getPriceList($idel) 
    {
        $data = Prices::find()
                ->select(['idpr as id', 'unitPrice as unit'])
                ->where(['idel' => $idel])
                ->asArray()
                ->all();
        
        $value = (count($data) == 0) ? ['' => ''] : $data;
        return $value;
    }
    
  
}
