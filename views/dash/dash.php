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
                <?php echo Yii::$app->controller->renderPartial('sidebar/dash', array('dash' => $dash, 'currentDash' => $currentDash)); ?>
            <?php endforeach /* $dash */ ?>
    </section>
    <!-- /.sidebar -->
</aside>    <!-- Sidebar End -->

<div class="content-wrapper">
    <!-- Content Header Begin -->

    <section class="content-header">
        <?php
            $dashLinkSlugs = [
                'overview',
                'city-services',
                'customer-community',
                'consenting-compliance',
                'finance-commercial',
                'corporate-services',
                'strategy-transformation'
            ];
        ?>
        <h1 class="<?= in_array($currentDash->slug, $dashLinkSlugs) ? 'active' : ''; ?>"><?= $currentDash->name; ?></h1>
        <ul class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/dash">Dashboards</a></li>
            <li><a href="/dash/<?= $currentDash->slug; ?>"><?= $currentDash->name; ?></a></li>
        </ul>
    </section>        <!-- Content Header End -->

    <!-- Content Begin -->
    <section class="content">

        <?php if (in_array($currentDash->slug, $dashLinkSlugs)) { echo Yii::$app->controller->renderPartial('header/dashlinks', array('dash' => $dash, 'currentDash' => $currentDash)); } ?>

        <div class="site-index">
            <?php
            $position = 0;
            $gizmoGroups = [];
            $workingGroup = [];
            // Group gizmos into groups of (at most) 6 width units
            foreach ($currentDash->dashGizmos as $dashGizmo) {
                $gizmo = $dashGizmo->gizmo;
                $position += $gizmo->width;
                if ($position > 6) { // too full; add the current group and start a new one
                    $gizmoGroups[] = $workingGroup;
                    $workingGroup = [$gizmo];
                    $position = $gizmo->width;
                } elseif ($position == 6) { // full; add the current group and start an empty one
                    $workingGroup[] = $gizmo;
                    $gizmoGroups[] = $workingGroup;
                    $workingGroup = [];
                    $position = 0;
                } else { // not full yet; just add the gizmo
                    $workingGroup[] = $gizmo;
                }
            }
            $gizmoGroups[] = $workingGroup;
            ?>
            <?php foreach ($gizmoGroups as $gizmoGroup): ?>
                <div class="gizmo-group col-md-6">
                <?php foreach ($gizmoGroup as $gizmo): ?>
                <?= $this->render('/gizmo/index', ['dash' => $currentDash, 'gizmo' => $gizmo]); ?>
                <?php endforeach ?>
                </div>
            <?php endforeach ?>
        </div>
    </section>        <!-- Content End -->
</div>
