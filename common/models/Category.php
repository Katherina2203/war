<?php

namespace common\models;

use Yii;

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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'parent'], 'required'],
            [['parent'], 'integer'],
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
            'idcategory' => Yii::t('app', 'Idcategory'),
            'name' =>  Yii::t('app', 'name'),
            'name_ru' =>  Yii::t('app', 'Название_рус'),
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
    
    public static function getHierarchy_Old()
    {
        $options = [];
         
        $parents = self::find()->where("parent=0")->all();
        foreach($parents as $id => $p) {
            $children = self::find()->where("parent=:parent", [":parent"=>$p->idcategory])->all();
            $child_options = [];
            foreach($children as $child) {
                $child_options[$child->idcategory] = $child->name;
            }
            $options[$p->name] = $child_options;
        }
        return $options;
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
