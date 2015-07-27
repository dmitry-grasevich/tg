<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Control as ControlModel;

/**
 * Control represents the model behind the search form about `common\models\Control`.
 */
class Control extends ControlModel
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['family', 'type', 'class', 'name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ControlModel::find();

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
            ]
        ]);

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'family', $this->family])
            ->andFilterWhere(['like', 'class', $this->class])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
