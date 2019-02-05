<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "projectshortcut".
 *
 * @property integer $idshortcut
 * @property string $description
 * @property string $status
 */
class Projectshortcut extends \yii\db\ActiveRecord
{
    const SHORTCUT_SOSO = 1;
    const SHORTCUT_MUST = 2;
    const SHORTCUT_IMPORTANT = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%projectshortcut}}';
    }
    
    public function beforeSave($insert)
    {
        if ($insert) {
           // $this->created_by = \yii::$app->user->identity->id;
          //  $this->CreatedOn = time();
        } else {
           // $this->edited_by = \yii::$app->user->identity->id;
            //$this->ModifiedOn = time();
        }
    
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->significance = self::SHORTCUT_MUST;
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
            [['description'], 'required'],
            [['status', 'significance'], 'string'],
            [['description'], 'string', 'max' => 128],
            [['category', 'visible',], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idshortcut' => Yii::t('app', 'Idshortcut'),
            'description' => Yii::t('app', 'Description'),
            'category' => Yii::t('app', 'Category'),
            'status' => Yii::t('app', 'Status'),
            'visible' => Yii::t('app', 'Visible'),
            'significance' => Yii::t('app', 'Significance'),
        ];
    }
    
    public function getCategoryshortcut()
    {
        return $this->hasOne(Categoryshortcut::className(), ['id' => 'category']);
    }
    
    public static function getSignificance()
    {
        return [
            self::SHORTCUT_SOSO => 'Не важно',
            self::SHORTCUT_MUST => 'Норма',
            self::SHORTCUT_IMPORTANT => 'Важно'
        ];
    }
}
