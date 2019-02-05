<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "elements_cases".
 *
 * @property integer $idelement
 * @property integer $idcase
 */
class Elementscases extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'elements_cases';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idelement', 'idcase'], 'required'],
            [['idelement', 'idcase'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idelement' => Yii::t('app', 'Idelement'),
            'idcase' => Yii::t('app', 'Idcase'),
        ];
    }
    
    public function getElements(){
        return $this->hasOne(Elements::className(), ['idelements' => 'idelement']);
    }
    
    public function getCases(){
        return $this->hasOne(Cases::className(), ['idcase' => 'idcase']);
    }
}
