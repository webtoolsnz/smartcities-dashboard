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
use app\assets\AppAsset;

$appAssets = AppAsset::register($this);

/* @var $this yii\web\View */
$this->title = 'Christchurch City Dashboard';
?>
<!-- Sidebar Begin -->
<aside class="main-sidebar">

    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu"><li class="header">DASHBOARDS</li>
            <?php foreach ($dashes as $dash): /* @var $dash Dash */ ?>
                <?php echo Yii::$app->controller->renderPartial('sidebar/dash', array('dash' => $dash)); ?>
            <?php endforeach /* $dash */ ?>
    </section>
    <!-- /.sidebar -->
</aside>    <!-- Sidebar End -->

<div class="content-wrapper">
    <!-- Content Header Begin -->

    <section class="content-header">
        <h1>Christchurch City Council Team Dashboard</h1>
        <ul class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Dashboards</a></li>
            <li><a href="#">General</a></li>
        </ul>
    </section>        <!-- Content Header End -->

    <!-- Content Begin -->
    <section class="content">

        <div class="site-index">
            Choose a dashboard from the list on the left

        </div>
    </section>        <!-- Content End -->
</div>
