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

use Yii;
use yii\base\Model;

/**
 * Class ForgotPasswordForm
 * @package app\models
 */
class ForgotPasswordForm extends Model
{
    /**
     * @var String $email
     */
    public $email;

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Email Address',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],
        ];
    }

    /**
     * If a user with the given email address is found then generate a
     * password reset token and send a link to the users email address.
     *
     * @return bool
     */
    public function sendEmail()
    {
        $user = User::find()->where(['email' => $this->email])->one(); /* @var \app\models\User $user */

        if (!$user) {
            return false;
        }

        $user->generatePasswordResetToken();
        $user->save();

        $subject = sprintf('%s Password Reset', Yii::$app->request->serverName);

        return Yii::$app->mailer->compose('user/password_reset_email', ['user' => $user])
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($user->email)
            ->setSubject($subject)
            ->send();
    }
}
