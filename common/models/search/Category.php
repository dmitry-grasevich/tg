<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Category as CategoryModel;

/**
 * Category represents the model behind the search form about `common\models\Category`.
 */
class Category extends CategoryModel
{
    public function rules()
    {
        return [
            [['id', 'is_basic'], 'integer'],
            [['name', 'alias'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CategoryModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'is_basic' => $this->is_basic,
        ]);

        $query->andFilterWhere(['like', 'category.name', $this->name])
            ->andFilterWhere(['like', 'category.alias', $this->alias]);

        return $dataProvider;
    }
}
