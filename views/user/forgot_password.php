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

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ForgotPasswordForm */
/* @var $success bool */

$this->title = 'Forgot Password';
?>

<div class="row">
    <div class="col-md-6 col-centered">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><strong><?= $this->title ?></strong></h3></div>
            <div class="panel-body">
                <?php if ($success): ?>
                    <p>A message has been sent to <strong><?= Html::encode($model->email) ?></strong> with detailed instructions on how to proceed with the password reset.</p>

                    <p>Please check your inbox and proceed from there!</p>

                    <p>If the email never arrives, please contact your administrator.</p>
                <?php else: ?>
                    <p>Please enter the email address associated with your account, an email will be sent to that address with further instructions.</p>
                    <?php $form = ActiveForm::begin(['id' => 'forgot-password-form']); ?>
                    <?= $form->field($model, 'email') ?>
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                    <?php ActiveForm::end(); ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>






