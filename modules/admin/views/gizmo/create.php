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


use app\models\Gizmo;

/**
* @var yii\web\View $this
* @var app\models\Gizmo $model
*/

$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = ['label' => 'Gizmos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gizmo-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
