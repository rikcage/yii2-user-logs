<?php

namespace rikcage\user_logs\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%logs}}".
 *
 * @property string $name
 * @property string $value
 */
class LogsVarDifinition extends \yii\db\ActiveRecord
{
//	public $username;
//	private static $_tableName = '{{%logs}}';

//	public function behaviors()
//	{
//		return [
//			'timestamp' => [
//				'class' => 'yii\behaviors\TimestampBehavior',
//				'attributes' => [
//					ActiveRecord::EVENT_BEFORE_INSERT => ['time'],
//					ActiveRecord::EVENT_BEFORE_UPDATE => ['time'],
//				],
//				'value' => function(){return $this->beforeData();},
//			],
//		];
//	}
	
	//public static $user_ip;
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
		return '{{%log_var_difinition}}';
    }

//    public static function settableName($tableName)
//    {
//		self::$_tableName = $tableName;
//    }
	
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
		
		if(!empty(Yii::$app->controller->module->logs_last_delete)){
			$var_name = Yii::$app->controller->module->logs_last_delete;
		}else{
			$var_name = 'logs_last_delete';
		}
        //return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
		
        if (($var_difinition = LogsVarDifinition::findOne(['name' => $var_name,])) !== null) {
            //return $var_difinition;
			echo 'Exist;';
			exit;
        } else {
			echo 'not Exist;';
			//exit;
            //Logs::
			//Yii::$app->db->createCommand()->batchInsert($this->tableName(), ['user_id', 'subject_id', 'is_native', 'student_levels'], $data_rows)->execute();
			$var_difinition = new LogsVarDifinition();
        }
		$last_date_delete = $var_difinition->value;
		
		$var_difinition->name = $var_name;
		$var_difinition->value = date('Y-m-d');
		$var_difinition->save();
//		$date = date('Y-m-d');
//		if(){
//			
//		}
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
