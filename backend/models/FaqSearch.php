<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Faq;

/**
 * FaqSearch represents the model behind the search form about `common\models\Faq`.
 */
class FaqSearch extends Faq
{
    
    public $categories;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'popular_question', 'order'], 'integer'],
            [['title', 'answer','categories'], 'safe'],
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
        $query = Faq::find();

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
        
        if (!empty($this->categories)) {

            $ids = \common\models\FaqToCategory::find()
                ->select('faq_id')
                ->andFilterWhere(['category_id' => $this->categories])
                ->asArray()->column();

            if ($ids) {
                $query->andFilterWhere(['in', 'id', $ids]);
            } else {
                $query->where('0=1');
            }
        }        

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'popular_question' => $this->popular_question,
            'order' => $this->order,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'answer', $this->answer]);

        return $dataProvider;
    }
}
