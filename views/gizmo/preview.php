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

$this->title = 'Christchurch City Dashboard';
?>

<div class="content-wrapper" style="margin-left: 0 !important;">

    <!-- Content Begin -->
    <section class="content">

        <div class="site-index">
            <div class="gizmo-group col-md-6">
                <?= $this->render('/gizmo/index', ['dash' => $currentDash, 'gizmo' => $gizmo]); ?>
            </div>
        </div>
    </section>        <!-- Content End -->
</div>
