<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;


/**
 * This is the model class for table "boards".
 *
 * @property integer $idboards
 * @property integer $idtheme
 * @property integer $idthemeunit
 * @property string $name
 * @property string $current
 * @property string $date_added
 * @property string $discontinued
 */
class Boards extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%boards}}';
    }
    
    const DISCONTINUED_NOACTIVE = 0;
    const DISCONTINUED_ACTIVE = 1;
    
    public function behaviors() {
        return [
            'timestamp' => [
               'class' => TimestampBehavior::className(),
               'value' => new \yii\db\Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
         
    }
    
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_by = \yii::$app->user->identity->id;
          //  $this->CreatedOn = time();
        } else {
            $this->updated_by = \yii::$app->user->identity->id;
            //$this->ModifiedOn = time();
        }
    
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->discontinued = self::DISCONTINUED_ACTIVE;
            }
            return true;
        } else {
            return false;
        }
    }
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new BoardsQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtheme', 'idthemeunit', 'quantity'], 'integer'],
            [['name', 'current', 'date_added', 'discontinued', 'quantity'], 'required'],
            [['date_added', 'quantity'], 'safe'],
            [['discontinued'], 'string'],
            [['name', 'current'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idboards' => 'Idboards',
            'idtheme' => 'Проект',
            'idthemeunit' => 'Модуль',
            'name' => 'Название',
            'current' => 'Ответственный',
            'quantity' => 'Количество',
            'date_added' => 'Дата создания',
            'discontinued' => 'Актуальность',
        ];
    }
    
    public function getThemes()
    {
        return $this->hasOne(Themes::className(), ['idtheme' => 'idtheme']);
    }
    
    public function getThemeunits()
    {
        return $this->hasOne(Themeunits::className(), ['idunit' => 'idthemeunit']);
    }
    
    public function getOutofstock()
    {
        return $this->hasOne(Outofstock::className(), ['idboart' => 'idboards']);
    }
    
    public function getUsers(){
        return $this->hasOne(Users::className(), ['id' => 'current']);
    }
    
    public function getBoardnameId(){
        return $this->idboards. ' '. $this->name;
    }
    
    public function getShortage(){
        return $this->hasOne(Shortage::className(), ['idboard' => 'idboards']);
    }
    
    public static function getBoardList($idthemeunit)
    {
//        $out = [];
//        $selected = '';
        $data = Boards::find()
                //->where(['idtheme' => $idtheme])
                ->where(['idthemeunit' => $idthemeunit])
                ->andWhere(['discontinued' => '1'])
                ->select(['idboards as id', 'CONCAT(idboards, "  ", name) as name'])
                ->asArray()
                ->all();
//        foreach ($data as $dat => $datas) {
//             $out[] = ['idboards' => $datas['idboards'], 'name' => $datas['name']];
//
//            if($dat == 0){
//                $aux = $datas['idboards'];
//            }
////            ($datas['idtheme'] == $idtheme) ? $selected = $idtheme : $selected = $aux;
//
//        }
        $selected = isset($data[0]) ? $data[0]['id'] : '0';
        return [
            'output' => $data,
            'selected' => $selected,
        ];
    }
    
    public static function getProject(){
         
    }
}
