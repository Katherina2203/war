<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "matherials".
 *
 * @property integer $idmatherial
 * @property string $storeplace
 * @property string $name
 * @property string $description
 * @property string $date_create
 */
class Matherials extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'matherials';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['storeplace', 'name', 'description', 'date_create'], 'required'],
            [['date_create'], 'safe'],
            [['storeplace'], 'string', 'max' => 24],
            [['name'], 'string', 'max' => 64],
            [['description'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idmatherial' => 'Idmatherial',
            'storeplace' => 'Storeplace',
            'name' => 'Name',
            'description' => 'Description',
            'date_create' => 'Date Create',
        ];
    }
}
