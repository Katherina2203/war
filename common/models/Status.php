<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property integer $idstatus
 * @property string $status
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['status'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idstatus' => Yii::t('app', 'Idstatus'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
    
     public function getIdstatus() {
        return $this->hasOne(Status::className(), ['idstatus' =>'idstatus']);
    }
}
