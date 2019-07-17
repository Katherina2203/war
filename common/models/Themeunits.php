<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "themeunits".
 *
 * @property integer $idunit
 * @property integer $idtheme
 * @property string $nameunit
 * @property integer $quantity_required
 * @property string $date_update
 */
class Themeunits extends \yii\db\ActiveRecord
{
    public $boards_count;

    const UNIT_ACTIVE = 'active';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%themeunits}}';
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
            [['idtheme', 'quantity_required', 'nameunit', 'status'], 'required'],
            [['nameunit'], 'required', 'message' => 'Please choose a category'],
            [['quantity_required'], 'required', 'message' => 'Please enter a quanity'],
            [['idtheme', 'quantity_required', 'created_by' , 'edited_by'], 'integer'],
            [['nameunit'], 'string', 'max' => 128],
            [['status'], 'default', 'value' => self::UNIT_ACTIVE],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idunit' => Yii::t('app', 'Idunit'),
            'idtheme' => Yii::t('app', 'Project'),
            'nameunit' => Yii::t('app', 'Unit name'),
            'quantity_required' => Yii::t('app', 'Quantity'),
            'status' => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'created_by' => Yii::t('app', 'Кем создано'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
            'edited_by' => Yii::t('app', 'Кем редактировано'),
            
        ];
    }
    
    public function getThemes()
    {
        return $this->hasOne(Themes::className(), ['idtheme' => 'idtheme']);
    }
    
    public function getBoards()
    {
        return $this->hasMany(Boards::className(), ['idthemeunit' => 'idunit']);
    }
    
     public function getBoardscount()
    {
        $boards_count = Themeunits::find()
                ->select([['{{%themeunits}}.*'], 'boards_count' => new Expression('COUNT({{%boards}}.idboards)')])
                ->joinWith(['boards'], false)
                ->groupBy(['{{%themeunits}}.idunit']);
        
         //return $boards_count;
    }
    
    public function getUnitsListId(){
        return $this->idunit. ' '. $this->nameunit;
    }
    
    public static function getThemeunitsList($idtheme) 
    {
       // $out = [];
        $data = Themeunits::find()
                ->select(['idunit as id', 'nameunit as name'])
                ->where(['idtheme' => $idtheme])
                ->andWhere(['status' => 'active'])
                ->asArray()
                ->all();
        $value = (count($data) == 0) ? ['' => ''] : $data;
        return $value;
        
    /*    foreach ($data as $dat) {
            $out[] = ['id' => $dat['id'], 'name' => $dat['name']];
        }
        return $output = [
            'output' => $out,
            'selected' => ''
        ];
     * */

    }
}
