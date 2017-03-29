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
use app\models\Gizmo;
use app\models\ColourScheme;
use webtoolsnz\widgets\RadioButtonGroup;
use webtoolsnz\AdminLte\widgets\Box;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var app\models\Gizmo $model
 * @var yii\widgets\ActiveForm $form
 */
?>


<?php $form = ActiveForm::begin([
        'id' => 'Gizmo',
        'layout' => 'horizontal',
        'enableClientValidation' => false,
    ]
); ?>

<?php echo $form->errorSummary($model); ?>

<?php $this->beginBlock('box_content'); ?>

<?= $form->field($model, 'name')->textInput()->hint('Name of the gizmo. Displayed on gizmos with headers.') ?>
<?= $form->field($model, 'description')->textInput() ?>
<?= $form->field($model, 'slug')->textInput()->hint('Unique identifier for the gizmo.') ?>
<?= $form->field($model, 'size')->textInput()->hint('In width, height format. A page is 12 units across. Typical values are 3,1 3,2 3,4 6,2 6,4') ?>

<?= $form->field($model, 'status')->widget(RadioButtonGroup::className(), [
    'items' => Gizmo::getStatuses(),
    'itemOptions' => [
        'buttons' => [
            Gizmo::STATUS_DELETED => ['activeState' => 'btn active btn-danger'],
        ]
    ]
]); ?>

<?= $form->field($model, 'header')->widget(RadioButtonGroup::className(), [
    'items' => Gizmo::getHeaderTypes(),
    'itemOptions' => [
        'buttons' => [
            Gizmo::HEADER_TYPE_TABBED => ['activeState' => 'btn active btn-info'],
            Gizmo::HEADER_TYPE_NONE => ['activeState' => 'btn active'],
        ]
    ]
])->hint('Tabbed gizmos must have &lt;tab&gt; elements in their templates.'); ?>

<?= $form->field($model, 'icon', [
    'template' => '{label} <div class="col-sm-2">{input}<a href="http://fontawesome.io/cheatsheet/"><i class="fa fa-question-circle"></i></a> {hint} {error}</div>',
])->textInput() ?>

<?= $form->field($model, 'image', [
    'horizontalCssClasses' => ['wrapper' => 'col-sm-2']
])->textInput() ?>

<div class="form-group field-gizmo-colour-scheme">
    <label for="dash-colour-scheme" class="control-label col-sm-3">Colour Scheme</label>
    <div class="col-sm-6">
        <?= Html::activeDropDownList($model, 'colour_scheme_id',
            ArrayHelper::map(ColourScheme::find()->all(), 'id', 'name')) ?>
    </div>
</div>

<?php if (!$model->report_class) { ?>
    <?= $form->field($model, 'template', [
        'template' => '{label} <div class="col-sm-6">{input} {hint} {error}</div><div class="help-block col-sm-3"><a href="help">Template Help</a></div>',
    ])->textArea(['rows'=>10]) ?>
<?php } ?>

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



