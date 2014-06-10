<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\user\models\User;

/**
 * UserSearch represents the model behind the search form about `app\modules\user\models\User`.
 */
class UserSearch extends User
{
    public function rules()
    {
        return [
            [['id', 'email', 'password', 'role', 'username', 'company_name'], 'safe'],
            [['status', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'company_name', $this->company_name]);

        return $dataProvider;
    }
}
