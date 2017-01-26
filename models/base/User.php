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
 * This is the base-model class for table "user".
 *
 * @property integer $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $password_reset_token_created
 * @property integer $status_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $role_id
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     *
     */
    public static function label($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{User} other{Users}}', ['n' => $n]);
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
            [['auth_key'], 'string', 'max' => 32],
            [['email', 'first_name', 'last_name'], 'string', 'max' => 90],
            [['email', 'first_name', 'role_id'], 'required'],
            [['email'], 'unique'],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['password_reset_token_created', 'created_at', 'updated_at'], 'safe'],
            [['status_id', 'role_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'password_reset_token_created' => 'Password Reset Token Created',
            'status_id' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'role_id' => 'Role',
        ];
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
            'user.id' => $this->id,
            'user.status_id' => $this->status_id,
            'user.role_id' => $this->role_id,
        ]);

        $query->andFilterWhere(['like', 'user.email', $this->email])
            ->andFilterWhere(['like', 'user.first_name', $this->first_name])
            ->andFilterWhere(['like', 'user.last_name', $this->last_name])
            ->andFilterWhere(['like', 'user.auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'user.password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'user.password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'user.password_reset_token_created', $this->password_reset_token_created])
            ->andFilterWhere(['like', 'user.created_at', $this->created_at])
            ->andFilterWhere(['like', 'user.updated_at', $this->updated_at]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
    }
}

