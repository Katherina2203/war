<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "values".
 *
 * @property integer $idelement
 * @property integer $idattribute
 * @property string $significance
 */
class Values extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idelement', 'idattribute', 'significance'], 'required'],
            [['idelement', 'idattribute'], 'integer'],
            [['significance'], 'string', 'max' => 128],
            [['idelement'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idelement' => Yii::t('app', 'Idelement'),
            'idattribute' => Yii::t('app', 'Idattribute'),
            'significance' => Yii::t('app', 'Significance'),
        ];
    }
}
