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
/* @var $gizmo \app\models\Gizmo */

use \app\models\Gizmo;

use app\assets\AppAsset;
use yii\helpers\Html;

$appAssets = AppAsset::register($this)
?>

<?php if (!empty($gizmo->size)) {
    $widthClass = $gizmo->width;
} else {
    $widthClass = 6;
} ?>

<?php if (!empty($gizmo->size)) {
    $heightClass = $gizmo->height;
} else {
    $heightClass = 4;
} ?>

<?php

$gizmoTemplate = $gizmo->template;
$gizmoTemplate = preg_replace('/@assets/', $appAssets->baseUrl, $gizmoTemplate);

$dashLink = $gizmo->getLink($dash->id);
$openLink = empty($dashLink) ? '' : '<a data-dash="' . $dashLink->name .'"href="/dash/' . $dashLink->slug . '">';
$closeLink = empty($dashLink) ? '' : '</a>';
?>


<?php if ($gizmo->header == Gizmo::HEADER_TYPE_NONE) { ?>
    <div id="gizmo-<?= $gizmo->slug ?>" class="gizmo width<?= $widthClass ?> info-box <?= $gizmo->colourScheme->name ?>">
        <?= $openLink ?>
        <span class="info-box-icon">
            <?php if (empty($gizmo->image)) { ?>
                <?php if (!empty($gizmo->icon)) { ?>
                    <i class="fa fa-<?= $gizmo->icon ?>"></i>
                <?php } ?>
            <?php } else { ?>
                <?= Html::img($appAssets->baseUrl.'/img/icons/' . $gizmo->image, ['alt' => $gizmo->name]) ?>
            <?php } ?>
        </span>
        <div class="gizmo-body info-box-content">
            <span class="info-box-text"><?= $gizmo->name ?></span>
            <?= $gizmoTemplate ?>
        </div>
        <div class="overlay">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
        <?= $closeLink ?>
    </div>
<?php } elseif ($gizmo->header == Gizmo::HEADER_TYPE_NAME) { ?>
    <div id="gizmo-<?= $gizmo->slug ?>" class="gizmo box width<?= $widthClass ?> height<?= $heightClass ?> <?= $gizmo->colourScheme->name ?>">
        <?= $openLink ?>
            <div class="box-header with-border">
                <h3 class="box-title">
                    <?php if (!empty($gizmo->icon)) { ?>
                        <i class="fa fa-<?= $gizmo->icon ?>"></i>
                    <?php } ?>
                    <?php echo $gizmo->name ?>
                </h3>
            </div>
        <div class="gizmo-body box-body">
            <?= $gizmoTemplate ?>
        </div>
        <div class="overlay">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
        <?= $closeLink ?>
    </div>
<?php } elseif ($gizmo->header == Gizmo::HEADER_TYPE_TABBED) { ?>
    <div id="gizmo-<?= $gizmo->slug ?>" class="gizmo nav-tabs-custom width<?= $widthClass ?> height<?= $heightClass ?> <?= $gizmo->colourScheme->name ?>">
        <?= $openLink ?>
        <?php
        $transformedTemplate = $gizmoTemplate;
        $tabList = '<ul class="nav nav-tabs pull-right">';
        if (preg_match_all('/<tab>|<tab [^>]*>/i', $transformedTemplate, $matches)) {
            $i = 0;
            foreach ($matches[0] as $match) {
                if (preg_match('/name="([^"]+)"/i', $match, $nameMatch)) {
                    $tabLabel = $nameMatch[1];
                } elseif (preg_match('/image="([^"]+)"/i', $match, $imageMatch)) {
                    $tabLabel = Html::img($appAssets->baseUrl.'/img/icons/' . $imageMatch[1], ['alt' => $gizmo->name]);
                } elseif (preg_match('/icon="([^"]+)"/i', $match, $iconMatch)) {
                    $tabLabel = '<i class="fa fa-' . $iconMatch[1] . '"></i>';
                } else {
                    $tabLabel = 'Tab';
                }
                $activeClass = ($i == 0) ? 'active' : '';
                if (preg_match('/scroll="yes"/i', $match)) {
                    $activeClass .= ' vertical-scroll';
                }
                $tabId = $gizmo->slug . '_tab_' . $i;
                $tabList .= '<li class="' . $activeClass . '"><a href="#' . $tabId . '" data-toggle="tab">' . $tabLabel . '</a></li>';
                $transformedTemplate = preg_replace('/<tab>|<tab ([^>]*)>/i', '<div class="tab-pane ' . $activeClass . '" id="' . $tabId .'">', $transformedTemplate, 1);
                $i++;
            }
        }
        $transformedTemplate = preg_replace('@</tab>@i', '</div>', $transformedTemplate);
        $icon = empty($gizmo->icon) ? '' : '<i class="fa fa-' . $gizmo->icon . '"></i>';
        $name = $gizmo->name;
        $tabList .= "<li class=\"pull-left header\">$icon$name</li></ul>";
        ?>
        <?= $tabList ?>
        <div class="tab-content gizmo-body">
            <?= $transformedTemplate ?>
        </div>
        <div class="overlay">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
        <?= $closeLink ?>
    </div>
<?php } ?>
