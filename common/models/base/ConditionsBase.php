<?php

namespace common\models\base;

use Yii;
use common\models\Language;
use common\models\MedicineConditions;

/**
 * This is the model class for table "conditions".
*
    * @property integer $id
    * @property integer $language_id
    * @property string $condition
    * @property string $description
    * @property integer $is_active
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Language $language
            * @property MedicineConditions[] $medicineConditions
    */
class ConditionsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'conditions';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['language_id', 'is_active'], 'integer'],
            [['condition'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['condition'], 'string', 'max' => 255],
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
    'condition' => 'Condition',
    'description' => 'Description',
    'is_active' => 'Is Active',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getLanguage()
    {
    return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicineConditions()
    {
    return $this->hasMany(MedicineConditions::className(), ['condition_id' => 'id']);
    }
}