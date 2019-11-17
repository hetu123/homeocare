<?php

namespace common\models;
use yii\db\Query;

class Wishlist extends \common\models\base\WishlistBase
{
    public static function findByRelation($language_id){
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
        $findQuery = Wishlist::find();
        $findQuery->alias('w');

        //   $findQuery->andWhere(['c.medicine_id'=>$medicine_id]);
        //  $findQuery->andWhere(['c.user_id'=>$user_id]);
        $findQuery->select(['w.id','w.medicine_id']);
        if($languageCode['code'] === 'GU'){
            $findQuery->addSelect(['m.gujrati_name as name','m.gujrati_description as description']);
        }
        elseif ($languageCode['code'] === 'HN'){
            $findQuery->addSelect(['m.hindi_name as description','m.hindi_description as description']);
        }
        else{
            $findQuery->addSelect(['m.name', 'm.description']);
        }
        $findQuery->addSelect(['m.dosages', 'm.solution_for', 'm.direction', 'm.indications', 'm.left_stock',
            'm.manufacture_date', 'm.expiry_date', 'm.price', 'm.MRP']);
        $findQuery->addSelect(['cover_image'=>$coverImage]);
        $findQuery->addSelect(['default_image'=>$defaultImage]);
        $findQuery->addSelect(['sgst'=>new \yii\db\Expression('((m.price * m.total_gst)/100)/2' )]);
        $findQuery->addSelect(['cgst'=>new \yii\db\Expression('((m.price * m.total_gst)/100)/2' )]);
        $findQuery->innerJoin('medicines as m', 'm.id=w.medicine_id');
        $findQuery->asArray();

        return $findQuery;
    }
}