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

class MustacheAsset extends \yii\web\AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/bower/mustache.js';

    /**
     * @var array
     */
    public $js = [
        'mustache.min.js'
    ];
}
