<?php

namespace common\models\base;

use Yii;
use common\models\MedicinePacking;
use common\models\Language;

/**
 * This is the model class for table "packing".
*
    * @property integer $id
    * @property integer $language_id
    * @property string $weight_type
    * @property integer $weight
    * @property string $created_at
    * @property string $updated_at
    *
            * @property MedicinePacking[] $medicinePackings
            * @property Language $language
    */
class PackingBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'packing';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['language_id', 'weight'], 'integer'],
            [['weight_type'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['weight_type'], 'string', 'max' => 20],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'language_id' => 'Language ID',
    'weight_type' => 'Weight Type',
    'weight' => 'Weight',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicinePackings()
    {
    return $this->hasMany(MedicinePacking::className(), ['packing_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getLanguage()
    {
    return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }
}