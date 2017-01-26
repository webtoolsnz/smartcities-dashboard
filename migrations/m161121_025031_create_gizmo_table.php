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
 * Handles the creation of table `gizmo`.
 */
class m161121_025031_create_gizmo_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('gizmo', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'slug' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'icon' => $this->string(255),
            'header' => $this->integer(4),
            'size' => $this->string(255),
            'colour_scheme_id' => $this->integer(),
            'image' => $this->string(255),
            'status' => $this->integer(2),
            'template' => $this->text(),
        ]);

        $this->createIndex(
            'fk_colour_scheme_idx',
            'gizmo',
            'colour_scheme_id'
        );

        $this->addForeignKey(
            'fk-gizmo-colour_scheme',
            'gizmo',
            'colour_scheme_id',
            'colour_scheme',
            'id',
            'NO ACTION'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-gizmo-colour_scheme',
            'gizmo'
        );

        $this->dropIndex(
            'fk_colour_scheme_idx',
            'gizmo'
        );

        $this->dropTable('gizmo');
    }
}
