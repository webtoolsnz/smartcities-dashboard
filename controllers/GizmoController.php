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


namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Dash;
use app\models\Gizmo;
use app\models\DashGizmo;
use yii\web\HttpException;

/**
 * Class GizmoController
 * @package app\controllers
 */
class GizmoController extends Controller
{
    /**
     * @var string
     */
    public $layout = 'minimal';

    public function actions()
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }

    public function actionPreview($id)
    {
        $user = Yii::$app->user;

        $gizmo = Gizmo::find()->where(['id' => $id])->one();

        $holderDash = new Dash();

        return $this->render('preview', ['user' => $user, 'gizmo' => $gizmo, 'currentDash' => $holderDash]);
    }
}
