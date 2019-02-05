<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categoryelements".
 *
 * @property integer $idcategory
 * @property integer $idelement
 */
class Categoryproduce extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categoryproduce';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idcategory', 'idproduce'], 'required'],
            [['idcategory', 'idproduce'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcategory' => Yii::t('app', 'Idcategory'),
            'idproduce' => Yii::t('app', 'Idproduce'),
        ];
    }
    
    public function getProduce()
    {
        return $this->hasOne(Produce::className(), ['idpr' => 'idproduce']);
    }
    
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['idcategory' => 'idcategory']);
    }
}
