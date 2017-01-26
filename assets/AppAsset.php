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


namespace app\assets;

use yii\web\AssetBundle;

/**
 * Class AppAsset
 * @package app\assets
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/assets';

    /**
     * @var array
     */
    public $css = [
        'css/gizmo.css',
        'css/gizmo-colour.css',
        'css/admin.css',
        'css/overrides.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'js/bootstrap-input-addon-focus.js',
        'js/app-manager.js',
        'js/dash-manager.js'
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'webtoolsnz\AdminLte\AdminLteAsset',
        'codezeen\yii2\fastclick\FastClickAsset',
    ];

    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => true
    ];
}
