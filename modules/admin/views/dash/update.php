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


use app\models\Dash;

/**
* @var yii\web\View $this
* @var app\models\User $model
*/

$this->title = sprintf('Update Dashboard: %s', $model->__toString());
$this->params['breadcrumbs'][] = ['label' => 'Dashboards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->__toString();
?>
<div class=dash-update">
    <?php echo $this->render('_form', ['model' => $model]); ?>
</div>
