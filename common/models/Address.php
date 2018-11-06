<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $full_name
 * @property string $address_line1
 * @property string $address_line2
 * @property string $city
 * @property string $state
 * @property string $postal_code
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'full_name', 'address_line1', 'address_line2', 'city', 'state', 'postal_code'], 'required'],
            [['customer_id'], 'integer'],
            [['full_name', 'address_line1', 'address_line2'], 'string', 'max' => 128],
            [['city', 'state'], 'string', 'max' => 32],
            [['postal_code'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
             'id' => 'Id',
             'customer_id' => 'Customer ID',
             'full_name' => 'full_name',
            'address_line1' => 'address_line1',
             'address_line2' =>  'address_line2',
             'city' =>  'city',
            'state' => 'state',
            'postal_code' => 'postal_code',
          //  'id' => Yii::t('app', 'ID'),
         //   'customer_id' => Yii::t('app', 'Customer ID'),
            //'full_name' => Yii::t('app', 'Full Name'),
          //  'address_line1' => Yii::t('app', 'Address Line1'),
          //  'address_line2' => Yii::t('app', 'Address Line2'),
         //   'city' => Yii::t('app', 'City'),
          //  'state' => Yii::t('app', 'State'),
            //'postal_code' => Yii::t('app', 'Postal Code'),
        ];
    }

    /**
     * @inheritdoc
     * @return AddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AddressQuery(get_called_class());
    }
}
