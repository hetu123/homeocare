<?php

namespace common\models\base;

use Yii;
use common\models\Medicines;

/**
 * This is the model class for table "medicine_master".
*
    * @property integer $id
    * @property integer $medicine_id
    * @property string $created_at
    *
            * @property Medicines $medicine
    */
class MedicineMasterBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'medicine_master';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['medicine_id'], 'required'],
            [['medicine_id'], 'integer'],
            [['created_at'], 'safe'],
            [['medicine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medicines::className(), 'targetAttribute' => ['medicine_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'medicine_id' => 'Medicine ID',
    'created_at' => 'Created At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicine()
    {
    return $this->hasOne(Medicines::className(), ['id' => 'medicine_id']);
    }
}