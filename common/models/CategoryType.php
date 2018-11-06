<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category_type".
 *
 * @property integer $idcategory_type
 * @property integer $idtype_of_products
 * @property integer $idcategory
 */
class CategoryType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtype_of_products', 'idcategory'], 'required'],
            [['idtype_of_products', 'idcategory'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcategory_type' => 'Idcategory Type',
            'idtype_of_products' => 'Idtype Of Products',
            'idcategory' => 'Idcategory',
        ];
    }
}
