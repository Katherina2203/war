<?php

namespace common\models;

use Yii;

use yii\db\ActiveRecord;
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
class RequestStatusHistory extends ActiveRecord
{
//    const SCENARIO_UPDATE_STATUS = "update_status";
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%request_status_history}}';
    }
    
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updated_at',],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'edited_by',
                'updatedByAttribute' => 'edited_by',
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idrequest', 'status',], 'required'],
            [['idrequest'], 'integer'],
            [['note',], 'trim'],
            [['note'], 'string', 'max' => 64],
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
    
    public static function saveStatusHistory($idrequest, $status, $note)
    {
        $modelRequestStatusHistory = new RequestStatusHistory();
        $modelRequestStatusHistory->idrequest = $idrequest;
        $modelRequestStatusHistory->status = $status;
        $modelRequestStatusHistory->note = $note;
        $modelRequestStatusHistory->save(false);
    }
}
