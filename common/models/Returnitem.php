<?php

namespace common\models;

use Yii;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "returnitem".
 *
 * @property integer $idreturn
 * @property integer $idelement
 * @property integer $quantity
 * @property string $date_return
 */
class Returnitem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'returnitem';
    }

    public function behaviors() {
        return [
            'timestamp' => [
               'class' => TimestampBehavior::className(),
                'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
            ],
               'value' => new \yii\db\Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
         
    }
    
 /*   public function beforeSave($insert)
    {
           parent::beforeSave($insert);
        if ($insert) {
            $this->created_by = \yii::$app->user->identity->id;
            $this->created_at = time();
        } else {
            $this->updated_by = \yii::$app->user->identity->id;
            $this->updated_at = time();
        }
    
     
      
    }*/
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idelement', 'quantity'], 'required'],
            [['idelement', 'quantity', 'created_by', 'updated_by'], 'integer'],
          //  [['updated_at'], 'safe'],
            [['idelement'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idreturn' => Yii::t('app', 'Idreturn'),
            'idelement' => Yii::t('app', 'Idelement'),
            'quantity' => Yii::t('app', 'Quantity'),
            'created_at' => Yii::t('app', 'Date Return'),
            'created_by' => Yii::t('app', 'created_by'),
            'updated_at' => Yii::t('app', 'updated_at'),
            'updated_by' => Yii::t('app', 'updated_by'),
        ];
    }
    
    public function getElements() {
        return $this->hasOne(Elements::className(), ['idelements' =>'idelement']);
    }
}
