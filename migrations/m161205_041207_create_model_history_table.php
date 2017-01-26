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
 * Handles the creation of table `model_history`.
 */
class m161205_041207_create_model_history_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('model_history', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'description' => $this->text(),
            'action_id' => $this->integer(11),
            'model' => $this->string(255),
            'model_id' => $this->integer(11),
            'attribute' => $this->string(255),
            'old_value' => $this->text(),
            'new_value' => $this->text(),
            'created_on' => $this->dateTime(),
            'ip_address' => $this->string(15),
        ]);

        $this->createIndex(
            'fk_model_history-user_idx',
            'model_history',
            'user_id');

        $this->addForeignKey(
            'fk-model_history-user',
            'model_history',
            'user_id',
            'user',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-model_history-user');

        $this->dropIndex('fk_model_history-user_idx', 'model_history');

        $this->dropTable('model_history');
    }
}
