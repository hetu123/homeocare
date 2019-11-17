<?php

namespace common\models;

class Addresses extends \common\models\base\AddressesBase
{
    /**
     * Finds Model by id
     *
     * @param string $id
     * @return static|null
     */
    public static function findByPk($id)
    {
        return static::findOne(['id' => $id]);
    }
    public static function findByRelation(){
        $addressQuery = Addresses::find();
            $addressQuery->alias('a');
            $addressQuery->select(['a.id','a.address1','a.address2','a.pincode','c.name as city_name','s.name as state_name','co.name country_name','a.contact']);
            $addressQuery->innerJoin('cities as c', 'c.id=a.city_id');
            $addressQuery->innerJoin('states as s', 's.id=c.state_id');
            $addressQuery->innerJoin('countries as co', 'co.id=s.country_id');
           // $addressQuery->where(['a.id'=>$addres_id]);
            //$addressQuery->asArray();
            
            return $addressQuery;
    }
}