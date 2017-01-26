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


namespace app\models\base;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the base-model class for table "dash_gizmo".
 *
 * @property integer $id
 * @property integer $dash_id
 * @property integer $gizmo_id
 * @property integer $order
 *
 * @property \app\models\Dash $dash
 * @property \app\models\Gizmo $gizmo
 */
class DashGizmo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dash_gizmo';
    }

    /**
     *
     */
    public static function label($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Dash Gizmo} other{Dash Gizmos}}', ['n' => $n]);
    }

    /**
     *
     */
    public function __toString()
    {
        return (string) $this->id;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dash_id', 'gizmo_id', 'order'], 'integer'],
            [['dash_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dash::className(), 'targetAttribute' => ['dash_id' => 'id']],
            [['gizmo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gizmo::className(), 'targetAttribute' => ['gizmo_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dash_id' => 'Dash',
            'gizmo_id' => 'Gizmo',
            'order' => 'Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDash()
    {
        return $this->hasOne(\app\models\Dash::className(), ['id' => 'dash_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGizmo()
    {
        return $this->hasOne(\app\models\Gizmo::className(), ['id' => 'gizmo_id']);
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params = null)
    {
        $query = self::find();

        if ($params === null) {
            $params = array_filter(Yii::$app->request->get($this->formName(), array()));
        }

        $this->attributes = $params;

        $query->andFilterWhere([
            'dash_gizmo.id' => $this->id,
            'dash_gizmo.dash_id' => $this->dash_id,
            'dash_gizmo.gizmo_id' => $this->gizmo_id,
            'dash_gizmo.order' => $this->order,
        ]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
    }
}

