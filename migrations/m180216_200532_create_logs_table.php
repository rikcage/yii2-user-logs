<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `pay_log`.
 */
class m180216_200532_create_logs_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%logs}}', [
            'log_id' => $this->primaryKey(),
            'user_id' => Schema::TYPE_INTEGER . "(11) DEFAULT NULL",
            'session_id' => Schema::TYPE_STRING . "(50) NOT NULL",
            'ip' => Schema::TYPE_STRING . "(50) NOT NULL",
            'user_host' => Schema::TYPE_STRING . "(255) DEFAULT NULL",
            'user_agent' => Schema::TYPE_STRING . "(255) DEFAULT NULL",
            'url' => Schema::TYPE_TEXT . " NOT NULL",
            'act' => Schema::TYPE_STRING . "(512) DEFAULT NULL",
            'time' => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
            'date' => $this->date() . " NOT NULL",
            'model' => Schema::TYPE_STRING . "(255) DEFAULT NULL",
            'last_data' => Schema::TYPE_TEXT . " NULL",
            'new_data' => Schema::TYPE_TEXT . " NULL",
        ], 'ENGINE=MyISAM DEFAULT CHARSET=utf8');

		//ALTER TABLE logs engine=MyISAM;
		
        $this->createIndex(
            'logs-date',
            '{{%logs}}',
            'date'
        );
		
        $this->createTable('{{%log_var_difinition}}', [
            'name' => $this->string(255)->notNull(),
            'value' => $this->text(),
        ], 'ENGINE=MyISAM DEFAULT CHARSET=utf8');
		
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%logs}}');
        $this->dropIndex(
            'logs-date',
            '{{%logs}}'
        );
		
        $this->dropTable('{{%log_var_difinition}}');
    }
}
