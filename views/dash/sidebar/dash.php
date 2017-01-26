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
 ?>

<li class="treeview<?= (isset($currentDash) && ($currentDash->id == $dash->id)) ? " active" : ""; ?>">
    <a href="/dash/<?= $dash->slug ?>">
        <?php if (empty($dash->icon)) { ?>
            <i class="fa fa-dashboard"></i>
        <?php } else { ?>
            <i class="fa fa-<?= $dash->icon ?>"></i>
        <?php } ?>
        <span><?= $dash->name ?></span>
    </a>
</li>
