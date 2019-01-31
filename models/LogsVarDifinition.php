<?php

namespace rikcage\user_logs\models;

use Yii;
use yii\db\ActiveRecord;

use rikcage\user_logs\models\UserLog;

/**
 * This is the model class for table "{{%logs}}".
 *
 * @property string $name
 * @property string $value
 */
class LogsVarDifinition extends \yii\db\ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
		return '{{%log_var_difinition}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'value'], 'string'],
        ];
    }

	public static function needDelete(){
		if(!UserLog::getMethod('virtual_cron')){
			return false;
		}

		$var_name = UserLog::getMethod('var_name_last_delete',  'logs_last_delete');
		
        if (($var_difinition = LogsVarDifinition::findOne(['name' => $var_name,])) !== null) {
			if($var_difinition->value == date('Y-m-d')){
				return false;
			}
        }else{
			$var_difinition = new LogsVarDifinition();
			$var_difinition->name = $var_name;
		}
		
		$var_difinition->value = date('Y-m-d');
		$var_difinition->save();
		return true;
	}
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('user_logs', 'Name'),
            'value' => Yii::t('user_logs', 'Value'),
        ];
    }
	
}
