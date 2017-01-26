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

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user app\models\User */
?>

Hi <?= $user->__toString() ?>,
<br>
<br>
You recently requested a password reset for your <?=Yii::$app->name ?> account. To complete the process, click the link below.
<br>
<?= Html::a('Reset Password', Url::toRoute(['user/reset-password', 'token' => $user->password_reset_token], true)) ?>
<br><br>
This link will expire one hour after this email was sent.
<br><br>
If you didn't make this request, it's likely that another user has entered your email address by mistake and your account is still secure.
If you believe an unauthorized person has accessed your account, you can request a password change at
<?= Html::a('Request a Password Change', Url::toRoute(['user/forgot-password'], true)) ?>
<br>
