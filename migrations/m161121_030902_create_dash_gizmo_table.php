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
 * Handles the creation of table `dash_gizmo`.
 */
class m161121_030902_create_dash_gizmo_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('dash_gizmo', [
            'id' => $this->primaryKey(),
            'dash_id' => $this->integer(),
            'gizmo_id' => $this->integer(),
            'order' => $this->integer(),
        ]);

        $this->createIndex(
            'fk_dash_idx',
            'dash_gizmo',
            'dash_id'
        );

        $this->addForeignKey(
            'fk_dash',
            'dash_gizmo',
            'dash_id',
            'dash',
            'id',
            'NO ACTION',
            'CASCADE'
        );

        $this->createIndex(
            'fk_gizmo_idx',
            'dash_gizmo',
            'gizmo_id'
        );

        $this->addForeignKey(
            'fk_gizmo',
            'dash_gizmo',
            'gizmo_id',
            'gizmo',
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
            'fk_gizmo',
            'dash_gizmo'
        );

        $this->dropIndex(
            'fk_gizmo_idx',
            'dash_gizmo'
        );

        $this->dropForeignKey(
            'fk_dash',
            'dash_gizmo'
        );

        $this->dropIndex(
            'fk_dash_idx',
            'dash_gizmo'
        );

        $this->dropTable('dash_gizmo');
    }
}
