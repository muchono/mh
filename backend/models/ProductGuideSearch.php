<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductGuide;

/**
 * ProductGuideSearch represents the model behind the search form about `backend\models\ProductGuide`.
 */
class ProductGuideSearch extends ProductGuide
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'status', 'traffic', 'google_pr', 'alexa_rank'], 'integer'],
            [['title', 'url', 'about'], 'safe'],
            [['da_rank'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ProductGuide::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'status' => $this->status,
            'traffic' => $this->traffic,
            'google_pr' => $this->google_pr,
            'alexa_rank' => $this->alexa_rank,
            'da_rank' => $this->da_rank,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'about', $this->about]);

        return $dataProvider;
    }
}
