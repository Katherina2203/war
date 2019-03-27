<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "specification".
 *
 * @property integer $idspec
 * @property integer $quantity
 * @property integer $idelement
 * @property integer $idboard
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Specification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'specification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quantity', 'idelement', 'idboard', 'created_by', 'updated_by'], 'required'],
            [['quantity', 'idelement', 'idboard', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idspec' => Yii::t('app', 'Idspec'),
            'quantity' => Yii::t('app', 'Quantity'),
            'idelement' => Yii::t('app', 'Idelement'),
            'idboard' => Yii::t('app', 'Idboard'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
