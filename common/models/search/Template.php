<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Template as TemplateModel;

/**
 * Template represents the model behind the search form about `common\models\Template`.
 */
class Template extends TemplateModel
{
    public $categoryName;

    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['name', 'filename', 'directory', 'img', 'code'], 'safe'],
            [['categoryName'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = TemplateModel::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        /**
         * Setup your sorting attributes
         * Note: This is setup before the $this->load($params)
         * statement below
         */
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'name',
                'filename',
                'directory',
                'categoryName' => [
                    'asc' => ['template_category.name' => SORT_ASC],
                    'desc' => ['template_category.name' => SORT_DESC],
                    'label' => 'Category'
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            /**
             * The following line will allow eager loading with template_category data
             * to enable sorting by country on initial loading of the grid.
             */
            $query->joinWith(['category']);
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'template.name', $this->name])
            ->andFilterWhere(['like', 'template.filename', $this->filename])
            ->andFilterWhere(['like', 'template.directory', $this->directory])
            ->andFilterWhere(['like', 'template.img', $this->img])
            ->andFilterWhere(['like', 'template.code', $this->code]);

        // filter by category name
        $query->joinWith(['category' => function ($q) {
            $q->where('template_category.name LIKE "%' . $this->categoryName . '%"');
        }]);

        return $dataProvider;
    }
}
