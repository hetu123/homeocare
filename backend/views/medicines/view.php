<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model common\models\Medicines */

$this->title = $model->name;
$id = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Medicines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="medicines-view">

    <!--<h1><? /*= Html::encode($this->title) */ ?></h1>

    <p>
        <? /*= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) */ ?>
        <? /*= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */ ?>
    </p>-->

    <?php
    function getCategory($model)
    {
        $myMemberModel = \common\models\Category::find()->alias('c')->select(['c.id', 'name'])->leftJoin('medicine_category as mc', 'mc.category_id = c.id')->where(['mc.medicine_id' => $model->id])->all();
        $sub_ids = '';
        if (isset($myMemberModel)) {
            $i = 0;
            foreach ($myMemberModel as $category) {
                if ($i === 0) {
                    $sub_ids = $category['name'];
                } else {
                    $sub_ids = $sub_ids . ', ' . $category['name'];
                }
                $i++;
            }
            return $sub_ids;
        } else {
            return 'Not Assign';
        }
    }

    function getComposition($model)
    {
        $myMemberModel =  \common\models\Composition::find()->alias('cm')->select(['cm.id','name','weight','weight_type'])->leftJoin('medicine_composition as mc', 'mc.composition_id = cm.id')->where(['mc.medicine_id'=> $model->id ])->all();
        $sub_ids = '';
        if (isset($myMemberModel) ){
            $i = 0;
            foreach ($myMemberModel as $category){
                if($i === 0){
                    $sub_ids = $category['name']."\t\t".$category['weight'].$category['weight_type'];
                }
                else{
                    $sub_ids = $sub_ids.",". $category['name']."\t\t".$category['weight'].$category['weight_type'];
                }
                $i++;
            }
            return $sub_ids;
        } else {
            return 'Not Assign';
        }
    }
    function getIndications($model){
        $myMemberModel =  \common\models\Ingredients::find()->alias('in')->select(['in.id','name'])->leftJoin('medicine_ingredient   as mi', 'mi.ingredient_id = in.id')->where(['mi.medicine_id'=> $model->id ])->all();
        $sub_ids = '';
        if (isset($myMemberModel) ){
            $i = 0;
            foreach ($myMemberModel as $category){
                if($i === 0){
                    $sub_ids = $category['name'];
                }
                else{
                    $sub_ids = $sub_ids.",". $category['name'];
                }
                $i++;
            }
            return $sub_ids;
        } else {
            return 'Not Assign';
        }
    }
    function getTypes($model){
        $myMemberModel =  \common\models\Type::find()->alias('t')->select(['t.id','type'])->leftJoin('medicine_type   as mt', 'mt.type_id = t.id')->where(['mt.medicine_id'=> $model->id ])->all();
        $sub_ids = '';
        if (isset($myMemberModel) ){
            $i = 0;
            foreach ($myMemberModel as $category){
                if($i === 0){
                    $sub_ids = $category['type'];
                }
                else{
                    $sub_ids = $sub_ids.",". $category['type'];
                }
                $i++;
            }
            return $sub_ids;
        } else {
            return 'Not Assign';
        }
    }
    function getBrands($model){
        $myMemberModel =  \common\models\Brand::find()->alias('b')->select(['b.id','name'])->leftJoin('medicine_brand  as mb', 'mb.brand_id = b.id')->where(['mb.medicine_id'=> $model->id ])->all();
        $sub_ids = '';
        if (isset($myMemberModel) ){
            $i = 0;
            foreach ($myMemberModel as $category){
                if($i === 0){
                    $sub_ids = $category['name'];
                }
                else{
                    $sub_ids = $sub_ids.",". $category['name'];
                }
                $i++;
            }
            return $sub_ids;
        } else {
            return 'Not Assign';
        }
    }
    function getPackings($model){
        $myMemberModel =  \common\models\Packing::find()->alias('p')->select(['p.id','weight','weight_type'])->leftJoin('medicine_packing  as mp', 'mp.packing_id = p.id')->where(['mp.medicine_id'=> $model->id ])->all();
        $sub_ids = '';
        if (isset($myMemberModel) ){
            $i = 0;
            foreach ($myMemberModel as $category){
                if($i === 0){
                    $sub_ids = $category['weight'].$category['weight_type'];
                }
                else{
                    $sub_ids = $sub_ids.",". $category['weight'].$category['weight_type'];
                }
                $i++;
            }
            return $sub_ids;
        } else {
            return 'Not Assign';
        }
    }
    function getConditions($model){
        $myMemberModel =  \common\models\Conditions::find()->alias('c')->select(['c.id','condition'])->leftJoin('medicine_conditions as mc', 'mc.condition_id = c.id')->where(['mc.medicine_id'=> $model->id ])->all();
        $sub_ids = '';
        if (isset($myMemberModel) ){
            $i = 0;
            foreach ($myMemberModel as $category){
                if($i === 0){
                    $sub_ids = $category['condition'];
                }
                else{
                    $sub_ids = $sub_ids.",". $category['condition'];
                }
                $i++;
            }
            return $sub_ids;
        } else {
            return 'Not Assign';
        }
    }
    ?>

    <?= DetailView::widget([
        'model' => $model,

        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],

        'attributes' => [
            'id',
            //  'code',
            'name',
            'gujrati_name',
            'hindi_name',

            /* [

                 $myMemberModel =  \common\models\Category::find()->alias('c')->select(['c.id','name'])->leftJoin('medicine_category as mc', 'mc.category_id = c.id')->where(['mc.medicine_id'=> $model->id])->all(),

                 'attribute' => 'category_id',
                 'format' => 'raw',
                 'value'=>(($myMemberModel != Null) ? $myMemberModel->name:'Not Assign'),
             ],*/

            [
                'attribute' => 'category_id',
                'format' => 'raw',
                'value' => getCategory($model),
            ],
            [
                'attribute' => 'composition_id',
                'format' => 'raw',
                'value' => getComposition($model),
            ],
            [
                'attribute' => 'ingredient_id',
                'format' => 'raw',
                'value' => getIndications($model),
            ],
            [
            'attribute' => 'type_id',
            'format' => 'raw',
            'value' => getTypes($model),
            ],
            [
                'attribute' => 'brand_id',
                'format' => 'raw',
                'value' => getBrands($model),
            ],
            [
                'attribute' => 'packing_id',
                'format' => 'raw',
                'value' => getPackings($model),
            ],
            [
                'attribute' => 'condition_id',
                'format' => 'raw',
                'value' => getConditions($model),
            ],
            'description:ntext',
            'gujrati_description:ntext',
            'hindi_description:ntext',
            'dosages:ntext',
            'solution_for:ntext',
            'direction:ntext',
            'indications:ntext',
            'tags:ntext',
            'gujrati_tags:ntext',
            'hindi_tags:ntext',
//            'total_stock',
//            'use_stock',
//            'left_stock',
            'is_active',
            /* [
                 'label' => 'Is Active',
                 'attribute' => 'is_active',
                 // 'class' => 'yii\grid\ActionColumn',


                 'filter' => [
                     '1' => 'active',
                     '0' => 'inactive'
                 ],

                 // translate lookup value
                 'value' => function ($model) {
                     $active = [
                         '1' => 'active',
                         '0' => 'inactive'
                     ];

                     return $active[$model->is_active];
                 },

             ],*/
            //  'expiry_date',

            'price',
            [
                'attribute' => 'expiry_date',
                'format' => ['date', 'd-m-Y'],
                'type' => DetailView::INPUT_WIDGET, // enables you to use any widget
                'widgetOptions' => [
                    'class' => DateControl::classname(),
                    'type' => DateControl::FORMAT_DATE
                ]
            ],
            [
                'attribute' => 'created_at',
                'format' => [
                    'datetime', (isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime']))
                        ? Yii::$app->modules['datecontrol']['displaySettings']['datetime']
                        : 'd-m-Y H:i:s A'
                ],
                'type' => DetailView::INPUT_WIDGET,
                'widgetOptions' => [
                    'class' => DateControl::classname(),
                    'type' => DateControl::FORMAT_DATETIME
                ]
            ],
            [
                'attribute' => 'updated_at',
                'format' => [
                    'datetime', (isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime']))
                        ? Yii::$app->modules['datecontrol']['displaySettings']['datetime']
                        : 'd-m-Y H:i:s A'
                ],
                'type' => DetailView::INPUT_WIDGET,
                'widgetOptions' => [
                    'class' => DateControl::classname(),
                    'type' => DateControl::FORMAT_DATETIME
                ]
            ],

        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
