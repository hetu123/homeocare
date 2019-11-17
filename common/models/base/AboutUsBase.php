<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "about_us".
*
    * @property integer $id
    * @property string $description
    * @property string $created_at
    * @property string $updated_at
*/
class AboutUsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'about_us';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'description' => 'Description',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}
}