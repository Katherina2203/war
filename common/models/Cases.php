<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "cases".
 *
 * @property integer $idcase
 * @property string $value
 * @property string $LibraryRef
 * @property string $FootprintRef
 * @property string $LibraryPath
 * @property string $FootprintPath
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Cases extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cases';
    }
    
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
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
     /*   if ($insert) {
            $this->created_by = \yii::$app->user->identity->id;
          //  $this->CreatedOn = time();
        } else {
            $this->updated_by = \yii::$app->user->identity->id;
            //$this->ModifiedOn = time();
        }*/
    
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_by = \yii::$app->user->identity->id;
              //  $this->active = self::ELEMENT_ACTIVE;
            }else {
            $this->updated_by = \yii::$app->user->identity->id;
            //$this->ModifiedOn = time();
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
            [['value'], 'required'],
        //    [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['value', 'LibraryRef', 'FootprintRef', 'LibraryPath'], 'string', 'max' => 28],
            [['FootprintPath'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcase' => Yii::t('app', 'Idcase'),
            'value' => Yii::t('app', 'Value'),
            'LibraryRef' => Yii::t('app', 'Library Ref'),
            'FootprintRef' => Yii::t('app', 'Footprint Ref'),
            'LibraryPath' => Yii::t('app', 'Library Path'),
            'FootprintPath' => Yii::t('app', 'Footprint Path'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
