<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "specification_template".
 *
 * @property integer $idspt
 * @property integer $idelement
 * @property integer $quantity
 * @property string $ref_of_board
 */
class SpecificationTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'specification_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idelement', 'quantity'], 'required'],
            [['idelement', 'quantity'], 'integer'],
            [['ref_of_board'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idspt' => Yii::t('app', 'Idspt'),
            'idelement' => Yii::t('app', 'Idelement'),
            'quantity' => Yii::t('app', 'Quantity'),
            'ref_of_board' => Yii::t('app', 'Ref Of Board'),
        ];
    }
}
