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
use app\helpers\FunctionalHelper;

/**
 * This is the model class for table "gizmo".
 */
class Gizmo extends \app\models\base\Gizmo
{
    const HEADER_TYPE_NONE = 0;
    const HEADER_TYPE_NAME = 10;
    const HEADER_TYPE_TABBED = 20;

    private static $_header_types = array(
        self::HEADER_TYPE_NONE => 'None',
        self::HEADER_TYPE_NAME => 'Name',
        self::HEADER_TYPE_TABBED => 'Tabbed',
    );

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

    /**
     * @return mixed
     */
    public function getHeaderType()
    {
        return self::$_header_types[$this->header];
    }

    /**
     * @return array
     */
    public static function getHeaderTypes()
    {
        return self::$_header_types;
    }

    public function getDashes() {
        return $this->hasMany(Dash::className(), ['id' => 'dash_id'])
            ->viaTable('dash_gizmo', ['gizmo_id' => 'id']);
    }

    public function getLink($dashId)
    {
        $filter = function($dashId, $query) {
            return $query->where(['dash_id' => $dashId]);
        };
        return $this->hasOne(Dash::className(), ['id' => 'destination_id'])
            ->viaTable('dash_link', ['gizmo_id' => 'id'], FunctionalHelper::curry($filter, $dashId))->one();
    }

    public function getColourScheme()
    {
        return $this->hasOne(ColourScheme::className(), ['id' => 'colour_scheme_id']);
    }

    public function getWidth() {
        return intval(explode(',', $this->size)[0]);
    }

    public function getHeight() {
        return intval(explode(',', $this->size)[1]);
    }
}
