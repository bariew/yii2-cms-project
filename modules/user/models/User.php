<?php

namespace app\modules\user\models;

use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;
use Yii;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $company_name
 * @property string $auth_key
 * api_key
 * @property string $email
 * @property integer $status
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{

    const SALT            = 'someDefSault';
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 10;
    const ROLE_USER  = 10;
    const ROLE_ADMIN = 50;
    const ROLE_ROOT  = 100;

    /**
     * gets all available user role list
     * @return array roles
     * @example $this->roleList() == [10=>'User', 50=>'Admin']
     */
    public static function roleList()
    {
        return [
            self::ROLE_USER  => 'User',
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_ROOT  => 'Root',
        ];
    }

    public function getRoleName()
    {
        return self::roleList()[$this->role];
    }

    /**
     * gets all available user status list
     * @return array statuses
     */
    public static function statusList()
    {
        return [
            self::STATUS_INACTIVE => 'Deactivated',
            self::STATUS_ACTIVE   => 'Active'
        ];
    }

    public function getStatusName()
    {
        return self::statusList()[$this->status];
    }

    /**
     * checks whether user access level fits access role or upper
     * @param integer $role access role
     * @return boolean whether user is needed level or upper
     */
    public function level($role)
    {
        return $this->role >= $role;
    }

    /**
     * activates users account
     */
    public function activate()
    {
        $attributes = ['status' => self::STATUS_ACTIVE];
        if (!$this->role) {
            $attributes['role'] = self::ROLE_USER;
        }
        $this->updateAttributes($attributes);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = NULL)
    {
        static::findOne(['auth_key' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire    = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts     = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status'               => self::STATUS_ACTIVE,
        ]);
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
        return $this->auth_key == $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password == self::hash2($password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = self::hash2($password);
    }

    /**
     * hashes string with sha256
     * @param string $string string to hash
     * @return string hashed string
     */
    private static function hash2($string)
    {
        return hash('sha256', $string . self::SALT);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Security::generateRandomKey();
    }

    public function generateApiKey()
    {
        $this->api_key = Security::generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Security::generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->isNewRecord) {
            if (!$this->api_key) {
                $this->generateApiKey();
            }
            $this->generateAuthKey();
            $this->setPassword($this['password']);
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class'      => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default',
                'value' => ($this->scenario == 'root') ? self::STATUS_ACTIVE : self::STATUS_INACTIVE
            ],
            ['status', 'in', 'range' => array_keys($this->statusList()), 'on' => 'root'],
            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => array_keys($this->roleList()), 'on' => 'root'],
            ['username', 'filter', 'filter' => 'trim'],
            [['email', 'username'], 'required'],
            [['email', 'username', 'api_key'], 'unique'],
            [['username', 'company_name', 'password', 'api_key'], 'string', 'min' => 2, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email'        => Yii::t('app', 'Email'),
            'username'     => Yii::t('app', 'Login'),
            'company_name' => Yii::t('app', 'Company name'),
            'auth_key'     => Yii::t('app', 'Auth key'),
            'api_key'      => Yii::t('app', 'Api key'),
        ];
    }

    public static function tableName()
    {
        return 'user_user';
    }

}
