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
 * This is the base-model class for table "dash".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property string $icon
 * @property integer $status
 *
 * @property \app\models\DashGizmo[] $dashGizmos
 */
class Dash extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dash';
    }

    /**
     *
     */
    public static function label($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Dash} other{Dashes}}', ['n' => $n]);
    }

    /**
     *
     */
    public function __toString()
    {
        return (string) $this->name;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['slug', 'icon'], 'string', 'max' => 45],
            [['status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'slug' => 'Slug',
            'icon' => 'Icon',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDashGizmos()
    {
        return $this->hasMany(\app\models\DashGizmo::className(), ['dash_id' => 'id']);
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
            'dash.id' => $this->id,
            'dash.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'dash.name', $this->name])
            ->andFilterWhere(['like', 'dash.description', $this->description])
            ->andFilterWhere(['like', 'dash.slug', $this->slug])
            ->andFilterWhere(['like', 'dash.icon', $this->icon]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
    }
}

