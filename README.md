yii2-user-logs
======================

full and comfortable logs of user actions (visited pages), insert, update, delete

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

To install, either run

```
$ php composer.phar require rikcage/yii2-user-logs "*"
```

or add

```
"rikcage/yii2-user-logs": "*"
```
to the ```require``` section of your `composer.json` file.

Run migration to create `logs` table (it means that a connection to the database is already configured for the application)

```
./yii migrate --migrationPath=@rikcage/user-logs/migrations
```


Add the module
==============

Include module to the config file (`backend/config/main.php` for advanced app or `config/web.php` and `config/console` for basic app)

```php
	'modules' => [
    ...
		'logs' => [ // you can create several 'logs', 'logs_admin', etc. sections
                    // if you want another table different from '{{%logs}} or several tables
			'class' => 'rikcage\user_logs\UserLogs',
			'params' => [
				'userClass' => 'account\models\User',
				'username' => 'user_name',
				'userid' => 'user_id',
				//'log_table' => '{{%logs_admin}}', // if you want another table different from '{{%logs}}', default 'log_table' => '{{%logs}}'
			],
			'access_rules' => [ // Setting permissions for viewing logs (http://your_site/logs/logs)
				[
					'actions' => null, //for all
					'allow' => true,
					'roles' => ['@'],
				],
            ],
			//'behaviors_params' => [ // additional settings of the behaviors () method for Logic Controller,
                                    // eg using access control extensions.
			//	'as AccessBehavior' => [
			//		'class' => AccessBehavior::className(),
			//	],
			//],
			//'virtual_cron' => false, //default virtual_cron=true once a day deletes old logs for disable use virtual_cron=false
			//'var_name_last_delete' => 'logs_last_delete', // variable name the date of the last clean of the log, default var_name_last_delete=logs_last_delete
			'logs_live' => '-100 day', // lifetime of log
			'gitignore_list' => [ // ignored events of controllers and models.
				'rikcage\user_logs\controllers\LogsController',
			],

		],
	],
```
for disable use virtual_cron set ```'virtual_cron' => false```

## Installation guide for the Controller

add to your Controller

```php

use rikcage\user_logs\models\UserLog;

    ...

	public function beforeAction($action)
	{
		if (!parent::beforeAction($action)) {
			return false;
		}
		UserLog::initTable('logs'); // if you want another section with settings different from 'logs_admin' model
		$log = new UserLog;
		$log->actionlog('ACTION', $this);

		return true;
	}
```

## Installation guide for the Model

add to your Model

```php

use rikcage\user_logs\models\UserLog;

    ...

	public function behaviors()
	{
    ...
        //UserLog::initTable('logs_admin'); // if you want another section with settings different from 'logs' model
		return [
    ...
			UserLog::className(),
		];
	}
```
