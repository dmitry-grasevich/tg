<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Functions as FunctionsModel;

/**
 * Functions represents the model behind the search form about `common\models\Functions`.
 */
class Functions extends FunctionsModel
{
    public $parentName;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'code'], 'safe'],
            [['parentName'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = FunctionsModel::find();

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
                'parentName' => [
                    'asc' => ['template.name' => SORT_ASC],
                    'desc' => ['template.name' => SORT_DESC],
                    'label' => 'Parent'
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            $query->joinWith(['parent']);
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code]);

        // filter by parent name
        $query->joinWith(['parent' => function ($q) {
            $q->where('template.name LIKE "%' . $this->parentName . '%"');
        }]);

        return $dataProvider;
    }
}
