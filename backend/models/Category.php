<?php

namespace backend\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "category".
 *
 * @property integer $idcategory
 * @property string $name
 * @property string $url
 * @property integer $parent
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
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
              //  $this->active = self::ELEMENT_ACTIVE;
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
            [['name', 'url', 'parent'], 'required'],
            [['parent', 'created_by' , 'edited_by'], 'integer'],
            [['name'], 'string', 'max' => 46],
            [['url'], 'string', 'max' => 26],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcategory' => 'Idcategory',
            'name' => 'Name',
            'url' => 'Url',
            'parent' => 'Parent',
            'created_at' => 'Дата создания',
            'created_by' => 'Кем создано',
            'updated_at' => 'Дата обновления',
            'edited_by' => 'Кем редактировано',
        ];
    }
    
    
}
