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


use yii\db\Migration;

class m161122_235350_gizmo_class extends Migration
{

    public function up()
    {
        $this->addColumn(
            'gizmo',
            'report_class',
            $this->string()
        );
        // allow only one gizmo per class for now
        $this->createIndex(
            'gizmo_report_class',
            'gizmo',
            'report_class',
            true
        );
    }

    public function down()
    {
        $this->dropColumn(
            'gizmo',
            'report_class'
        );
    }

}
