<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $photo
 * @property string $name
 * @property string $surname
 * @property string $username
 * @property string $password
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property string $email
 * @property integer $role
 * @property integer $status
 * @property string $authKey
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['photo', 'name', 'surname', 'username', 'password', 'password_hash', 'password_reset_token', 'auth_key', 'email', 'role', 'authKey'], 'required'],
            [['role', 'status'], 'integer'],
            [['photo', 'email'], 'string', 'max' => 64],
            [['name', 'surname', 'auth_key'], 'string', 'max' => 32],
            [['username'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 12],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['authKey'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photo' => 'Photo',
            'name' => 'Name',
            'surname' => 'Surname',
            'username' => 'Username',
            'password' => 'Password',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'auth_key' => 'Auth Key',
            'email' => 'Email',
            'role' => 'Role',
            'status' => 'Status',
            'authKey' => 'Auth Key',
        ];
    }
}
