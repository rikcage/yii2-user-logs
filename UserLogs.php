<?php

namespace rikcage\user_logs;

use Yii;

/**
 * bdlogs module definition class
 */
class UserLogs extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'rikcage\user_logs\controllers';
    public $theme = false;
    public $access_rules; //array
    public $behaviors_params; //array
    public $logs_live; //string
    public $virtual_cron = true; //string
    public $var_name_last_delete; //string
    public $gitignore_list = array();

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        //UserLogs::registerInit();
        UserLogs::registerTranslations();

        if ($this->theme) {
            Yii::$app->view->theme = new \yii\base\Theme($this->theme);
        }
        // custom initialization code goes here
    }

    public static function registerTranslations()
    {
		Yii::setAlias('@rikcage', dirname(dirname(__DIR__)) . '/rikcage/yii2-user-logs');
		
        if (!isset(Yii::$app->i18n->translations['user_logs'])) {
            Yii::$app->i18n->translations['user_logs'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                //'sourceLanguage' => 'en-US',
                //'sourceLanguage' => 'ru-Ru',
                'basePath' => '@rikcage/messages/',
                'fileMap' => [
                    'user_logs'       => 'user_logs.php',
                ],
				
            ];
        }
    }

}
