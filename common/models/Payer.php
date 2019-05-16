<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payer".
 *
 * @property integer $idpayer
 * @property string $name
 */
class Payer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 24],
            [['contact'], 'string', 'max' => 128],
            [['address'], 'string'],
            [['phone', 'email'], 'string', 'max' => 48],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpayer' => Yii::t('app', 'Idpayer'),
            'name' => Yii::t('app', 'Name'),
            'contact' => Yii::t('app', 'Contact'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'), 
            'address' => Yii::t('app', 'Address'),
        ];
    }
}
