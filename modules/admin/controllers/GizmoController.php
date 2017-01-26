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

use app\modules\admin\models\GizmoSearch;
use yii\web\Controller;
use app\models\Gizmo;
use webtoolsnz\AdminLte\FlashMessage;
use Yii;
use yii\web\HttpException;


/**
 * Class GizmoController
 * @package app\modules\admin\controllers
 */
class GizmoController extends Controller
{
    public function actionIndex()
    {
        $searchModel  = new GizmoSearch;
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $model = new Gizmo;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('gizmo_update', new FlashMessage([
                'type' => FlashMessage::TYPE_SUCCESS,
                'message' => 'Your changes have been saved',
            ]));

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('gizmo_update', new FlashMessage([
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
        $model->status = Gizmo::STATUS_DELETED;
        $model->save();

        Yii::$app->session->setFlash('gizmo_delete', new FlashMessage([
            'type' => FlashMessage::TYPE_SUCCESS,
            'message' => sprintf('Gizmo "%s" has been deactivated', (string)$model)
        ]));

        return $this->redirect(['index']);
    }

    public function actionInfo($id)
    {
        $model = $this->findModel($id);

        $modelInfo = [
            "name" => $model->name,
            "description" => $model->description,
            "slug" => $model->slug,
            "icon" => $model->icon,
            "colour_scheme" => $model->colourScheme->name
        ];

        return json_encode($modelInfo);
    }

    protected function findModel($id)
    {
        if (($model = Gizmo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }
}
