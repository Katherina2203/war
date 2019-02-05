<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "prices".
 *
 * @property integer $idpr
 * @property string $idel
 * @property string $idsup
 * @property string $unitPrice
 * @property string $forUP
 * @property string $pdv
 * @property string $usd
 * @property string $date
 */
class Prices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idel', 'idsup', 'unitPrice', 'forUP', 'pdv', 'usd', 'date', 'idcurrency'], 'required'],
            [['date'], 'safe'],
            [['idel', 'idsup', 'forUP'], 'string', 'max' => 4],
            [['unitPrice'], 'string', 'max' => 12],
            [['pdv'], 'string', 'max' => 3],
            [['usd'], 'string', 'max' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpr' => 'Idpr',
            'idel' => 'Idel',
            'idsup' => 'Idsup',
            'unitPrice' => 'Unit Price',
            'forUP' => 'For Up',
            'idcurrency' => 'Валюта',
            'pdv' => 'Pdv',
            'usd' => 'Usd',
            'date' => 'Date',
        ];
    }
}
