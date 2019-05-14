<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property integer $IDSup
 * @property string $Firm
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%supplier}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['manager', 'address', 'phone', 'website', 'logo'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['logo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, gif, jpg, jpeg', 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idsupplier' => Yii::t('app', 'Idsupplier'),
            'name' => Yii::t('app', 'Поставщик'),
            'address' => Yii::t('app', 'Адрес'),
            'phone' => Yii::t('app', 'Тел.'),
            'manager' => Yii::t('app', 'Менеджер'),
            'website' => Yii::t('app', 'www'),
            'logo' => Yii::t('app', 'Logo')
        ];
    }
}
