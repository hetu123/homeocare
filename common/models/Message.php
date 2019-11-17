<?php

namespace common\models;

use yii\db\Query;

class Message extends \common\models\base\MessageBase
{
    /* const TranslationColumns = ['name'];
     const SupportedLang = ['en', 'ar'];*/

    public static function findWith()
    {
        /* if ($lang == null) {
             $lang = \Yii::$app->language;
         }
         $columns = self::TranslationColumns;
         $columns[] = 'language';*/

        $findQuery = parent::find();
        $findQuery->alias('m');
        $findQuery->innerJoin('user u', 'u.id = m.from_id');
        $findQuery->innerJoin('user u1', 'u1.id = m.to_id');

        $findQuery->select(['u.profile_pic as from_profile_pic', 'u1.profile_pic as to_profile_pic', 'm.*']);

        $findQuery->addSelect(['u.fullname as from_name', 'u1.fullname as to_name']);
        return $findQuery;
    }


    public static function findWithFromId($to_id = null)
    {
        $findQuery = self::findWith();

        $findQuery->andWhere(['or', 'm.to_id='.$to_id, 'm.from_id='.$to_id]);
        $findQuery->andWhere(['<>','deletedBy',$to_id]);

        $isCount = (new Query())
            ->select('count(id)')
            ->from(self::tableName())
            // ->where('from_id = m.from_id')
            ->andWhere('to_id = m.to_id')
            ->andWhere('is_read = 0');

        $maxId = (new Query())
            ->select('max(id)')
            ->from(self::tableName())
            ->orWhere(['and', 'from_id = m.from_id', 'to_id = m.to_id'])
            ->orWhere(['and', 'from_id = m.to_id', 'to_id = m.from_id']);
        //    ->orWhere(['and', 'from_id = to_id', 'm.from_id = m.to_id']);

        // $findQuery->andWhere(['in', 'm.id' , $maxId]);

        $findQuery->addSelect(['msg_count' => $isCount]);
        //  echo $findQuery->createCommand()->getRawSql();die;

        return $findQuery;
    }

    public static function findWithToId($to_id = null, $from_id = null)
    {

        $findQuery = self::findWith();
        $findQuery->andWhere(['or', 'm.to_id=' . $to_id, 'm.to_id=' . $from_id]);
        $findQuery->andWhere(['or', 'm.from_id=' . $from_id, 'm.from_id=' . $to_id]);

        /* $findQuery->andWhere([ 'or',
           //  ['<>', 'deletedBy', $to_id],
             ['<>', 'deletedBy', $from_id],


         ]);*/

        $findQuery->orderBy('m.id');
        return $findQuery;
    }

    public static function findWithIsRead($to_id = null, $from_id = null, $lastTimestamp = null)
    {
        $findQuery = parent::find();
        $findQuery->andWhere(['or', 'to_id=' . $from_id, 'from_id=' . $to_id]);

        // $findQuery->andWhere(['or', 'to_id=' . $to_id, 'to_id=' . $from_id]);
        //$findQuery->andWhere(['or', 'from_id=' . $from_id, 'from_id=' . $to_id]);
        //$findQuery->andWhere(['>', 'created_at', $lastTimestamp]);
        return $findQuery;
    }

    public static function findById($id = null,$to_id,$from_id,$lastTimestamp = 0)
    {
        $findQuery = self::findWith();
        // $findQuery->andWhere(['m.id' => $id]);
        $findQuery->andWhere(['or', 'm.to_id=' . $to_id, 'm.to_id=' . $from_id]);
        $findQuery->andWhere(['or', 'm.from_id=' . $from_id, 'm.from_id=' . $to_id]);
        //  $findQuery->andWhere(['or', 'm.to_id='.$to_id, 'm.from_id='.$to_id]);
        $findQuery->andWhere(['>', 'm.created_at', $lastTimestamp]);
        $findQuery->orderBy(['created_at' => SORT_DESC]);
        //  $findQuery->orderBy('m.id');
        return $findQuery;
    }
    public static function findWithFromIdForLastMessage($to_id = null)
    {
        $findQuery = self::findWith();

        $findQuery->andWhere(['or', 'm.to_id='.$to_id, 'm.from_id='.$to_id]);
        $findQuery->andWhere(['<>','deletedBy',$to_id]);

        $isCount = (new Query())
            ->select('count(id)')
            ->from(self::tableName())
            // ->where('from_id = m.from_id')
            ->andWhere('to_id = m.to_id')
            ->andWhere('is_read = 0');

        $maxId = (new Query())
            ->select('max(id)')
            ->from(self::tableName())
            ->orWhere(['and', 'from_id = m.from_id', 'to_id = m.to_id'])
            ->orWhere(['and', 'from_id = m.to_id', 'to_id = m.from_id']);
        //->orWhere(['and', 'from_id = to_id', 'm.from_id = m.to_id']);

        $findQuery->andWhere(['in', 'm.id' , $maxId]);

        $findQuery->addSelect(['msg_count' => $isCount]);
        //  echo $findQuery->createCommand()->getRawSql();die;

        return $findQuery;
    }

}