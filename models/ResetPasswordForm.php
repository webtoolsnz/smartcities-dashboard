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
use yii\base\Model;

/**
 * Class ResetPasswordForm
 * @package app\models
 *
 * @property \app\models\User $user
 */
class ResetPasswordForm extends Model
{
    /**
     * @var String $new_password
     */
    public $password;

    /**
     * @var String $confirm_new_password
     */
    public $password_repeat;

    /**
     * @var \app\models\User $_user
     */
    private $_user;

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'password' => 'New Password',
            'password_repeat' => 'Confirm Password',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password', 'password_repeat'], 'required'],
            [['password'], 'compare', 'message' => 'Passwords must match'],
            ['password', PasswordStrengthValidator::className()],
        ];
    }

    /**
     * @param $user
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * @return bool
     */
    public function changePassword()
    {
        if ($this->validate()) {
            $this->user->password = $this->password;
            $this->user->removePasswordResetToken();
            return $this->user->save();
        }

        return false;
    }
}
