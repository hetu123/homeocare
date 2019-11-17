<?php

namespace common\models\base;

use Yii;
use common\models\AgeGroup;
use common\models\TimeSlot;

/**
 * This is the model class for table "appoinment_booking".
*
    * @property integer $id
    * @property integer $age_group_id
    * @property string $date
    * @property integer $time_slot_id
    * @property string $symptoms
    * @property integer $is_approve
    * @property integer $is_cancel
    * @property string $status
    * @property string $created_at
    * @property string $updated_at
    *
            * @property AgeGroup $ageGroup
            * @property TimeSlot $timeSlot
    */
class AppoinmentBookingBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'appoinment_booking';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['age_group_id', 'time_slot_id'], 'required'],
            [['age_group_id', 'time_slot_id', 'is_approve', 'is_cancel'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['symptoms', 'status'], 'string', 'max' => 255],
            [['age_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => AgeGroup::className(), 'targetAttribute' => ['age_group_id' => 'id']],
            [['time_slot_id'], 'exist', 'skipOnError' => true, 'targetClass' => TimeSlot::className(), 'targetAttribute' => ['time_slot_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'age_group_id' => 'Age Group ID',
    'date' => 'Date',
    'time_slot_id' => 'Time Slot ID',
    'symptoms' => 'Symptoms',
    'is_approve' => 'Is Approve',
    'is_cancel' => 'Is Cancel',
    'status' => 'Status',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getAgeGroup()
    {
    return $this->hasOne(AgeGroup::className(), ['id' => 'age_group_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTimeSlot()
    {
    return $this->hasOne(TimeSlot::className(), ['id' => 'time_slot_id']);
    }
}