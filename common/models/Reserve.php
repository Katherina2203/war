<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reserve".
 *
 * @property integer $idreserve
 * @property integer $idelement
 * @property integer $idboard
 * @property integer $quantity
 */
class Reserve extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reserve';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idelement', 'idboard', 'quantity'], 'required'],
            [['idelement', 'idboard', 'quantity'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idreserve' => 'Idreserve',
            'idelement' => 'Idelement',
            'idboard' => 'Idboard',
            'quantity' => 'Quantity',
        ];
    }
}
