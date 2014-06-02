<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Js as JsModel;

/**
 * Js represents the model behind the search form about `common\models\Js`.
 */
class Js extends JsModel
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'code', 'filename', 'directory'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = JsModel::find();

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
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'directory', $this->directory]);

        return $dataProvider;
    }
}
