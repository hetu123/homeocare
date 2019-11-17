<?php

namespace common\models\base;

use Yii;
use common\models\AppoinmentBooking;

/**
 * This is the model class for table "time_slot".
*
    * @property integer $id
    * @property string $day
    * @property string $morning_hours_from
    * @property string $morning_hours_to
    * @property string $evening_hours_from
    * @property string $evening_hours_to
    * @property integer $is_open
    * @property string $created_at
    * @property string $updated_at
    *
            * @property AppoinmentBooking[] $appoinmentBookings
    */
class TimeSlotBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'time_slot';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['is_open'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['day', 'morning_hours_from', 'morning_hours_to', 'evening_hours_from', 'evening_hours_to'], 'string', 'max' => 255],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'day' => 'Day',
    'morning_hours_from' => 'Morning Hours From',
    'morning_hours_to' => 'Morning Hours To',
    'evening_hours_from' => 'Evening Hours From',
    'evening_hours_to' => 'Evening Hours To',
    'is_open' => 'Is Open',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getAppoinmentBookings()
    {
    return $this->hasMany(AppoinmentBooking::className(), ['time_slot_id' => 'id']);
    }
}