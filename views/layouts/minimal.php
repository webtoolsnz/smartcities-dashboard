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

$appAssets = AppAsset::register($this);
$chartAssets = ChartAsset::register($this);
$mustacheAssets = MustacheAsset::register($this);
$bootBoxAssets = BootBoxAsset::register($this);

$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key='.Yii::$app->params['google.api.key']);

if (class_exists('yii\debug\Module')) {
    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
}

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
    <style>
        .content,
        .skin-black-light .content-wrapper,
        .site-index,
        .gizmo-group {
            margin: 0;
            padding: 0;
            border: none;
        }
        .gizmo,
        .gizmo:hover {
            transform: none;
            box-shadow: none;
        }
    </style>
</head>
<body style="overflow:hidden" class="hold-transition skin-black-light sidebar-mini sidebar-collapse module-<?= $this->context->module->id ?>">

<?php $this->beginBody() ?>
    <?= $content ?>
<?php $this->endBody() ?>
<script>
    dm = new DashManager('<?= Url::to(['/api'], true); ?>');
    dm.load();
</script>
</body>
</html>
<?php $this->endPage() ?>
