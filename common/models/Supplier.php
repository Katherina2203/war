<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Html;



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
    
    public function behaviors() {
        return [
            'timestamp' => [
               'class' => TimestampBehavior::className(),
               'value' => new \yii\db\Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
         
    }
    
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_by = \yii::$app->user->identity->id;
          //  $this->CreatedOn = time();
        } else {
            $this->updated_by = \yii::$app->user->identity->id;
            //$this->ModifiedOn = time();
        }
    
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
               
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['manager', 'address', 'phone', 'website', 'logo'], 'safe'],
            [['created_by' , 'edited_by'], 'integer'],
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
