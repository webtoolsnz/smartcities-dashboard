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


namespace app\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use app\models\User;
use app\models\LoginForm;
use app\models\ForgotPasswordForm;
use app\models\ResetPasswordForm;

/**
 * Class UserController
 * @package app\controllers
 */
class UserController extends Controller
{
    /**
     * @var string
     */
    public $layout = 'blank';

    /**
     * Render Login form and allow user to authenticate
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        } else {
            return $this->render('login', ['model' => $model,]);
        }
    }

    /**
     * Log the current user out and redirect them to the default controller/action
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     *
     * @return string
     */
    public function actionForgotPassword()
    {
        $model = new ForgotPasswordForm();
        $success = false;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->sendEmail();
            $success = true;
        }

        return $this->render('forgot_password', [
            'success' => $success,
            'model' => $model,
        ]);
    }

    /**
     *
     * @param $t
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        Yii::$app->user->logout();

        $model = new ResetPasswordForm();
        $user = User::findByPasswordResetToken($token); /* @var \app\models\User $user */

        if (!$user) {
            throw new BadRequestHttpException('Password reset link is invalid or has expired');
        }

        $model->setUser($user);

        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            Yii::$app->session->setFlash(
                'password-reset',
                'Your password has been successfully set. Please Login.'
            );

            return $this->redirect(Yii::$app->user->loginUrl);
        }

        return $this->render('password_reset', ['model' => $model]);
    }

}


