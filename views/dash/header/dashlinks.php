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

if ($currentDash->slug !== 'overview') { ?>

<div id="dashlinks">
	<div class="gizmo width2 info-box blue <?= $currentDash->slug == 'city-services' ? 'current' : '' ?>">
		<a data-dash="City Services" href="/dash/city-services">
			<div class="gizmo-body info-box-content">
				<span class="info-box-text">City Services</span>
			</div>
		</a>
	</div>

	<div class="gizmo width2 info-box purple <?= $currentDash->slug == 'customer-community' ? 'current' : '' ?>">
		<a data-dash="Customer & Community" href="/dash/customer-community">
			<div class="gizmo-body info-box-content">
				<span class="info-box-text">Customer & Community</span>
			</div>
		</a>
	</div>

	<div class="gizmo width2 info-box red <?= $currentDash->slug == 'consenting-compliance' ? 'current' : '' ?>">
		<a data-dash="Consenting & Compliance" href="/dash/consenting-compliance">
			<div class="gizmo-body info-box-content">
				<span class="info-box-text">Consenting & Compliance</span>
			</div>
		</a>
	</div>

	<div class="gizmo width2 info-box orange <?= $currentDash->slug == 'finance-commercial' ? 'current' : '' ?>">
		<a data-dash="Finance & Commercial" href="/dash/finance-commercial">
			<div class="gizmo-body info-box-content">
				<span class="info-box-text">Finance & Commercial</span>
			</div>
		</a>
	</div>

	<div class="gizmo width2 info-box pink <?= $currentDash->slug == 'corporate-services' ? 'current' : '' ?>">
		<a data-dash="Corporate Services" href="/dash/corporate-services">
			<div class="gizmo-body info-box-content">
				<span class="info-box-text">Corporate Services</span>
			</div>
		</a>
	</div>

	<div class="gizmo width2 info-box green <?= $currentDash->slug == 'strategy-transformation' ? 'current' : '' ?>">
		<a data-dash="Strategy & Transformation" href="/dash/strategy-transformation">
			<div class="gizmo-body info-box-content">
				<span class="info-box-text">Strategy & Transformation</span>
			</div>
		</a>
	</div>
</div>

<?php } ?>
