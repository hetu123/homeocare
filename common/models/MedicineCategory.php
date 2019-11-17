<?php

namespace common\models;

class MedicineCategory extends \common\models\base\MedicineCategoryBase
{
    public function getClass()

    {

        return $this->hasOne(Category::className(), ['id' => 'class_id']);

    }
}
