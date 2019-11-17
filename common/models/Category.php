<?php

namespace common\models;

class Category extends \common\models\base\CategoryBase
{
    public function getClass()

    {

        return $this->hasOne(Category::className(), ['id' => 'class_id']);

    }
}