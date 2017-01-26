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
$this->title = 'Smart Cities Dashboard Admin';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome, <?=Yii::$app->user->identity ?></h1>
        <p class="lead">This is the admin module. Create and update Dashboards and Gizmos.</p>
    </div>
</div>
