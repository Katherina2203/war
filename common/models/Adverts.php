<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "adverts".
 *
 * @property integer $idadvert
 * @property integer $iduser
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property integer $ord
 */
class Adverts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adverts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iduser', 'content', 'ord'], 'required'],
            [['iduser', 'ord'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idadvert' => Yii::t('app', 'Idadvert'),
            'iduser' => Yii::t('app', 'Iduser'),
            'content' => Yii::t('app', 'Content'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'ord' => Yii::t('app', 'Ord'),
        ];
    }
    
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'iduser']);
    }
}
