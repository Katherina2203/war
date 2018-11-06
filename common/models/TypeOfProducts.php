<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "type_of_products".
 *
 * @property integer $idtype
 * @property string $name
 * @property integer $idcategory
 */
class TypeOfProducts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type_of_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'idcategory'], 'required'],
            [['idcategory'], 'integer'],
            [['name'], 'string', 'max' => 24],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idtype' => 'Idtype',
            'name' => 'Тип',
            'idcategory' => 'Idcategory',
        ];
    }
}
