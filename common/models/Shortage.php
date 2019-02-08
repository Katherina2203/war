<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "shortage".
 *
 * @property integer $id
 * @property integer $idboard
 * @property string $ref_of
 * @property integer $idelement
 * @property integer $quantity
 * @property string $date
 */
class Shortage extends \yii\db\ActiveRecord
{
    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shortage}}';
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
                'updatedByAttribute' => 'edited_by',
            ],
        ];
         
    }
    
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_by = \yii::$app->user->identity->id;
          //  $this->CreatedOn = time();
        } else {
            $this->edited_by = \yii::$app->user->identity->id;
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
            [['idboard', 'ref_of', 'idelement', 'quantity', 'date'], 'required'],
            [['idboard', 'idelement', 'quantity'], 'integer'],
            [['date'], 'safe'],
            [['status'], 'string'],
            [['ref_of', 'status'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idboard' => 'Idboard',
            'ref_of' => 'Ref Of',
            'idelement' => 'Idelement',
            'quantity' => 'Quantity',
            'created_at' => 'Date',
        ];
    }
    
    public function getBoards() {
        return $this->hasOne(Boards::className(), ['idboards' =>'idboard']);
    }
    
    public function getElements() {
        return $this->hasOne(Elements::className(), ['idelements' =>'idelement']);
    }
    
}
