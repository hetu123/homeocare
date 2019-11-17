<?php

namespace common\models\base;

use Yii;
use common\models\Language;
use common\models\MedicineBrand;

/**
 * This is the model class for table "brand".
*
    * @property integer $id
    * @property integer $language_id
    * @property string $name
    * @property string $code
    * @property integer $is_active
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Language $language
            * @property MedicineBrand[] $medicineBrands
    */
class BrandBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'brand';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['language_id', 'is_active'], 'integer'],
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'code'], 'string', 'max' => 255],
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
    'name' => 'Name',
    'code' => 'Code',
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
    public function getMedicineBrands()
    {
    return $this->hasMany(MedicineBrand::className(), ['brand_id' => 'id']);
    }
}
