<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Html;
/**
 * This is the model class for table "specification".
 *
 * @property integer $idspec
 * @property integer $quantity
 * @property integer $idelement
 * @property integer $idboard
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Specification extends \yii\db\ActiveRecord
{
    const STATUS_NOACTIVE = 0; //статус относится к недостачам. 0-нет недостач
    const STATUS_ACTIVE = 1; // есть недостача
    const STATUS_CANCEL = 2; //отмена в недостачах
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%specification}}';
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
                $this->status = self::STATUS_NOACTIVE;
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
            [['quantity', 'idelement', 'idboard', 'created_by', 'updated_by'], 'required'],
            [['quantity', 'idelement', 'idboard', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idspec' => Yii::t('app', 'Idspec'),
            'quantity' => Yii::t('app', 'Quantity'),
            'idelement' => Yii::t('app', 'Idelement'),
            'idboard' => Yii::t('app', 'Idboard'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
    
    public function getElements() {
        return $this->hasOne(Elements::className(), ['idelements' =>'idelement']);
    }
    
    public function getBoards() {
        return $this->hasOne(Boards::className(), ['idboards' =>'idboard']);
    }
}
