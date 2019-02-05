<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "type_request".
 *
 * @property integer $idtype
 * @property string $name
 */
class TypeRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 28],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idtype' => Yii::t('app', 'Idtype'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
