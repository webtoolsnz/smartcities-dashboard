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
use app\models\Dash;
use webtoolsnz\widgets\RadioButtonGroup;
use webtoolsnz\AdminLte\widgets\Box;

/**
 * @var yii\web\View $this
 * @var app\models\Dash $model
 * @var yii\widgets\ActiveForm $form
 */
?>


<?php $form = ActiveForm::begin([
        'id' => 'Dash',
        'layout' => 'horizontal',
        'enableClientValidation' => false,
    ]
); ?>

<?php echo $form->errorSummary($model); ?>

<?php $this->beginBlock('box_content'); ?>

<?= $form->field($model, 'name')->textInput() ?>
<?= $form->field($model, 'description')->textInput() ?>
<?= $form->field($model, 'slug')->textInput() ?>

<?= $form->field($model, 'status')->widget(RadioButtonGroup::className(), [
    'items' => Dash::getStatuses(),
    'itemOptions' => [
        'buttons' => [
            Dash::STATUS_DELETED => ['activeState' => 'btn active btn-danger'],
        ]
    ]
]); ?>

<?= $form->field($model, 'icon', [
    'template' => '{label} <div class="col-sm-2">{input}<a href="http://fontawesome.io/cheatsheet/"><i class="fa fa-question-circle"></i></a> {hint} {error}</div>',
])->textInput() ?>

<?php echo $this->render('_dash_gizmos', ['model' => $model,]); ?>

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



