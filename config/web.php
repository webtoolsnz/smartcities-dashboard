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
use \webtoolsnz\AdminLte\Theme as AdminLteTheme;

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'smartcities-dashboard',
    'name' => 'Smart Cities Dashboard',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'requireLogin'],
    'modules' => [
        'admin'=>['class' => 'app\modules\admin\Module'],
        'api'=>['class' => 'app\modules\api\Module'],
        'data'=>['class' => 'app\modules\data\Module'],
    ],
    'aliases' => [
        '@admin' => '@app/modules/admin',
        '@api' => '@app/modules/api',
    ],
    'components' => [
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                    ]
                ]
            ],
        ],
        'requireLogin' => [
            'class' => 'webtoolsnz\RequireLogin\Component',
            'exceptions' => ArrayHelper::merge(\webtoolsnz\RequireLogin\Component::$exceptions, [
                'api/kite'
            ])
        ],
        'request' => [
            'cookieValidationKey' => 'K148Fr5LMIdMabPOwhV-wz5Hd-L5Vyom',
        ],
        'view' => [
            'theme' => [
                'class' => AdminLteTheme::className(),
                'skin' => AdminLteTheme::SKIN_BLACK_LIGHT,
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'fileMode' => 0777,
            'dirMode' => 0777,
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'autoRenewCookie' => true,
            'loginUrl' => '/user/login',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'fileMode' => 0777,
                    'dirMode' => 0777,
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'login' => 'user/login',
                'logout' => 'user/logout',
                'dash/<slug:[-\w]+>' => 'dash/view',
            ]
        ],
        'formatter' => [
            'dateFormat' => 'dd/MM/yyyy',
            'timeFormat' => 'short',
            'defaultTimeZone' => 'Pacific/Auckland',
            'datetimeFormat' => 'dd/MM/yyyy HH:mm aa',
        ],
    ],
    'params' => $params,
];


$envConfigPath = __DIR__.'/'.YII_ENV.'/web.php';

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

