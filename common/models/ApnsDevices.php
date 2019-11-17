<?php
namespace common\models;
class ApnsDevices extends \common\models\base\ApnsDevicesBase
{
    const PLATFORM_IOS = "ios";
    const PLATFORM_ANDROID = "android";
    const PLATFORM_OTHER = "other";
    const ENUM_DISABLE = "disable";
    const ENUM_ENABLE = "enable";
    const ENVIRONMENT_DEVELOPMENT = "development";
    const ENVIRONMENT_PRODUCTION = "production";
    const STATUS_ACTIVE = "active";
    const STATUS_UNINSTALLED = "uninstalled";
    /**
     * Finds Model by id
     *
     * @param string $id
     * @return static|null
     */
    public static function findByPk($id)
    {
        return static::findOne(['id' => $id]);
    }
    public static function findById($id)
    {
        return static::findOne(['device_uuid' => $id]);
    }
}