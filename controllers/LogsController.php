<?php

namespace rikcage\user_logs\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

use rikcage\user_logs\models\UserLog;
use rikcage\user_logs\models\Logs;
use rikcage\user_logs\models\LogsSearch;

/**
 * LogsController implements the CRUD actions for Logs model.
 */
//class LogsController extends Controller
class LogsController extends \yii\web\Controller
{
	
	public function beforeAction($action)
	{
		if (!parent::beforeAction($action)) {
			return false;
		}
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
	
    /**
     * Lists all Logs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Logs model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Logs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Logs();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->log_id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Updates an existing Logs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->log_id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Deletes an existing Logs model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the Logs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Logs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Logs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
