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


namespace app\models;

use Yii;

/**
 * This is the model class for table "model_history".
 */
class ModelHistory extends \app\models\base\ModelHistory
{
    const ACTION_CREATE = 10;
    const ACTION_UPDATE = 20;

    private static $_actions = [
        self::ACTION_CREATE => 'Created',
        self::ACTION_UPDATE => 'Updated',
    ];

    public static function getActions()
    {
        return self::$_actions;
    }
}
