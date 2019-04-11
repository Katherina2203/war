<?php

namespace backend\models;

use Yii;

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
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'boards';
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
            'idtheme' => 'Idtheme',
            'idthemeunit' => 'Idthemeunit',
            'name' => 'Name',
            'current' => 'Current',
            'date_added' => 'Date Added',
            'discontinued' => 'Discontinued',
        ];
    }
}
