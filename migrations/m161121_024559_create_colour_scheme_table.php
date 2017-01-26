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

/**
 * Handles the creation of table `colour_scheme`.
 */
class m161121_024559_create_colour_scheme_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('colour_scheme', [
            'id' => $this->primaryKey(),
            'name' => $this->string(45)->notNull(),
            'main' => $this->string(45),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('colour_scheme');
    }
}
