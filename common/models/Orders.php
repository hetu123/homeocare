<?php

namespace common\models;
use yii\db\Query;
use yii\helpers\ArrayHelper;
class Orders extends \common\models\base\OrdersBase
{
    public static function findByPk($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findByRelation(){
       
        $findQuery = Orders::find();
        $findQuery->alias('o');
        
        $findQuery->select(['o.id','o.user_id','o.address_id','a.address1','a.address2','a.pincode','c.name as city_name','s.name as state_name','co.name as country_name','p.name as payment_name','o.paid_amount as price','o.created_at','o.updated_at']);
        $findQuery->innerJoin('addresses as a', 'a.id = o.address_id');
        $findQuery->innerJoin('cities as c', 'c.id = a.city_id');
        $findQuery->innerJoin('states as s', 's.id = c.state_id');
        $findQuery->innerJoin('countries as co', 'co.id = s.country_id');
        $findQuery->innerJoin('payment_methods as p', 'p.id = o.payment_method_id');
        return $findQuery;

    }

    public static function OrderDetail($order_id=null,$language_id = null){
        if ($language_id == null) {
            $language_id = '1';
        }
          
        $findQuery = Orders::find();
        $findQuery->alias('o');
        
        $findQuery->select(['o.id','o.user_id','o.address_id','a.address1','a.address2','a.pincode','c.name as city_name','s.name as state_name','co.name as country_name','p.name as Payment_name','o.created_at','o.updated_at']);
        $findQuery->innerJoin('addresses as a', 'a.id = o.address_id');
        $findQuery->innerJoin('cities as c', 'c.id = a.city_id');
        $findQuery->innerJoin('states as s', 's.id = c.state_id');
        $findQuery->innerJoin('countries as co', 'co.id = s.country_id');
        $findQuery->innerJoin('payment_methods as p', 'p.id = o.payment_method_id');
       // $findQuery->with('orderItems');
        $findQuery->joinWith([
            'orderItems' => function ($findQuery) use ($language_id){
               $findQuery->alias('oi');
               $findQuery->select(['oi.id','oi.medicine_id','oi.order_id','oi.quantity']);
               $findQuery->joinWith(['medicine' => function ($findQuery) use ($language_id){
                
                $coverMax = (new Query())
                ->select('max(id)')
                ->from(MedicineImage::tableName())
                ->where('medicine_id = m.id')
                ->andWhere('is_cover=1');
            $coverImage = (new Query())
                ->select('image')
                ->from(MedicineImage::tableName())
                ->where(['id' => $coverMax]);
            $defaultMax = (new Query())
                ->select('min(id)')
                ->from(MedicineImage::tableName())
                ->where('medicine_id = m.id');
            $languageCode = (new Query())
                ->select('code')
                ->from(Language::tableName())
                ->where(['id'=>$language_id])->one();
            $defaultImage = (new Query())
                ->select('image')
                ->from(MedicineImage::tableName())
                ->where(['id' => $defaultMax]);
   
                $findQuery->select(['m.id']);
                if($languageCode['code'] === 'GU'){
                    $findQuery->addSelect(['m.gujrati_name as name','m.gujrati_description as description']);
                }
                elseif ($languageCode['code'] === 'HN'){
                    $findQuery->addSelect(['m.hindi_name as description','m.hindi_description as description']);
                }
                else{
                   $findQuery->addSelect(['m.name', 'm.description',]);
                }
                $findQuery->addSelect(['m.dosages', 'm.solution_for', 'm.direction', 'm.indications',
                    'm.manufacture_date', 'm.expiry_date', 'm.price','m.discount_in_amount','m.discount_in_percentage', 'm.MRP as strike_price']);
                $findQuery->addSelect(['cover_image'=>$coverImage]);
                $findQuery->addSelect(['default_image'=>$defaultImage]);
                $findQuery->addSelect(['sgst'=>new \yii\db\Expression('((m.price * m.total_gst)/100)/2' )]);
                $findQuery->addSelect(['cgst'=>new \yii\db\Expression('((m.price * m.total_gst)/100)/2' )]);

                $findQuery->andWhere(['m.is_active' => Medicines::IS_ACTIVE]);
        
                    $findQuery->alias('m');
               }]);
            },
            ]);
        //$findQuery->joinWith(['orderItems'=>function( $findQuery ){
          //  $findQuery->select(['order_item'.'order_id']);
        //}]);
       // $findQuery->viaTable('order_item', ['order_id' => 'o.id']);
        //$findQuery->innerJoin('order_item as oi', 'oi.order_id = o.id');
        $findQuery->where(['o.id'=>$order_id]);
        return $findQuery;
    }
}