<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\dblogs\models\Logs */

$this->title = $model->log_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logs-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Cancel'), ['index', ], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'log_id',
            'user_id',
            'session_id',
            'ip',
            'user_host',
            'user_agent',
            'url:url',
            'act',
            'time',
            'model',
            //'last_data:ntext',
            //'new_data:ntext',
			[
				'attribute' => 'last_data',
				'value' => data_prepare($model->last_data),
				'format' => 'html',
			],
			[
				'attribute' => 'new_data',
				'value' => data_prepare($model->new_data),
				'format' => 'html',
			],
			
        ],
    ]) ?>

</div>

<?php
	function data_prepare($data){
		if(empty($data)) return;
		$str_tmp = print_r(unserialize($data), true);
		$str_tmp = str_replace('&nbsp;', ' ', $str_tmp);
		$str_tmp = trim($str_tmp);
		$str_tmp = html_entity_decode($str_tmp);
		$str_tmp = strip_tags($str_tmp);
		$str_tmp = trim($str_tmp);
		$return = '<pre>'.$str_tmp.'</pre>';
		return $return;
	}
?>