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


namespace app\helpers;

/**
 * Class FunctionalHelper
 * @package app\helpers
 */
class FunctionalHelper
{
    /**
     * @param $function
     * @param $argument
     * @return function
     */
    public static function curry($function, $argument)
    {
        return function() use ($function, $argument)
        {
            $arguments = func_get_args();
            array_unshift($arguments, $argument);
            return call_user_func_array($function, $arguments);
        };
    }
}