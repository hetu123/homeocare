<?php

namespace common\models\base;

use Yii;
use common\models\Category;
use common\models\Medicines;

/**
 * This is the model class for table "medicine_category".
*
    * @property integer $id
    * @property integer $medicine_id
    * @property integer $category_id
    * @property string $created_at
    *
            * @property Category $category
            * @property Medicines $medicine
    */
class MedicineCategoryBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'medicine_category';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['medicine_id', 'category_id'], 'required'],
            [['medicine_id', 'category_id'], 'integer'],
            [['created_at'], 'safe'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
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
    'category_id' => 'Category',
    'created_at' => 'Created At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCategory()
    {
    return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMedicine()
    {
    return $this->hasOne(Medicines::className(), ['id' => 'medicine_id']);
    }
}
