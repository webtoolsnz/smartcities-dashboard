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
use app\modules\admin\models\DashSearch;
use app\models\Dash;


$this->title = 'Dashboards';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="table-responsive">
    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridBox::widget([
        'tools' => Html::a('<span class="glyphicon glyphicon-plus"></span> New Dashboard', ['create'], ['class' => 'btn btn-success btn-xs']),
        'dataProvider' => $dataProvider,
        'pager' => [
            'class' => yii\widgets\LinkPager::className(),
            'firstPageLabel' => Yii::t('app', 'First'),
            'lastPageLabel' => Yii::t('app', 'Last'),
        ],
        'filterModel' => $searchModel,
        'columns' => [
            [
                'headerOptions' => ['class' => 'tcol-5'],
                'label' => '',
                'format' => 'raw',
                'value' => function (DashSearch $d) {
                    return '<i class="fa fa-' . $d->icon. '"></i>';
                }
            ],
            [
                'headerOptions' => ['class' => 'tcol-20'],
                'attribute' => 'name',
                'label' => 'Name',
                'format' => 'raw',
                'value' => function (DashSearch $d) {
                    return Html::a((string)$d->name, ['update', 'id' => $d->id]);
                }
            ],
            [
                'headerOptions' => ['class' => 'tcol-20'],
                'attribute' => 'slug',
                'label' => 'Slug',
                'format' => 'raw',
                'value' => function (DashSearch $d) {
                    return Html::a((string)$d->slug, ['update', 'id' => $d->id]);
                }
            ],
            [
                'headerOptions' => ['class' => 'tcol-50'],
                'attribute' => 'description',
                'label' => 'Description',
                'format' => 'raw',
                'value' => function (DashSearch $d) {
                    return Html::a((string)$d->description, ['update', 'id' => $d->id]);
                }
            ],
            [
                'headerOptions' => ['class' => 'tcol-5'],
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['nowrap' => 'nowrap', 'class' => 'text-center'],
                'template' => '{delete}',
                'visibleButtons' => ['delete' => function ($model, $key, $index) {
                    return $model->status === Dash::STATUS_ACTIVE;
                }]
            ],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>



