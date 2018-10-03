<?php

namespace rikcage\user_logs\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

use rikcage\user_logs\models\UserLog;

/**
 * Default controller for the `bdlogs` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
     
	public function beforeAction($action)
	{
		if (!parent::beforeAction($action)) {
			return false;
		}
		UserLog::initTable(Yii::$app->controller->module->id);
		$log = new UserLog;
		$log->actionlog('ACTION', $this);

		return true;
	}	
	
    public function behaviors()
    {
		if(!empty(Yii::$app->controller->module->access_rules) && is_array(Yii::$app->controller->module->access_rules)){
			$access_rules = Yii::$app->controller->module->access_rules;
		}else{
			$access_rules = [
				[
					'actions' => null, //for all
					'allow' => true,
					'roles' => ['@'],
				],
			];
		}
		
        $result = [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => $access_rules,
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
		
		if(!empty(Yii::$app->controller->module->behaviors_params)){
			$result = ArrayHelper::merge($result, Yii::$app->controller->module->behaviors_params);
		}
		
		return $result;
    }
     
    public function actionIndex()
    {
        return $this->goHome();
    }
}
