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
use app\modules\admin\models\UserSearch;
use app\models\User;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\admin\models\UserSearch $searchModel
 */

$this->title = app\models\User::label(2);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="table-responsive">
    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridBox::widget([
        'tools' => Html::a('<span class="glyphicon glyphicon-plus"></span> New User', ['create'], ['class' => 'btn btn-success btn-xs']),
        'dataProvider' => $dataProvider,
        'pager' => [
            'class' => yii\widgets\LinkPager::className(),
            'firstPageLabel' => Yii::t('app', 'First'),
            'lastPageLabel' => Yii::t('app', 'Last'),
        ],
        'filterModel' => $searchModel,
        'columns' => [
            [
                'headerOptions' => ['class' => 'tcol-60'],
                'attribute' => 'email',
                'label' => 'Name',
                'format' => 'raw',
                'value' => function (UserSearch $u) {
                    return Html::a((string)$u, ['update', 'id' => $u->id]);
                }
            ],
            [
                'headerOptions' => ['class' => 'tcol-20'],
                'filter' => User::getRoles(),
                'attribute' => 'role',
                'value' => function (UserSearch $u) {
                    return $u->getRole();
                }
            ],
            [
                'headerOptions' => ['class' => 'tcol-10'],
                'filter' => User::getStatuses(),
                'attribute' => 'status_id',
                'value' => function (UserSearch $u) {
                    return $u->getStatus();
                }
            ],
            [
                'headerOptions' => ['class' => 'tcol-10'],
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['nowrap' => 'nowrap', 'class' => 'text-center'],
                'template' => '{delete}'
            ],

        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>



