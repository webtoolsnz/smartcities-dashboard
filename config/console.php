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


use \yii\base\InvalidConfigException;
use \yii\helpers\ArrayHelper;

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');

$config =  [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'fileMode' => 0777,
            'dirMode' => 0777,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'fileMode' => 0777,
                    'dirMode' => 0777,
                ],
            ],
        ],
    ],
    'params' => $params,
];


$envConfigPath = __DIR__.'/'.YII_ENV.'/console.php';

if (!file_exists($envConfigPath)) {
    throw new InvalidConfigException('Environment not properly configured.');
}

$envConfig = require($envConfigPath);

$configOverride = [];
$configOverridePath = __DIR__.'/../environment.config.php';
if (file_exists($configOverridePath)) {
    $configOverride = require($configOverridePath);
}

return ArrayHelper::merge($config, $envConfig, $configOverride);
