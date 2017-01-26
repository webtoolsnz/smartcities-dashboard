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


namespace app\modules\admin;

use Yii;
use yii\web\ForbiddenHttpException;
use app\models\User;
use yii\base\Event;
use yii\db\ActiveRecord;
use app\models\ModelHistory;
use app\helpers\FunctionalHelper;
use yii\db\Expression;

/**
 * Class Module
 * @package app\modules\admin
 */
class Module extends \yii\base\Module
{
    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $user = Yii::$app->user->identity; /* @var User $user */

        if (!$user || !in_array($user->role_id, [User::ROLE_MASTER, User::ROLE_EDITOR])) {
            throw new ForbiddenHttpException('Access Denied');
        }

        if ($action->controller->id == "user" && (!$user || !in_array($user->role_id, [User::ROLE_MASTER]))) {
            throw new ForbiddenHttpException('Access Denied');
        }

        $theme = Yii::$app->view->theme;
        $theme->mainMenuItems = $this->getMenuItems($action);
        $theme->topMenuItems = $this->getTopMenuItems($action);

        $afterDbEvent = function($user, $event) {
            $history = new ModelHistory();
            if (get_class($event->sender) == get_class($history)) {
                return;
            }
            $history->user_id = $user->id;
            $history->model = get_class($event->sender);
            $history->model_id = $event->sender->id;
            $was = [];
            $is = [];
            foreach ($event->changedAttributes as $attr => $val) {
                $newVal = $event->sender->$attr;
                $oldVal = $val;
                if ($newVal == $oldVal) {
                    continue;
                }
                $was[$attr] = $oldVal;
                $is[$attr] = $newVal;
            }
            if (count($is) == 0) {
                return;
            }
            $history->attribute = implode(',', array_keys($is));
            if ($event->name == ActiveRecord::EVENT_AFTER_INSERT) {
                $history->action_id = ModelHistory::ACTION_CREATE;
            } else {
                $history->action_id = ModelHistory::ACTION_UPDATE;
                $history->old_value = json_encode($was);
            }
            $history->new_value = json_encode($is);
            $history->created_on = new Expression('NOW()');
            $history->ip_address = $_SERVER['REMOTE_ADDR'];
            $history->save();
        };

        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_UPDATE, FunctionalHelper::curry($afterDbEvent, $user));
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT, FunctionalHelper::curry($afterDbEvent, $user));

        return true;
    }

    /**
     * @param $context
     * @return array
     */
    public function getMenuItems(\yii\base\Action $action)
    {
        if (Yii::$app->user->identity->role_id == User::ROLE_MASTER) {
            $userItem = [
                'icon' => 'fa fa-wrench',
                'label' => 'System',
                'items' => [
                    [
                        'icon' => 'fa fa-users',
                        'label' => 'Users',
                        'url' => ['/admin/user'],
                        'active' => $action->controller->id == 'user',
                    ],
                ]
            ];
        } else {
            $userItem = [];
        }
        return [
            [
                'label' => 'ADMIN NAVIGATION',
            ],
            [
                'icon' => 'fa fa-gears',
                'label' => 'Admin Home',
                'url' => ['/admin/'],
                'active' => $action->controller->id == 'default',
            ],
            [
                'icon' => 'fa fa-dashboard',
                'label' => 'Dashboards',
                'url' => ['/admin/dash'],
                'active' => $action->controller->id == 'dash',
            ],
            [
                'icon' => 'fa fa-window-maximize',
                'label' => 'Gizmos',
                'url' => ['/admin/gizmo'],
                'active' => $action->controller->id == 'gizmo',
            ],
            $userItem,
        ];
    }

    public function getTopMenuItems(\yii\base\Action $action)
    {
        return [
            [
                'label' => '<span class="fa fa-dashboard"></span> Dashboards',
                'url' => ['/'],
                'encode' => false,
            ],
            [
                'label' => '<span class="glyphicon glyphicon-log-out"></span> Logout',
                'url' => ['/logout'],
                'encode' => false,
            ],
        ];
    }
}