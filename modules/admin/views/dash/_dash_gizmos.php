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
use webtoolsnz\AdminLte\widgets\GridBox;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use app\models\Gizmo;
use app\models\Dash;
use yii\bootstrap\Button;
use yii\web\View;

?>

<?php
    $dataProvider = new ArrayDataProvider(['allModels' => $model->dashGizmos]);
?>

<div class="form-group field-dash-gizmos">
    <label for="dash-gizmos" class="control-label col-sm-3">Gizmos</label>
    <div class="col-sm-6">
        <div class="table-responsive">
            <?= GridBox::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => 'No gizmos on this dashboard. You can add gizmos using the dropdown below.',
                'columns' => [
                    [
                        'value' => function($model){
                            return $model->gizmo->name . '<span class="gizmo-desc-sub">' . $model->gizmo->description . '</span>';
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'order',
                        'value' => function($model){
                            return Html::textInput('DashGizmo[' . $model->gizmo_id . ']', $model->order);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'link',
                        'value' => function($model){
                            $link = $model->gizmo->getLink($model->dash_id);
                            $allDashes = [0 => ''];
                            foreach (ArrayHelper::map(Dash::find()->where(['status' => Dash::STATUS_ACTIVE])->all(), 'id', 'name') as $id => $dash) {
                                $allDashes[$id] = $dash;
                            }
                            return Html::activeDropDownList($link ? $link : $model, 'id', $allDashes, ['id' => 'dash-link-'. $model->gizmo_id, 'name' => 'DashLink[' . $model->gizmo_id . ']']);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'value' => function($model){
                            return '<a class="action-button" href="#"><span class="glyphicon glyphicon-trash"></span></a>';
                        },
                        'format' => 'raw'
                    ]
                ],
            ]); ?>
        </div>
    </div>
</div>


<div class="form-group field-dash-gizmos">
    <label for="dash-gizmos" class="control-label col-sm-3">Add Gizmo</label>
    <div>
        <?= Html::dropDownList($model, null,
            ArrayHelper::map(Gizmo::find()->where(['status' => Gizmo::STATUS_ACTIVE])->all(), 'id', 'name'), ['id' => 'gizmo-add-list']) ?>
        <?= Button::widget([
            'label' => 'Add',
            'options' => ['id' => 'gizmo-add', 'class' => 'btn-sm btn-primary'],
        ]); ?>
        <div class="row">
            <div class="control-label col-md-3" style="font-weight: bold;">
                Preview
            </div>
            <div class="col-md-9">
                <div id="gizmo-info"></div>
            </div>
        </div>
    </div>
</div>


<?php
$addScript = "
window.util = {};

util.addGizmo = function() {
    $('.field-dash-gizmos').find('table div.empty').closest('tr').remove();
    this.maxOrder = 1;
    var that = this;
    $('.field-dash-gizmos').find('input').each(function(index) {
        var gizmoOrder = parseInt($(this).val());
        if (gizmoOrder >= that.maxOrder) {
            that.maxOrder = gizmoOrder + 1;
        }
    });
    var newKey = parseInt($('.field-dash-gizmos').find('tr:last').data('key')) + 1;
    if (isNaN(newKey)) {
        newKey = 1;
    }
    var gizmoId = $('#gizmo-add-list option:selected').val();
    var gizmoName = $('#gizmo-add-list option:selected').text();
    var newRow = '<tr data-key=\"' + newKey + '\"><td>' + gizmoName + '</td><td><input type=\"text\" name=\"DashGizmo[' + gizmoId + ']\" value=\"' + this.maxOrder + '\"></td>';
    newRow += '<td>" . trim(preg_replace('/\s+/', ' ', Html::dropDownList('DashLink[{{gizmoId}}]', null, array_merge([''], ArrayHelper::map(Dash::find()->where(['status' => Dash::STATUS_ACTIVE])->all(), 'id', 'name')), ['id' => 'dash-link-{{gizmoId}}']))) . "</td>'
    newRow += '<td><a class=\"action-button\" href=\"#\"><span class=\"glyphicon glyphicon-trash\"></span></a></td></tr>'
    newRow = newRow.replace(/\{\{gizmoId\}\}/g, gizmoId);
    $('.field-dash-gizmos').find('tbody').append(newRow);
    console.log('foo')
}

util.gizmoInfo = function(event) {
    var gizmoId = $('#gizmo-add-list option:selected').val();
    var endpointUrl = '/admin/gizmo/info?id=' + gizmoId;
    $('#gizmo-info').replaceWith('<div id=\"gizmo-info\"></div>');
    $.getJSON(endpointUrl).done(function(data) {
        var template = '<div id=\"gizmo-info\" class=\"{{colour_scheme}}\"><a href=\"/admin/gizmo/update?id=' + gizmoId + '\"><i class=\"fa fa-{{icon}}\"></i><b>{{name}}</b> {{description}}</a></div>'
        var rendered = Mustache.render(template, data);
        $('#gizmo-info').replaceWith(rendered);
    });
}

util.gizmoPreview = function(event) {
    var gizmoId = $('#gizmo-add-list option:selected').val();
    $('#gizmo-info').replaceWith('<div id=\"gizmo-info\"></div>')
    $('#gizmo-info').append('<div class=\"overlay\"><i class=\"fa fa-asterisk fa-spin\"></i></div>');
    var preview = $('<iframe style=\"border: none;\" src=\"/gizmo/preview?id=' + gizmoId +'\"></iframe>');
    preview.width(800).height(420);
    $('#gizmo-info').append(preview);
    setTimeout(function() {
        $('#gizmo-info').find('.overlay').remove();
    }, 1000);
}

jQuery('#gizmo-add').on('click', function(event) {
    event.preventDefault();
    util.addGizmo();
    return false;
})

jQuery('.field-dash-gizmos').on('click', '.action-button', function(event) {
    event.preventDefault();
    $(this).closest('tr').remove();
    return false;
});

jQuery('#gizmo-add-list').on('change', util.gizmoPreview);
jQuery(util.gizmoPreview);

";

$this->registerJs($addScript, View::POS_END, 'add-script');
?>
