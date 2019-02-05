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
            [['idtheme', 'idthemeunit'], 'integer'],
            [['name', 'current', 'date_added', 'discontinued'], 'required'],
            [['date_added'], 'safe'],
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
    
    public function getUsers(){
        return $this->hasOne(Users::className(), ['id' => 'current']);
    }
    
    public function getBoardnameId(){
        return $this->idboards. ' '. $this->name;
    }
    
    public static function getBoardList($idtheme, $idthemeunit)
    {
        $out = [];
        $selected = '';
        $data = Boards::find()
                ->where(['idtheme' => $idtheme])
                ->andWhere(['idthemeunit' => $idthemeunit])
                ->select(['idboards as id', 'name'])
                ->asArray()
                ->all();
         
        foreach ($data as $dat => $datas) {
             $out[] = ['idboards' => $datas['idboart'], 'name' => $datas['idboart']];

            if($dat == 0){
                    $aux = $datas['idboart'];
                }


            ($datas['idtheme'] == $idtheme) ? $selected = $idtheme : $selected = $aux;

        }
        return $out = [
            'output' => $output,
            'selected' => $selected
        ];

    }
    
    
}
