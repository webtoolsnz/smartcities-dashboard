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

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Sign In';

?>
<div class="row">
    <div class="col-md-4 col-centered">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><strong><?= $this->title ?></strong></h3></div>
            <?php if (Yii::$app->session->hasFlash('password-reset')): ?>
                <div class="alert alert-success">
                    <?= Yii::$app->session->getFlash('password-reset') ?>
                </div>
            <?php endif ?>
            <div class="panel-body">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password', [
                    'template' => "{beginLabel}\n{labelTitle}\n".Html::a('(forgot password)', ['user/forgot-password'])."\n{endLabel}\n{input}\n{error}"
                ])->passwordInput() ?>
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>