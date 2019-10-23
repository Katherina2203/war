<?php
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\Themes;

/**
 * This is the model class for table "outofstock".
 *
 * @property integer $idofstock
 * @property integer $idelement
 * @property integer $iduser
 * @property integer $quantity
 * @property string $date
 * @property integer $idtheme
 * @property integer $idthemeunit
 * @property integer $idboart
 * @property string $ref_of_board
 */
class Outofstock extends \yii\db\ActiveRecord
{
    
    const SCENARIO_OUT_OF_STOCK_QUICKLY = "out_of_stock_quickly";
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%outofstock}}';
    }

    public function behaviors() {
        return [
           'timestamp' => [
               'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
           ],
        ];
         
    }
    
    public function rules()
    {
        return [
            [['idelement', 'iduser', 'quantity', 'idtheme', 'idthemeunit', 'idboart', 'ref_of_board'], 'required'], 
            [['idelement', 'iduser', 'quantity', 'idtheme', 'idthemeunit', 'idboart'], 'integer'],
            [['quantity', 'ref_of_board', ], 'trim'],
//            ['idtheme', 'required', 'message' => 'Please enter a project'],
//            ['idthemeunit', 'required', 'message' => 'Please enter a unit'],
//            ['idboart', 'required', 'message' => 'Please enter a board'],
            [['ref_of_board'], 'string', 'max' => 64],
            [['idelement'], 'validateElementId'],
            
            //SCENARIO_OUT_OF_STOCK_QUICKLY rules
            [['quantity', 'idboart',], 'required', 'on' => self::SCENARIO_OUT_OF_STOCK_QUICKLY],
            [['idelement', 'quantity', 'idboart',], 'integer', 'on' => self::SCENARIO_OUT_OF_STOCK_QUICKLY],
            [['quantity', 'idboart',], 'trim', 'on' => self::SCENARIO_OUT_OF_STOCK_QUICKLY],
            [['ref_of_board'], 'string', 'max' => 64, 'on' => self::SCENARIO_OUT_OF_STOCK_QUICKLY],
            [['idboart'], 'validateBoardId', 'on' => self::SCENARIO_OUT_OF_STOCK_QUICKLY],
        ];
    }
    
    public function validateElementId($attribute, $params)
    {
        if (!Elements::find()->where(['idelements' => $this->$attribute])->exists()) {
            $this->addError($attribute, 'Такого элемента нет.');
        }
    }
    
    public function validateBoardId($attribute, $params)
    {
        if (!Boards::find()->where(['idboards' => $this->$attribute])->exists()) {
            $this->addError($attribute, 'Такой платы нет.');
        }
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_OUT_OF_STOCK_QUICKLY] = [
            'idelement', 'quantity', 'idboart', 'ref_of_board',  // 'iduser', //'idelement', 
        ];
        return $scenarios;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idofstock' => Yii::t('app', 'Idofstock'),
            'idelement' => Yii::t('app', 'Idelement'),
            'iduser' => Yii::t('app', 'Iduser'),
            'quantity' => Yii::t('app', 'Количество'),
            'date' => Yii::t('app', 'Date'),
            'idtheme' => Yii::t('app', 'Проект'),
            'idthemeunit' => Yii::t('app', 'Модуль'),
            'idboart' => Yii::t('app', 'Плата'),
            'ref_of_board' =>  Yii::t('app', 'Поз. на плате'),
            'idprice' =>  Yii::t('app', 'Цена'),
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
    
    public function getBoards()
    {
        return $this->hasOne(Boards::className(), ['idboards' => 'idboart']);
    }
    
    public function getSpecification()
    {
        return $this->hasOne(Specification::className(), ['idboard' => 'idboart']);
    }         
    
    public function getElements()
    {
        return $this->hasOne(Elements::className(), ['idelements' => 'idelement']);
    }
    
     public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'iduser']);
    }
    
    public function getPrices()
    {
        return $this->hasOne(Prices::className(), ['idel' => 'idelement']);
                //->viaTable('elements', ['idelements' => 'idelement']);
    }
}
