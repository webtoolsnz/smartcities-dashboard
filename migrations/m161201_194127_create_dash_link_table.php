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
 * Handles the creation of table `dash_link`.
 */
class m161201_194127_create_dash_link_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('dash_link', [
            'id' => $this->primaryKey(),
            'gizmo_id' => $this->integer(),
            'dash_id' => $this->integer(),
            'destination_id' => $this->integer(),
        ]);

        $this->createIndex(
            'fk_dash_idx',
            'dash_link',
            'dash_id'
        );

        $this->addForeignKey(
            'fk-dash_link-dash',
            'dash_link',
            'dash_id',
            'dash',
            'id',
            'NO ACTION',
            'CASCADE'
        );

        $this->createIndex(
            'fk_gizmo_idx',
            'dash_link',
            'gizmo_id'
        );

        $this->addForeignKey(
            'fk-dash_link-gizmo',
            'dash_link',
            'gizmo_id',
            'gizmo',
            'id',
            'NO ACTION',
            'CASCADE'
        );

        $this->createIndex(
            'fk_destination_idx',
            'dash_link',
            'destination_id'
        );

        $this->addForeignKey(
            'fk-dash_link-destination',
            'dash_link',
            'destination_id',
            'dash',
            'id',
            'NO ACTION',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-dash_link-destination',
            'dash_link'
        );

        $this->dropIndex(
            'fk_destination_idx',
            'dash_link'
        );

        $this->dropForeignKey(
            'fk-dash_link-gizmo',
            'dash_link'
        );

        $this->dropIndex(
            'fk_gizmo_idx',
            'dash_link'
        );

        $this->dropForeignKey(
            'fk-dash_link-dash',
            'dash_link'
        );

        $this->dropIndex(
            'fk_dash_idx',
            'dash_link'
        );

        $this->dropTable('dash_link');
    }
}
