<?php

namespace common\models\base;

use Yii;
use common\models\User;
use common\models\Notification;

/**
 * This is the model class for table "apns_devices".
*
    * @property integer $id
    * @property integer $user_id
    * @property string $device_uuid
    * @property string $device_token
    * @property string $platform_type
    * @property string $app_name
    * @property string $app_version
    * @property string $device_name
    * @property string $device_model
    * @property string $device_os_version
    * @property string $push_badge
    * @property string $push_alert
    * @property string $push_sound
    * @property string $environment
    * @property string $status
    * @property string $created_at
    * @property string $updated_at
    *
            * @property User $user
            * @property Notification[] $notifications
    */
class ApnsDevicesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'apns_devices';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['user_id'], 'integer'],
            [['device_uuid', 'device_token'], 'required'],
            [['platform_type', 'push_badge', 'push_alert', 'push_sound', 'environment', 'status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['device_uuid'], 'string', 'max' => 64],
            [['device_token'], 'string', 'max' => 255],
            [['app_name', 'device_name', 'device_model'], 'string', 'max' => 50],
            [['app_version', 'device_os_version'], 'string', 'max' => 10],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'user_id' => 'User ID',
    'device_uuid' => 'Device Uuid',
    'device_token' => 'Device Token',
    'platform_type' => 'Platform Type',
    'app_name' => 'App Name',
    'app_version' => 'App Version',
    'device_name' => 'Device Name',
    'device_model' => 'Device Model',
    'device_os_version' => 'Device Os Version',
    'push_badge' => 'Push Badge',
    'push_alert' => 'Push Alert',
    'push_sound' => 'Push Sound',
    'environment' => 'Environment',
    'status' => 'Status',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUser()
    {
    return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getNotifications()
    {
    return $this->hasMany(Notification::className(), ['fk_device_id' => 'id']);
    }
}