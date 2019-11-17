<?php

namespace common\models\base;

use Yii;
use common\models\Composition;
use common\models\Medicines;

/**
 * This is the model class for table "medicine_composition".
*
    * @property integer $id
    * @property integer $medicine_id
    * @property integer $composition_id
    * @property string $created_at
    *
            * @property Composition $composition
            * @property Medicines $medicine
    */
class MedicineCompositionBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'medicine_composition';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['medicine_id', 'composition_id'], 'required'],
            [['medicine_id', 'composition_id'], 'integer'],
            [['created_at'], 'safe'],
            [['composition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Composition::className(), 'targetAttribute' => ['composition_id' => 'id']],
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
    'composition_id' => 'Composition',
    'created_at' => 'Created At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getComposition()
    {
    return $this->hasOne(Composition::className(), ['id' => 'composition_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicine()
    {
    return $this->hasOne(Medicines::className(), ['id' => 'medicine_id']);
    }
}
