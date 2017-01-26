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
 * This is the base-model class for table "gizmo".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $icon
 * @property integer $header
 * @property string $size
 * @property integer $colour_scheme_id
 * @property string $image
 * @property integer $status
 * @property string $template
 * @property string $report_class
 *
 * @property \app\models\ColourScheme $colourScheme
 * @property \app\models\DashGizmo[] $dashGizmos
 */
class Gizmo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gizmo';
    }

    /**
     *
     */
    public static function label($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Gizmo} other{Gizmos}}', ['n' => $n]);
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
            [['colour_scheme_id'], 'exist', 'skipOnError' => true, 'targetClass' => ColourScheme::className(), 'targetAttribute' => ['colour_scheme_id' => 'id']],
            [['description', 'template'], 'string'],
            [['header', 'colour_scheme_id', 'status'], 'integer'],
            [['icon', 'size'], 'string', 'max' => 45],
            [['name', 'slug', 'image', 'report_class'], 'string', 'max' => 255],
            [['report_class'], 'unique'],
            [['slug'], 'required']
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
            'slug' => 'Slug',
            'description' => 'Description',
            'icon' => 'Icon',
            'header' => 'Header',
            'size' => 'Size',
            'colour_scheme_id' => 'Colour Scheme',
            'image' => 'Image',
            'status' => 'Status',
            'template' => 'Template',
            'report_class' => 'Report Class',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColourScheme()
    {
        return $this->hasOne(\app\models\ColourScheme::className(), ['id' => 'colour_scheme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDashGizmos()
    {
        return $this->hasMany(\app\models\DashGizmo::className(), ['gizmo_id' => 'id']);
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
            'gizmo.id' => $this->id,
            'gizmo.header' => $this->header,
            'gizmo.colour_scheme_id' => $this->colour_scheme_id,
            'gizmo.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'gizmo.name', $this->name])
            ->andFilterWhere(['like', 'gizmo.slug', $this->slug])
            ->andFilterWhere(['like', 'gizmo.description', $this->description])
            ->andFilterWhere(['like', 'gizmo.icon', $this->icon])
            ->andFilterWhere(['like', 'gizmo.size', $this->size])
            ->andFilterWhere(['like', 'gizmo.image', $this->image])
            ->andFilterWhere(['like', 'gizmo.template', $this->template])
            ->andFilterWhere(['like', 'gizmo.report_class', $this->report_class]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
    }
}

