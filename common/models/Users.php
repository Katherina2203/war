<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

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
class Users extends ActiveRecord implements IdentityInterface
{
    public $photo;
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const USER_TYPE_SUPER_ADMIN = 1;//'SuperAdmin'
    const USER_TYPE_HEAD = 2;
    const USER_TYPE_PURCHASING = 4;
    const USER_TYPE_ENGINEER = 6;
    const USER_TYPE_MANAGER = 8;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }
    
    public static function primaryKey() {
        return ['id'];
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['photo', 'name', 'surname', 'username', 'password', 'password_hash', 'password_reset_token', 'auth_key', 'email', 'role', 'authKey'], 'required'],
            [['role', 'status'], 'integer'],
            [['email'], 'string', 'max' => 64],
            [['photo'], 'file', 'extensions'=>'jpg, gif, png, jpeg'],
            [['photo'], 'file', 'maxSize'=>'100000'],
            [['name', 'surname', 'auth_key'], 'string', 'max' => 32],
            [['username'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 12],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['authKey'], 'string', 'max' => 50],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'photo' => Yii::t('app', 'Photo'),
            'name' => Yii::t('app', 'Name'),
            'surname' => Yii::t('app', 'Фамилия'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'email' => Yii::t('app', 'Email'),
            'role' => Yii::t('app', 'Role'),
            'status' => Yii::t('app', 'Status'),
            'authKey' => Yii::t('app', 'Auth Key'),
        ];
    }
    
     public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['users.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    public function getRole(){
        // if user can have only one role
        //role = 4 purchasing group
        return current(\Yii::$app->authManager->getRolesByUser($this->id));
    }
    
    
    public function getUsersList(){
         $users = Users::find()
                ->select(['u.id', 'u.username'])
                ->join('JOIN', 'users u', 'users.id = u.id')
                ->distinct(TRUE)
                ->all();
        
        return \yii\helpers\ArrayHelper::map($users, 'id', 'username');
    }
    
    public function afterValidate() {
        $this->id = \yii::$app->user->identity->id;
    }
    
    public function getUsers(){
        return $this->hasOne(Users::className(),['id'=>'id']);
    }
    
    public function getUserName(){
        return $this->name. ' '. $this->surname;
    }
    
    
    public function getName()
    {
        return \Yii::$app->user->identity->name;
    }
    
    public function getPhoto()
    {
        return \Yii::$app->user->identity->photo;
    }
}
