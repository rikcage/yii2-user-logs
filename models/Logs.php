<?php

namespace rikcage\user_logs\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%logs}}".
 *
 * @property string $log_id
 * @property integer $user_id
 * @property string $user_ip
 * @property string $user_host
 * @property string $user_agent
 * @property string $url
 * @property string $act
 * @property string $time
 * @property string $model
 * @property string $last_data
 * @property string $new_data
 */
class Logs extends \yii\db\ActiveRecord
{
	public $username;

	public function behaviors()
	{
		return [
			'timestamp' => [
				'class' => 'yii\behaviors\TimestampBehavior',
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['time'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['time'],
//					ActiveRecord::EVENT_BEFORE_VALIDATE => ['time'],
				],
				'value' => function(){return $this->beforeData();},
			],
		];
	}
	
	//public static $user_ip;
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%logs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'url'], 'required'],
            [['user_id'], 'integer'],
//            [['time'], 'safe'],
            [['last_data', 'new_data'], 'string'],
            [['ip', 'session_id'], 'string', 'max' => 50],
            [['user_host', 'user_agent', 'model'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 512],
            [['act'], 'string', 'max' => 100],
        ];
    }

	public function beforeData(){

		if(!empty(Yii::$app->controller->module->logs_live)){
			$logs_live = Yii::$app->controller->module->logs_live;
		}else{
			$logs_live = '-100 day';
		}
		$last_timest =  strtotime($logs_live);
		$last_time = date('Y-m-d H:i:s', $last_timest);
        $this->deleteAll('time < :last_time', [':last_time' => $last_time]);
		
		if(@Yii::$app->user->isGuest)
			$this->user_id = null;
		else
			$this->user_id = (int)Yii::$app->user->identity->id;

		$this->ip = (string)Yii::$app->request->userIP;
		if(empty($this->ip)){
			$this->ip = (string)Yii::t('user_logs', 'Failed determine the IP address.');
		}

		$this->session_id = Yii::$app->session->id;
		if(empty($this->session_id)){
			$this->session_id = (string)Yii::t('user_logs', 'Failed determine the session ID.');
		}
		
		$this->url = (string)Yii::$app->request->url;
		if(empty($this->url)){
			$this->url = (string)Yii::t('user_logs', 'Failed determine the URL of page.');
		}

		$this->user_host = (string)Yii::$app->request->userHost;

		$this->user_agent = (string)Yii::$app->request->userAgent;
		$this->time = date('Y-m-d H:i:s');
		return $this->time;
		
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'log_id' => Yii::t('user_logs', 'Log ID'),
            'user_id' => Yii::t('user_logs', 'User ID'),
            'ip' => Yii::t('user_logs', 'Ip'),
            'session_id' => Yii::t('user_logs', 'Session ID'),
            'user_host' => Yii::t('user_logs', 'User Host'),
            'user_agent' => Yii::t('user_logs', 'User Agent'),
            'url' => Yii::t('user_logs', 'Url'),
            'act' => Yii::t('user_logs', 'Act'),
            'time' => Yii::t('user_logs', 'Time'),
            'model' => Yii::t('user_logs', 'Model'),
            'last_data' => Yii::t('user_logs', 'Last Data'),
            'new_data' => Yii::t('user_logs', 'New Data'),
        ];
    }
	
}
