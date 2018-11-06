<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "element_filter".
 *
 * @property integer $idfilter
 * @property string $name
 */
class ElementFilter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'element_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idfilter' => Yii::t('app', 'Idfilter'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
