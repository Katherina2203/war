<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "requestitem".
 *
 * @property integer $idrequest
 * @property integer $idproject
 * @property integer $iduser
 * @property string $name
 * @property string $description
 * @property integer $quantity
 * @property integer $idmeasure
 * @property integer $idmanufacture
 * @property integer $idsupplier
 * @property string $deliverytime
 */
class Requestitem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'requestitem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idproject', 'iduser', 'name', 'description', 'quantity', 'idmeasure', 'deliverytime'], 'required'],
            [['idproject', 'iduser', 'quantity', 'idmeasure', 'idmanufacture', 'idsupplier'], 'integer'],
            [['name', 'description'], 'string', 'max' => 128],
            [['deliverytime'], 'string', 'max' => 24],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idrequest' => Yii::t('app', 'Idrequest'),
            'idproject' => Yii::t('app', 'Idproject'),
            'iduser' => Yii::t('app', 'Iduser'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'quantity' => Yii::t('app', 'Quantity'),
            'idmeasure' => Yii::t('app', 'Idmeasure'),
            'idmanufacture' => Yii::t('app', 'Idmanufacture'),
            'idsupplier' => Yii::t('app', 'Idsupplier'),
            'deliverytime' => Yii::t('app', 'Deliverytime'),
        ];
    }
}
