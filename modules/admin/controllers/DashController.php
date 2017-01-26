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


namespace app\modules\admin\controllers;

use app\models\DashGizmo;
use app\models\DashLink;
use app\modules\admin\models\DashSearch;
use yii\web\Controller;
use app\models\Dash;
use webtoolsnz\AdminLte\FlashMessage;
use Yii;
use yii\web\HttpException;


/**
 * Class DashController
 * @package app\modules\admin\controllers
 */
class DashController extends Controller
{
    public function actionIndex()
    {
        $searchModel  = new DashSearch;
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $model = new Dash;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->updateGizmos($model->id);
            $this->updateLinks($model->id);

            Yii::$app->session->setFlash('dash_update', new FlashMessage([
                'type' => FlashMessage::TYPE_SUCCESS,
                'message' => 'Your changes have been saved',
            ]));

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function updateGizmos($id) {
        // Delete all DashGizmos with dash of this one's ID
        DashGizmo::deleteAll(['dash_id' => $id]);
        // Then use DashGizmo POST info to create new DashGimzo models and save them
        if (key_exists('DashGizmo', Yii::$app->request->post())) {
            foreach (Yii::$app->request->post()['DashGizmo'] as $gizmo => $order) {
                $dashGizmo = new DashGizmo();
                $dashGizmo->dash_id = $id;
                $dashGizmo->gizmo_id = $gizmo;
                $dashGizmo->order = $order;
                $dashGizmo->save();
            }
        }
    }

    public function updateLinks($id) {
        // Delete all DashLinks with dash of this one's ID
        DashLink::deleteAll(['dash_id' => $id]);
        // Then use DashLink POST info to create new DashLink models and save them
        if (key_exists('DashLink', Yii::$app->request->post())) {
            foreach (Yii::$app->request->post()['DashLink'] as $gizmo => $link) {
                if ($link == "0") {
                    continue;
                }
                $dashLink = new DashLink();
                $dashLink->dash_id = $id;
                $dashLink->gizmo_id = $gizmo;
                $dashLink->destination_id = $link;
                $dashLink->save();
            }
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->updateGizmos($id);
            $this->updateLinks($id);

            Yii::$app->session->setFlash('dash_update', new FlashMessage([
                'type' => FlashMessage::TYPE_SUCCESS,
                'message' => 'Your changes have been saved',
            ]));

            return $this->redirect(['update', 'id' => $id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Dash::STATUS_DELETED;
        $model->save();

        Yii::$app->session->setFlash('dash_delete', new FlashMessage([
            'type' => FlashMessage::TYPE_SUCCESS,
            'message' => sprintf('Dashboard "%s" has been deactivated', (string)$model)
        ]));

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Dash::findOne($id)) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }
}
