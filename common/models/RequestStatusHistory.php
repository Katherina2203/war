<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "request_status_history".
 *
 * @property integer $idreqstatus
 * @property integer $idrequest
 * @property string $status
 * @property string $updated_at
 * @property integer $edited_by
 * @property string $note
 */
class RequestStatusHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%request_status_history}}';
    }
    
    public function behaviors() {
        return [
            'timestamp' => [
               'class' => TimestampBehavior::className(),
               'value' => new \yii\db\Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'updatedByAttribute' => 'edited_by',
            ],
        ];
         
    }
    
    public function beforeSave($insert)
    {
        if ($insert) {
          //  $this->created_by = \yii::$app->user->identity->id;
          //  $this->CreatedOn = time();
        } else {
            $this->edited_by = \yii::$app->user->identity->id;
            //$this->ModifiedOn = time();
        }
    
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
              //  $this->status = self::ACCOUNTS_ORDERED;
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
            [['idrequest', 'status', 'edited_by', 'note'], 'required'],
            [['idrequest', 'edited_by'], 'integer'],
            [['status'], 'string'],
        //    [['updated_at'], 'safe'],
            [['note'], 'string', 'max' => 48],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idreqstatus' => Yii::t('app', 'Idreqstatus'),
            'idrequest' => Yii::t('app', 'Idrequest'),
            'status' => Yii::t('app', 'Status'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'edited_by' => Yii::t('app', 'Edited By'),
            'note' => Yii::t('app', 'Note'),
        ];
    }
}
