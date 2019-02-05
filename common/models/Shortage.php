<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shortage".
 *
 * @property integer $id
 * @property integer $idboard
 * @property string $ref_of
 * @property integer $idelement
 * @property integer $quantity
 * @property string $date
 */
class Shortage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shortage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idboard', 'ref_of', 'idelement', 'quantity', 'date'], 'required'],
            [['idboard', 'idelement', 'quantity'], 'integer'],
            [['date'], 'safe'],
            [['ref_of'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idboard' => 'Idboard',
            'ref_of' => 'Ref Of',
            'idelement' => 'Idelement',
            'quantity' => 'Quantity',
            'date' => 'Date',
        ];
    }
}
