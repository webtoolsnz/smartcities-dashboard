<?php
/**
 * This file is part of webtoolsnz\smartcities-dashboard
 *
 * @copyright Copyright (c) 2017 Webtools Ltd
 * @license http://opensource.org/licenses/MIT
 * @link https://github.com/webtoolsnz/smartcities-dashboard
 * @package webtoolsnz/smartcities-dashboard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace app\models;

use webtoolsnz\validators\PasswordStrengthValidator;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;


class User extends base\User implements \yii\web\IdentityInterface
{
    const ROLE_VIEWER = 10;
    const ROLE_EDITOR = 20;
    const ROLE_MASTER = 30;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $password;

    private static $_statuses = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_DELETED => 'Inactive',
    ];

    private static $_roles = [
        self::ROLE_VIEWER => 'Viewer',
        self::ROLE_EDITOR => 'Editor',
        self::ROLE_MASTER => 'Master',
    ];


    /**
     * String representation of the object.
     *
     * @return string
     */
    public function __toString()
    {
        $names = array_filter([$this->first_name, $this->last_name]);
        return implode(' ', $names);
    }

    /**
     * Return an array of User statuses
     *
     * @return array
     */
    public static function getStatuses()
    {
        return self::$_statuses;
    }

    /**
     * Return the label of the current user status
     *
     * @return String
     */
    public function getStatus()
    {
        return ArrayHelper::getValue(self::$_statuses, $this->status_id);
    }

    /**
     * Return an array of all user roles
     *
     * @return array
     */
    public static function getRoles()
    {
        return self::$_roles;
    }

    /**
     * Return the label of the assigned role.
     *
     * @return String
     */
    public function getRole()
    {
        return ArrayHelper::getValue(self::$_roles, $this->role_id);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('CURRENT_TIMESTAMP'),
            ]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'role_id' => 'Role',
            'status_id' => 'Status'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();

        return ArrayHelper::merge($rules, [
            ['status_id', 'default', 'value' => self::STATUS_ACTIVE],
            ['role_id', 'default', 'value' => self::ROLE_VIEWER],
            ['password', 'string'],
            ['password', PasswordStrengthValidator::className()],
            ['status_id', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status_id' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()->where(['access_token' => $token, 'status_id' => self::STATUS_ACTIVE])->one();
    }

    /**
     * Finds user by email
     *
     * @param  string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status_id' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return null|\app\models\User
     */
    public static function findByPasswordResetToken($token)
    {
        $user = User::findOne([
            'password_reset_token' => $token,
            'status_id' => User::STATUS_ACTIVE,
        ]);

        if (!$user || !$user->isPasswordResetTokenValid()) {
            return null;
        }

        return $user;
    }

    /**
     * Finds out if password reset token is valid
     *
     * @return boolean
     */
    public function isPasswordResetTokenValid()
    {
        if (empty($this->password_reset_token)) {
            return false;
        }

        $expire = Yii::$app->params['user.passwordResetTokenExpire'];

        $expireDate = strtotime(
            sprintf('+%s Minutes', $expire),
            strtotime($this->password_reset_token_created)
        );

        return (time() <= $expireDate);
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
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
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
        $this->password_reset_token_created = new Expression('CURRENT_TIMESTAMP');
        $this->password_reset_token = Yii::$app->security->generateRandomString();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
        $this->password_reset_token_created = null;
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->generateAuthKey();
        }

        if ($this->password) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }
        return parent::beforeSave($insert);
    }
}
