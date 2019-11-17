<?php

namespace common\models;

class OrderItem extends \common\models\base\OrderItemBase
{
    public static function findByPk($id)
    {
        return static::findOne(['id' => $id]);
    }

}