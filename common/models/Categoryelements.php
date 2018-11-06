<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categoryelements".
 *
 * @property integer $idcategory
 * @property integer $idelement
 */
class Categoryelements extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categoryelements';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idcategory', 'idelement'], 'required'],
            [['idcategory', 'idelement'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcategory' => Yii::t('app', 'Idcategory'),
            'idelement' => Yii::t('app', 'Idelement'),
        ];
    }
}
