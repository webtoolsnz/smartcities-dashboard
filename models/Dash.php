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
 * This is the model class for table "dash".
 */
class Dash extends \app\models\base\Dash
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    private static $_statuses = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_DELETED => 'Inactive',
    ];

    public static function getStatuses()
    {
        return self::$_statuses;
    }

    public function getGizmos()
    {
        return $this->hasMany(Gizmo::className(), ['id' => 'gizmo_id'])->viaTable('dash_gizmo', ['dash_id' => 'id']);
    }

    public function getDashGizmos()
    {
        return $this->hasMany(DashGizmo::className(), ['dash_id' => 'id'])->with('gizmo')->orderBy('order ASC');
    }
}
