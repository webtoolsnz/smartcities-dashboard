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
            <div class="user">
                <div class="avatar"><?= Html::img($appAssets->baseUrl.'/img/avatar.png', ['alt' => \Yii::$app->name]) ?></div>
                <div class="info">
                    <span class="name"><?= Yii::$app->user->identity ?></span>
                    <span class="status"><?= Html::img($appAssets->baseUrl.'/img/online.png', ['alt' => \Yii::$app->name]) ?> Online</span>
                </div>
            </div>
            <form class="navbar-form" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" id="navbar-search-input" placeholder="Search…">
                </div>
            </form>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu"><li class="header">MAIN NAVIGATION</li>
                <li class="active treeview"><a href="/admin"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                <li class="treeview"><a href="#"><i class="fa fa-dollar"></i> <span>Economy</span>  <i class="fa fa-angle-left pull-right"></i></a>
                <li class="treeview"><a href="#"><i class="fa fa-umbrella"></i> <span>Weather</span>  <i class="fa fa-angle-left pull-right"></i></a>
                <li class="treeview"><a href="#"><i class="fa fa-car"></i> <span>Transport</span>  <i class="fa fa-angle-left pull-right"></i></a>
                <li class="treeview"><a href="#"><i class="fa fa-leaf"></i> <span>Environmental</span>  <i class="fa fa-angle-left pull-right"></i></a>
                <li class="treeview"><a href="#"><i class="fa fa-music"></i> <span>Events</span>  <i class="fa fa-angle-left pull-right"></i></a>
                <li class="treeview"><a href="#"><i class="fa fa-map"></i> <span>Tourism</span>  <i class="fa fa-angle-left pull-right"></i></a>
                <li class="treeview"><a href="#"><i class="fa fa-heartbeat"></i> <span>Health</span>  <i class="fa fa-angle-left pull-right"></i></a>
                <li class="treeview"><a href="#"><i class="fa fa-thumbs-up"></i> <span>Societal</span>  <i class="fa fa-angle-left pull-right"></i></a>
        </section>
        <!-- /.sidebar -->
    </aside>    <!-- Sidebar End -->

    <div class="content-wrapper">
        <!-- Content Header Begin -->

        <section class="content-header">
            <h1>Christchurch City Council Team Dashboard</h1>
            <ul class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">UI</a></li>
                <li><a href="#">General</a></li>
            </ul>
        </section>        <!-- Content Header End -->

        <!-- Content Begin -->
        <section class="content">

            <div class="site-index">
                <div class="row">
                    <!-- <div class="col-lg-7 infobox weather topline">
                        <div class="header">
                            <i class="fa fa-umbrella"></i> Weather
                        </div>

                        <div class="footer">
                            More Info <i class="fa fa-arrow-circle-right"></i>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        Roadworks
                    </div> -->
                    <div class="col-lg-7 mockbox">
                        <?= Html::img($appAssets->baseUrl.'/img/mock/weather.png', ['alt' => \Yii::$app->name]) ?>
                    </div>
                    <div class="col-lg-5 mockbox">
                        <?= Html::img($appAssets->baseUrl.'/img/mock/roadworks.png', ['alt' => \Yii::$app->name]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 mockwrapper">
                        <div class="col-lg-12 mockbox">
                            <?= Html::img($appAssets->baseUrl.'/img/mock/events.png', ['alt' => \Yii::$app->name]) ?>
                        </div>
                        <div class="col-lg-6 mockbox">
                            <?= Html::img($appAssets->baseUrl.'/img/mock/dogs.png', ['alt' => \Yii::$app->name]) ?>
                        </div>
                        <div class="col-lg-6 mockbox">
                            <?= Html::img($appAssets->baseUrl.'/img/mock/cats.png', ['alt' => \Yii::$app->name]) ?>
                        </div>
                        <div class="col-lg-12 mockbox">
                            <?= Html::img($appAssets->baseUrl.'/img/mock/transport.png', ['alt' => \Yii::$app->name]) ?>
                        </div>
                    </div>
                    <div class="col-lg-6 mockwrapper">
                        <div class="col-lg-6 mockbox">
                            <?= Html::img($appAssets->baseUrl.'/img/mock/building.png', ['alt' => \Yii::$app->name]) ?>
                        </div>
                        <div class="col-lg-6 mockbox">
                            <?= Html::img($appAssets->baseUrl.'/img/mock/resource.png', ['alt' => \Yii::$app->name]) ?>
                        </div>
                        <div class="col-lg-12 mockbox">
                            <?= Html::img($appAssets->baseUrl.'/img/mock/environment.png', ['alt' => \Yii::$app->name]) ?>
                        </div>
                    </div>
                </div>

            </div>
        </section>        <!-- Content End -->
    </div>
