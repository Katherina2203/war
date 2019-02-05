<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categoryshortcut".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 */
class Categoryshortcut extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%categoryshortcut}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'parent_id'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'parent_id' => Yii::t('app', 'Parent ID'),
        ];
    }
    
    public function getChildren()
    {
        return $this->hasMany(self::className(), ['parent_id' => 'id']);
    }
    
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }
    
    public function getProjectshortcut()
    {
        return $this->hasMany(Projectshortcut::className(), ['idcategory' => 'idcategory']);
    }
    
    public static function getHierarchy() {
        $options = [];
         
        $parents = self::find()->where("parent_id=0")->all();
        foreach($parents as $id => $p) {
            $children = self::find()->where("parent_id=:parent_id", [":parent_id"=>$p->id])->all();
            $child_options = [];
            foreach($children as $child) {
                $child_options[$child->id] = $child->name;
            }
            $options[$p->name] = $child_options;
        }
        return $options;
    }

    public function getCategories($type = NULL, &$data = [], $parent = NULL)
    {
        $category = Categoryshortcut::find()->where(['parent_id' => $parent, 'type' => $type])->andWhere(['NOT IN', 'id', (!$this->isNewRecord) ? $this->id : 0])->all();
        foreach ($category as $key => $value)
        {
            $data[$value->id] = $this->getIndent($value->indent) . $value->name;
            unset($category[$key]);
            $this->getCategories($type, $data, $value->id);
        }
        return $data;
    }
    
    /**
     * @inheritdoc
     * @return CategQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategQuery(get_called_class());
    }
}
