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
 * This is the base-model class for table "model_history".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $description
 * @property integer $action_id
 * @property string $model
 * @property integer $model_id
 * @property string $attribute
 * @property string $old_value
 * @property string $new_value
 * @property string $created_on
 * @property string $ip_address
 *
 * @property \app\models\User $user
 */
class ModelHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'model_history';
    }

    /**
     *
     */
    public static function label($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Model History} other{Model Histories}}', ['n' => $n]);
    }

    /**
     *
     */
    public function __toString()
    {
        return (string) $this->description;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_on'], 'safe'],
            [['description', 'old_value', 'new_value'], 'string'],
            [['ip_address'], 'string', 'max' => 15],
            [['model', 'attribute'], 'string', 'max' => 255],
            [['user_id', 'action_id', 'model_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'description' => 'Description',
            'action_id' => 'Action',
            'model' => 'Model',
            'model_id' => 'Model',
            'attribute' => 'Attribute',
            'old_value' => 'Old Value',
            'new_value' => 'New Value',
            'created_on' => 'Created On',
            'ip_address' => 'Ip Address',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'user_id']);
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
            'model_history.id' => $this->id,
            'model_history.user_id' => $this->user_id,
            'model_history.action_id' => $this->action_id,
            'model_history.model_id' => $this->model_id,
        ]);

        $query->andFilterWhere(['like', 'model_history.description', $this->description])
            ->andFilterWhere(['like', 'model_history.model', $this->model])
            ->andFilterWhere(['like', 'model_history.attribute', $this->attribute])
            ->andFilterWhere(['like', 'model_history.old_value', $this->old_value])
            ->andFilterWhere(['like', 'model_history.new_value', $this->new_value])
            ->andFilterWhere(['like', 'model_history.created_on', $this->created_on])
            ->andFilterWhere(['like', 'model_history.ip_address', $this->ip_address]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
    }
}

