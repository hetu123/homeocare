<?php

namespace common\models\base;

use Yii;
use common\models\ApnsDevices;
use common\models\User;

/**
 * This is the model class for table "notification".
*
    * @property integer $id
    * @property integer $from_id
    * @property integer $to_id
    * @property integer $reference_id
    * @property integer $fk_device_id
    * @property string $type
    * @property string $message
    * @property string $json_data
    * @property string $created_at
    * @property string $updated_at
    *
            * @property ApnsDevices $fkDevice
            * @property User $from
            * @property User $to
    */
class NotificationBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'notification';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['from_id', 'to_id', 'fk_device_id'], 'required'],
            [['from_id', 'to_id', 'reference_id', 'fk_device_id'], 'integer'],
            [['type'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['message', 'json_data'], 'string', 'max' => 1000],
            [['fk_device_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApnsDevices::className(), 'targetAttribute' => ['fk_device_id' => 'id']],
            [['from_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_id' => 'id']],
            [['to_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'from_id' => 'From ID',
    'to_id' => 'To ID',
    'reference_id' => 'Reference ID',
    'fk_device_id' => 'Fk Device ID',
    'type' => 'Type',
    'message' => 'Message',
    'json_data' => 'Json Data',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getFkDevice()
    {
    return $this->hasOne(ApnsDevices::className(), ['id' => 'fk_device_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getFrom()
    {
    return $this->hasOne(User::className(), ['id' => 'from_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTo()
    {
    return $this->hasOne(User::className(), ['id' => 'to_id']);
    }
}