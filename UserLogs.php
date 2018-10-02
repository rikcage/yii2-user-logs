<?php

namespace rikcage\user-logs;

/**
 * bdlogs module definition class
 */
class UserLogs extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'rikcage\user-logs\controllers';
    public $theme = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();

        if ($this->theme) {
            Yii::$app->view->theme = new \yii\base\Theme($this->theme);
        }

        // custom initialization code goes here
    }

    public function registerTranslations()
    {
        if (!isset(Yii::$app->i18n->translations['user-logs'])) {
            Yii::$app->i18n->translations['user-logs'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'ru-Ru',
                'basePath' => '@rikcage/user-logs/messages',
            ];
        }
    }

}
