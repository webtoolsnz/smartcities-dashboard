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
/* @var $model app\models\ResetPasswordForm */

$this->title = 'Reset Password';
?>

<div class="row">
    <div class="col-md-6 col-centered">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><strong><?= $this->title ?></strong></h3></div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                <?= Html::submitButton('Change Password', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
