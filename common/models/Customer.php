<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['first_name'], 'string', 'max' => 32],
            [['last_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'first_name' => Yii::t('app', 'first_name'),
            'last_name' => Yii::t('app', 'last_name'),
          //  'id' => Yii::t('app', 'ID'),
          //  'first_name' => Yii::t('app', 'First Name'),
           // 'last_name' => Yii::t('app', 'Last Name'),
        ];
    }
    
   
}
