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
use app\models\User;

class m150524_220222_master_user extends Migration
{
    public function safeUp()
    {
        $this->insert('user', [
            'email' => 'master@example.com',
            'first_name' => 'master',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('master'),
            'status_id' => User::STATUS_ACTIVE,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'role_id' => User::ROLE_MASTER,
        ]);
    }

    public function safeDown()
    {
        $this->delete('user', ['email' => 'master@example.com']);
    }
}
