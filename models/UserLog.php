<?php
namespace rikcage\user_logs\models;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\web\HttpException;
use yii\web\User;
use yii\behaviors\AttributeBehavior;
use yii\helpers\ArrayHelper;

use rikcage\user_logs\models\Logs;
use rikcage\user_logs\UserLogs;


class UserLog extends AttributeBehavior
{

    public static function initTable($module_name)
    {
		$module = \Yii::$app->getModule($module_name);
		if(!empty($module->params['log_table'])){
			Logs::settableName($module->params['log_table']);
		}
    }

    public function addlog($act = null)
    {
		UserLogs::registerTranslations();
		if(!empty(Yii::$app->controller->module->gitignore_list)
			&& is_array(Yii::$app->controller->module->gitignore_list)
			&& in_array(get_class($this->owner), Yii::$app->controller->module->gitignore_list)
		){
			return;
		}
		

		$log = new Logs();
		if(@Yii::$app->user->isGuest)
			$log->user_id = null;
		else
			$log->user_id = (int)Yii::$app->user->identity->id;
			
		$log->ip = (string)Yii::$app->request->userIP;
		if(empty($log->ip)){
			$log->ip = (string)Yii::t('user_logs', 'Failed determine the IP address.');
		}
		
		$log->url = (string)Yii::$app->request->url;
		if(empty($log->url)){
			$log->url = (string)Yii::t('user_logs', 'Failed determine the URL of page.');
		}
		
		$log->user_host = (string)Yii::$app->request->userHost;
		
		$log->user_agent = (string)Yii::$app->request->userAgent;
		
		$log->act = (string)$act;
	
		if(method_exists($this->owner, 'tableName')){
			$log->model = (string)$this->owner->tableName();
		}else{
			if(substr_count($act, 'LOGIN')){
				$log->model = (string)'{{%user}}';
			}else{
				$log->model = (string)Yii::t('user_logs', 'Failed determine the table.');
			}
		}
		if(!empty(get_class($this->owner))){
			$log->model .= (string)' '.get_class($this->owner);
		}else{
			$log->model .= (string)' '.Yii::t('user_logs', 'Failed determine the model.');
		}

		$log->last_data = (string)serialize($this->checkSecure($this->owner->oldAttributes));

		$log->new_data = (string)serialize($this->checkSecure($this->owner->attributes));
		
		$log->save();
		if(count($log->errors)){
			throw new HttpException(500 ,'Log error');
		}
			
    }

    public function actionlog($act = null, $class=null)
    {
		UserLogs::registerTranslations();
		if(!empty(Yii::$app->controller->module->gitignore_list)
			&& is_array(Yii::$app->controller->module->gitignore_list)
			&& in_array(get_class($class), Yii::$app->controller->module->gitignore_list)
		){
			return;
		}

		$log = new Logs();
		if(@Yii::$app->user->isGuest)
			$log->user_id = null;
		else
			$log->user_id = (int)Yii::$app->user->identity->id;

		$log->ip = (string)Yii::$app->request->userIP;
		if(empty($log->ip)){
			$log->ip = (string)Yii::t('user_logs', 'Failed determine the IP address.');
		}

		$log->url = (string)Yii::$app->request->url;
		if(empty($log->url)){
			$log->url = (string)Yii::t('user_logs', 'Failed determine the URL of page.');
		}

		$log->user_host = (string)Yii::$app->request->userHost;

		$log->user_agent = (string)Yii::$app->request->userAgent;

		$log->act = (string)$act;

		if(method_exists($class, 'tableName')){
			$log->model = (string)$class->tableName();
		}else{
			if(substr_count($act, 'LOGIN')){
				$log->model = (string)'{{%user}}';
			}else{
				$log->model = (string)Yii::t('user_logs', 'Failed determine the table.');
			}
		}
		if(!empty(get_class($class))){
			$log->model .= (string)' '.get_class($class);
		}else{
			$log->model .= (string)' '.Yii::t('user_logs', 'Failed determine the model.');
		}

		if(method_exists($class, 'oldAttributes') && count($class->oldAttributes)){
			$log->last_data = (string)serialize($this->checkSecure($class->oldAttributes));
		}else{
			$log->last_data = null;
		}

		if(method_exists($class, 'attributes') && count($class->attributes)){
			$log->new_data = (string)serialize($this->checkSecure($class->attributes));
		}else{
			$log->new_data = null;
		}

		$log->save();
		if(count($log->errors)){
			throw new HttpException(500 ,'Log error');
		}

    }
	
    public function checkSecure($attributes)
    {
		if(isset($attributes['password'])){
			unset($attributes['password']);
		}
		if(isset($attributes['password_confirm'])){
			unset($attributes['password_confirm']);
		}
		if(isset($attributes['password_hash'])){
			unset($attributes['password_hash']);
		}
		if(isset($attributes['password_reset_token'])){
			unset($attributes['password_reset_token']);
		}
		return $attributes;
	}

	public function events()
    {
        return [
			ActiveRecord::EVENT_BEFORE_INSERT => function(){$this->addlog('INSERT');},
            ActiveRecord::EVENT_BEFORE_UPDATE => function(){$this->addlog('UPDATE');},
            ActiveRecord::EVENT_BEFORE_DELETE => function(){$this->addlog('DELETE');},
        ];
    }	
}
