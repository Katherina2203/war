<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
/**
 * This is the model class for table "themes".
 *
 * @property integer $idtheme
 * @property string $projectnumber
 * @property string $name
 * @property string $full_name
 * @property string $customer
 * @property string $description
 * @property string $subcontractor
 * @property string $quantity
 * @property string $date
 * @property string $status
 */
class Themes extends \yii\db\ActiveRecord
{
    public $units_count;
    public $boards_count;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'themes';
    }
   
    public function behaviors() {
        return [
           'timestamp' => [
               'class' => TimestampBehavior::className(),
               'value' => new \yii\db\Expression('NOW()'),
           ],
        ];
         
    }
    
    public function rules()
    {
        return [
            [['name', 'quantity', 'date', 'status'], 'required'],
            [['description', 'status'], 'string'],
            [['date'], 'safe'],
            [['projectnumber'], 'string', 'max' => 20],
            [['name', 'customer'], 'string', 'max' => 64],
            [['full_name'], 'string', 'max' => 128],
            [['subcontractor'], 'string', 'max' => 30],
            [['quantity'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idtheme' => Yii::t('app', '#проекта'),
            'projectnumber' => Yii::t('app', 'Номер'),
            'name' => Yii::t('app', 'Проект'),
            'full_name' => Yii::t('app', 'Полное название'),
            'customer' => Yii::t('app', 'Заказчик'),
            'description' => Yii::t('app', 'Описание'),
            'subcontractor' => Yii::t('app', 'Подрядчик'),
            'quantity' => Yii::t('app', 'Количество'),
            'date' => Yii::t('app', 'Дата'),
            'status' => Yii::t('app', 'Статус'),
        ];
    }
    
    public function getThemeunits() {
        return $this->hasOne(Themeunits::className(), ['idtheme' =>'idtheme']);
    }
    
    public function getBoards() {
        return $this->hasOne(Boards::className(), ['idtheme' =>'idtheme']);
    }
    
    public function getThemList(){
        return $this->idtheme . ' ' . $this->name;
    }
     public function getThemesList(){
        $themes = Themes::find()
                ->select(['t.idtheme', 't.name'])
                ->join('JOIN', 'themes t', 'themes.idtheme = t.idtheme')
                ->where(['themes.status' => 'active'])
                //->distinct(TRUE)
                ->all();
        
        return \yii\helpers\ArrayHelper::map($themes, 'idtheme', 'name');
    }
    
    public function getUnitscount()
    {
        $units_count = Themes::find()
                ->select([['{{%themes}}.*'], 'units_count' => new Expression('COUNT({{%themeunits}}.idunit)')])
                ->joinWith(['themeunits'], false)
                ->groupBy(['{{%themes}}.idtheme']);
        
         return \yii\helpers\ArrayHelper::map($units_count, 'units_count', 'idtheme');
         
                
    }
    
   
    
}
