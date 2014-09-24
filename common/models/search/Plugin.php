<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Plugin as PluginModel;

/**
 * Js represents the model behind the search form about `common\models\Plugin`.
 */
class Plugin extends PluginModel
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'directory'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = PluginModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'directory', $this->directory]);

        return $dataProvider;
    }
}
