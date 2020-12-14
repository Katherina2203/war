<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;

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
class Shortage extends ActiveRecord
{
    const STATUS_NOACTIVE = "0"; //значение по умолчанию. новая недостача создана. Создается, когда создается заявка
    const STATUS_ACTIVE = "1"; //недостача покрыта не полностью. Добавлена строка в outofstock
    const STATUS_CHANGED = "2"; //сделали замену в перечне
    const STATUS_CANCEL = "3"; //отказались от этой позиции
    const STATUS_CLOSE = "4"; //недостача покрыта полностью. Добавлена строка в outofstock
    
    const SCENARIO_COMPENSATE_SHORTAGE = "compensate_shortage";
    const SCENARIO_CHANGE_STATUS = "change_status";
    const SCENARIO_ADD_REQUEST = "add_request";
    
    public static function tableName()
    {
        return '{{%shortage}}';
    }
    
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new \yii\db\Expression('NOW()'),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
         
    }
    
//    public function beforeSave($insert)
//    {
//        if ($insert) {
//            $this->created_by = \yii::$app->user->identity->id;
//          //  $this->CreatedOn = time();
//        } else {
//            $this->updated_by = \yii::$app->user->identity->id;
//            //$this->ModifiedOn = time();
//        }
//    
//        if (parent::beforeSave($insert)) {
//            if ($this->isNewRecord) {
//                $this->status = self::STATUS_ACTIVE;
//            }
//            return true;
//        } else {
//            return false;
//        }
//    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quantity', 'idelement',], 'required'],
            [['quantity', 'idelement', 'idboard', 'iduser'], 'integer'],
            [['status'], 'default', 'value' => '0'],
            [['ref_of', 'note'], 'string', 'max' => 64],
            
            //SCENARIO_COMPENSATE_SHORTAGE rules
            [['quantity',], 'required', 'on' => self::SCENARIO_COMPENSATE_SHORTAGE],
            [['quantity',], 'integer', 'on' => self::SCENARIO_COMPENSATE_SHORTAGE],
            [['quantity',], 'trim', 'on' => self::SCENARIO_COMPENSATE_SHORTAGE],
            [['ref_of'], 'string', 'max' => 32, 'on' => self::SCENARIO_COMPENSATE_SHORTAGE],
            
            //SCENARIO_CHANGE_STATUS rules
            [['status',], 'required', 'on' => self::SCENARIO_CHANGE_STATUS],
            [['status',], 'string', 'on' => self::SCENARIO_CHANGE_STATUS],
            [['note',], 'trim', 'on' => self::SCENARIO_CHANGE_STATUS],
            [['note'], 'string', 'max' => 64, 'on' => self::SCENARIO_CHANGE_STATUS],
            
            //SCENARIO_ADD_REQUEST rules
            [['ref_of'], 'string', 'max' => 64],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_COMPENSATE_SHORTAGE] = [
            'quantity', 'ref_of',
        ];
         $scenarios[self::SCENARIO_CHANGE_STATUS] = [
            'status', 'note',
        ];
        $scenarios[self::SCENARIO_ADD_REQUEST] = [
            'ref_of',
        ];
        return $scenarios;
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '№'),
            'idrequest' => Yii::t('app', 'idrequest'),
            'quantity' => Yii::t('app', 'Кол-во'),
            'idelement' => Yii::t('app', 'Idelement'),
            'idboard' => Yii::t('app', 'Плата'),
            'ref_of' => Yii::t('app', 'Позиция на плате'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
    
    public function getBoards() {
        return $this->hasOne(Boards::className(), ['idboards' =>'idboard']);
    }
    
    public function getElements() {
        return $this->hasOne(Elements::className(), ['idelements' =>'idelement']);
    }
    
    public function getUsers() {
        return $this->hasOne(Users::className(), ['id' =>'iduser']);
    }
    
    public function getThemes() {
        return $this->hasOne(Themes::className(), ['idtheme' =>'idtheme']);
    }
    
   /* public function getThemes() 
    {
        return $this->hasMany(Themes::className(), ['idtheme' => 'idtheme'])
                ->viaTable('boards', ['idboards' => 'idboard']);
    }
    */
}
