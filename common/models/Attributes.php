<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "attributes".
 *
 * @property integer $idattribute
 * @property string $name
 */
class Attributes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attributes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idattribute' => Yii::t('app', 'Idattribute'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
