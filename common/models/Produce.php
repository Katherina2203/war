<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "produce".
 *
 * @property integer $idpr
 * @property string $manufacture
 */
class Produce extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%produce}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manufacture'], 'required'],
            [['manufacture'], 'string', 'max' => 64],
            [['country'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 255],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpr' => Yii::t('app', 'Idpr'),
            'manufacture' =>  Yii::t('app', 'Производитель'),
            'country' =>  Yii::t('app', 'Страна'),
            'description' =>  Yii::t('app', 'Описание'),
        ];
    }
    
    public function getCategory(){
         return $this->hasMany(Category::className(), ['idcategory' => 'idcategory'])
            ->viaTable('categoryproduce', ['idproduce' => 'idpr']);
    }
    
    public function getProduceList(){
        $produces = Produce::find()
                ->select(['p.idpr', 'p.manufacture'])
                ->join('JOIN', 'produce p', 'produce.idpr = p.idpr')
              //  ->where(['t.status'=> 'close'])
               // ->distinct(TRUE)
                ->all();
        
        return \yii\helpers\ArrayHelper::map($produces, 'idpr', 'manufacture');
    }
}
