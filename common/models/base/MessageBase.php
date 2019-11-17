<?php

namespace common\models\base;

use Yii;
use common\models\User;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property integer $from_id
 * @property integer $to_id
 * @property string $message
 * @property integer $is_read
 * @property integer $deletedBy
 * @property integer $created_at
 *
 * @property User $from
 * @property User $to
 */
class MessageBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_id', 'to_id'], 'required'],
            [['from_id', 'to_id', 'is_read', 'deletedBy', 'created_at'], 'integer'],
            [['message'], 'string', 'max' => 255],
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
            'message' => 'Message',
            'is_read' => 'Is Read',
            'deletedBy' => 'Deleted By',
            'created_at' => 'Created At',
        ];
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
