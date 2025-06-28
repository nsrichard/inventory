<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class ProductSearch extends Product
{

    public $price_min;
    public $price_max;
    
    public function rules()
    {
        return [
            [['id', 'stock', 'category_id'], 'integer'],
            [['name', 'description'], 'safe'],
            [['price', 'price_min', 'price_max'], 'number'],
        ];
    }


    public function search($params)
    {
        $query = Product::find()->with('category');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            return $dataProvider;
        }

        //ActiveQuery
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['category_id' => $this->category_id]);

        if (!empty($this->price_min)) {
            $query->andWhere(['>=', 'price', $this->price_min]);
        }

        if (!empty($this->price_max)) {
            $query->andWhere(['<=', 'price', $this->price_max]);
        }

        if (!empty($params['in_stock'])) {
            $query->andWhere(['>', 'stock', 0]);
        }

        return $dataProvider;
    }

}
