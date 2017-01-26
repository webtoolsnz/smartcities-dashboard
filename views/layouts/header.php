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

/**
 * @var \yii\web\View $this
 */

use yii\bootstrap\Nav;
use app\assets\AppAsset;
use yii\helpers\Html;

$appAssets = AppAsset::register($this)

?>

<header class="main-header">
    <!-- Logo -->
    <a href="/" class="logo">
        <!-- mini logo for sidebar mini 40x40 pixels -->
        <span class="logo-mini"><?= Html::img($appAssets->baseUrl.'/img/logo-alt.png', ['alt' => \Yii::$app->name]) ?></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><?= Html::img($appAssets->baseUrl.'/img/logo.png', ['alt' => \Yii::$app->name]) ?></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <?= Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => $this->theme->topMenuItems
            ]); ?>
        </div>

    </nav>
</header>