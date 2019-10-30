<?php

namespace common\models;

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
    public $elements_count;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }
    
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => ['created', 'updated_at'],
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => ['created_by', 'edited_by'],
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
            [['name', 'url', 'parent', 'name_ru'], 'required'],
            [['parent'], 'integer'],
            [['name'], 'string', 'max' => 46],
            [['name_ru'], 'string', 'max' => 128],
            [['url'], 'string', 'max' => 26],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcategory' => Yii::t('app', 'Idcategory'),
            'name' =>  Yii::t('app', 'Название'),
            'name_ru' =>  Yii::t('app', 'Название на русском'),
            'url' => Yii::t('app', 'Url'),
            'parent' => Yii::t('app', 'Родительская категория'),
        ];
    }
    
    public function getChildren()
    {
        return $this->hasMany(self::className(), ['parent' => 'idcategory']);
    }
    
    public function getParent()
    {
        return $this->hasOne(self::className(), ['idcategory' => 'parent']);
    }
    
    public function getElements()
    {
        return $this->hasMany(Elements::className(), ['idcategory' => 'idcategory']);
    }
       
    public static function getHierarchy()
    {
        $aCategories = [];
        $aModels = Category::find()->orderBy('name ASC')->all();
        foreach ($aModels as $modelCategory) {
            $aCategories[$modelCategory->parent][$modelCategory->idcategory] = $modelCategory->name;
        }
         
        $aHierarchy = [];
        foreach ($aCategories[0] as $iParentId => $sParentName) {
            if (isset($aCategories[$iParentId])) {
                $aHierarchy[$sParentName] = $aCategories[$iParentId];
            } else {
                $aHierarchy[$sParentName] = [];
            }
        }
        return $aHierarchy;
    }
        
    public function getCategories($type = NULL, &$data = [], $parent = NULL)
    {
        $category = Category::find()->where(['parent' => $parent, 'type' => $type])->andWhere(['NOT IN', 'id', (!$this->isNewRecord) ? $this->idcategory : 0])->all();
        foreach ($category as $key => $value)
        {
            $data[$value->idcategory] = $this->getIndent($value->indent) . $value->name_ru;
            unset($category[$key]);
            $this->getCategories($type, $data, $value->idcategory);
        }
        return $data;
    }
    
    
}
