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

jQuery(function () {
    /**
     * Allows left-side input-addons to react to the focus of the input element.
     */
    $('body').delegate('.input-group .form-control', {
        'focusin' : function () {
            $(this).prev('.input-group-addon').addClass('focus');
        },
        'focusout' : function () {
            $(this).prev('.input-group-addon').removeClass('focus');
        }
    });
});