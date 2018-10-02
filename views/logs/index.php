<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\modules\dblogs\models\LogsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logs-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'log_id',
            'username',
            //'session_id',
            'ip',
            //'user_host',
            // 'user_agent',
            'url:url',
			[
				'attribute' => 'act',
				'format' => 'raw',
				'contentOptions' => function ($model) {
					$array =array();
					switch ($model->act) {
					case 'INSERT':
						$array =array('class' => 'alert-info');
						break;
					case 'UPDATE':
						$array =array('class' => 'alert-info');
						break;
					case 'DELETE':
						$array =array('class' => 'alert-danger');
						break;
					case 'LOGIN TRY':
						$array =array('class' => 'alert-warning');
						break;
					case 'LOGIN OK':
						$array =array('class' => 'alert-success');
						break;
					case 'LOGIN FAILED':
						$array =array('class' => 'alert-danger');
						break;
					}
					return $array;
					
				},
			],
			
            'time',
            // 'model',
            // 'last_data:ntext',
            // 'new_data:ntext',

            //['class' => 'yii\grid\ActionColumn'],
			[
				'class' => 'yii\grid\ActionColumn',
				//'template' => '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{permit}&nbsp;&nbsp;{delete}',
				'template' => '{view}&nbsp;',
			],
			
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
