<?php

namespace common\models\base;

use common\models\MedicineType;
use Yii;
use common\models\Language;

/**
 * This is the model class for table "type".
*
    * @property integer $id
    * @property integer $language_id
    * @property string $type
    * @property integer $is_active
    * @property string $created_at
    * @property string $updated_at
    *
            * @property MedicineType[] $medicineTypes
            * @property Language $language
    */
class TypeBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'type';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['language_id', 'is_active'], 'integer'],
            [['type'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['type'], 'string', 'max' => 255],
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
    'language_id' => 'Language',
    'type' => 'Type',
    'is_active' => 'Is Active',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicineTypes()
    {
    return $this->hasMany(MedicineType::className(), ['type_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getLanguage()
    {
    return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }
}
