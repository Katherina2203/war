<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "elements".
 *
 * @property integer $idelements
 * @property string $box
 * @property string $name
 * @property string $nominal
 * @property integer $quantity
 * @property integer $idproduce
 * @property integer $idcategory
 * @property string $image
 * @property string $date_added
 * @property string $active
 */
class Elements extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'elements';
    }

    public function behaviors() {
        return [
           'timestamp' => [
               'class' => \yii\behaviors\TimestampBehavior::className(),
               'value' => new \yii\db\Expression('NOW()'),
           ],
        ];
         
    }
    
    public function rules()
    {
        return [
            [['box', 'name', 'nominal', 'idproduce', 'idcategory'], 'required'],
            [['quantity', 'idproduce', 'idcategory'], 'integer'],
          //  [['date_added'], 'safe'],
            [['active'], 'string'],
            [['box'], 'string', 'max' => 20],
            [['name', 'nominal'], 'string', 'max' => 64],
            //[['image'], 'string', 'max' => 128],
            [['image'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idelements' => 'Idelements',
            'box' => 'Box',
            'name' => 'Name',
            'nominal' => 'Nominal',
            'quantity' => 'Quantity',
            'idproduce' => 'Idproduce',
            'idcategory' => 'Idcategory',
            'image' => 'Image',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'active' => 'Active',
        ];
    }
}
