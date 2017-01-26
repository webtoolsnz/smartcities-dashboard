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


/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use app\assets\ChartAsset;
use app\assets\MustacheAsset;
use webtoolsnz\widgets\BootBoxAsset;
use yii\helpers\Url;
use app\models\User;

$appAssets = AppAsset::register($this);
$chartAssets = ChartAsset::register($this);
$mustacheAssets = MustacheAsset::register($this);
$bootBoxAssets = BootBoxAsset::register($this);

$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key='.Yii::$app->params['google.api.key']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-black-light sidebar-mini sidebar-collapse module-<?= $this->context->module->id ?>">

<?php $this->beginBody() ?>
<div class="wrapper">

    <!-- Header Begin -->

    <header class="main-header">
        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 40x40 pixels -->
            <span class="logo-mini"><?= Html::img($appAssets->baseUrl.'/img/logo-alt.png', ['alt' => \Yii::$app->name]) ?></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><?= Html::img($appAssets->baseUrl.'/img/logo-alt.png', ['alt' => \Yii::$app->name]) ?> Smart Cities Dashboard</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-fixed-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul id="w2" class="navbar-nav nav">
                    <?php foreach ($this->theme->topMenuItems as $item): ?>
                        <li><a href="<?= Url::to($item['url']) ?>"><?= $item['label'] ?></a></li>
                    <?php endforeach ?>
                    <li><a href="#"><span class="name"><?= Yii::$app->user->identity ?></span></a></li>
                    <?php if (Yii::$app->user->identity && Yii::$app->user->identity->role_id !== User::ROLE_VIEWER) { ?>
                    <li><a href="/admin"><i class="fa fa-gears"></i></a></li>
                    <?php } ?>
                </ul>
            </div>

        </nav>
    </header>
            <?= $content ?>
    <footer>
        Source code available from <a href="https://github.com/webtoolsnz/smartcities-dashboard/">https://github.com/webtoolsnz/smartcities-dashboard/</a>. Certain icons designed by EpicCoders from Flaticon.
    </footer>
</div>

<?php $this->endBody() ?>
<script>
    dm = new DashManager('<?= Url::to(['/api'], true); ?>');
    dm.load();
</script>
</body>
</html>
<?php $this->endPage() ?>
