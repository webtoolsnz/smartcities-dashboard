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
use app\models\User;
use webtoolsnz\widgets\RadioButtonGroup;
use webtoolsnz\AdminLte\widgets\Box;

/**
 * @var yii\web\View $this
 * @var app\models\User $model
 * @var yii\widgets\ActiveForm $form
 */
?>


<?php $form = ActiveForm::begin([
        'id' => 'User',
        'layout' => 'horizontal',
        'enableClientValidation' => false,
    ]
); ?>

<?php echo $form->errorSummary($model); ?>

<?php $this->beginBlock('box_content'); ?>

<?= $form->field($model, 'first_name')->textInput() ?>
<?= $form->field($model, 'last_name')->textInput() ?>
<?= $form->field($model, 'email', [
    'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><span class="fa fa-envelope"></span></div>{input}</div>',
]) ?>

<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'role_id')->dropDownList(User::getRoles()) ?>


<?= $form->field($model, 'status_id')->widget(RadioButtonGroup::className(), [
    'items' => User::getStatuses(),
    'itemOptions' => [
        'buttons' => [
            User::STATUS_DELETED => ['activeState' => 'btn active btn-danger'],
        ]
    ]
]); ?>

<?php $this->endBlock(); ?>

<?php $this->beginBlock('actions') ?>
<?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-default']) ?>

<div class="pull-right">
    <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> ' . ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')), [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-primary'
    ]); ?>
</div>
<?php $this->endBlock() ?>

<?= Box::widget([
    'type' => 'primary',
    'content' => $this->blocks['box_content'],
    'footer' => $this->blocks['actions'],
]); ?>


<?php ActiveForm::end(); ?>



