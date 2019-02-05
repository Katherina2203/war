<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "projectshortcut".
 *
 * @property integer $idshortcut
 * @property string $description
 * @property string $status
 */
class Projectsortcut extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projectshortcut';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['status'], 'string'],
            [['description'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idshortcut' => Yii::t('app', 'Idshortcut'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
