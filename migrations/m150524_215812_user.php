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


use yii\db\Schema;
use yii\db\Migration;

class m150524_215812_user extends Migration
{
    public function safeUp()
    {
        $this->createTable('user', [
            'id'=> $this->primaryKey(11),
            'email'=> $this->string(90)->notNull(),
            'first_name'=> $this->string(90)->notNull(),
            'last_name'=> $this->string(90),
            'auth_key'=> $this->string(32),
            'password_hash'=> $this->string(255),
            'password_reset_token'=> $this->string(255),
            'password_reset_token_created'=> $this->dateTime(),
            'status_id'=> $this->smallInteger(4),
            'created_at'=> $this->dateTime(),
            'updated_at'=> $this->dateTime(),
            'role_id'=> $this->smallInteger(2)->notNull(),
        ], 'ENGINE=InnoDB');

        $this->createIndex('id_UNIQUE', 'user','id',1);
        $this->createIndex('email_UNIQUE', 'user','email',1);
    }

    public function safeDown()
    {
        $this->dropTable('user');
    }
}
