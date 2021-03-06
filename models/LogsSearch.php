<?php

namespace rikcage\user_logs\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use rikcage\user_logs\models\Logs;

/**
 * LogsSearch represents the model behind the search form about `common\modules\dblogs\models\Logs`.
 */
class LogsSearch extends Logs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['log_id', 'user_id'], 'integer'],
            [['session_id', 'username', 'ip', 'user_host', 'user_agent', 'url', 'act', 'time', 'model', 'last_data', 'new_data'], 'safe'],
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
        $query = Logs::find();

        // add conditions that should always apply here
		$user = new Yii::$app->controller->module->params['userClass']();
		$field_username = Yii::$app->controller->module->params['username'];
		$field_userid = Yii::$app->controller->module->params['userid'];

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
		]);
		$dataProvider->setSort([
			'attributes' => [
				'log_id',
				'ip',
				'url',
				'act',
				'time',
				'username' => [
					'asc' => ['user.'.$field_username => SORT_ASC],
					'desc' => ['user.'.$field_username => SORT_DESC],
				],
			],
			'defaultOrder' => ['log_id' => SORT_DESC],
		]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		$query->leftJoin($user::tableName().' user', '`user`.`'.$field_userid.'` = '.Logs::tableName().'.`user_id`');
		$query->select('*, user.'.$field_username.' AS username');
		
        // grid filtering conditions
        $query->andFilterWhere([
            'log_id' => $this->log_id,
            'user_id' => $this->user_id,
            'time' => $this->time,
        ]);

        $query->andFilterWhere(['like', 'session_id', $this->session_id])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'user.'.$field_username, $this->username])
            ->andFilterWhere(['like', 'user_host', $this->user_host])
            ->andFilterWhere(['like', 'user_agent', $this->user_agent])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'act', $this->act])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'last_data', $this->last_data])
            ->andFilterWhere(['like', 'new_data', $this->new_data]);

        return $dataProvider;
    }
}
