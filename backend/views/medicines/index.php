<?php

use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MedicinesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Medicines';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$languages = \common\models\Language::find()->all();

$languageData = ['' => 'All'];

foreach ($languages as $language) {
    $languageData[$language['id']] = $language['name'];
}

?>

<div class="medicines-index">

   <!-- <h1><?/*= Html::encode($this->title) */?></h1>

    <p>
        <?/*= Html::a('Create Medicines', ['create'], ['class' => 'btn btn-success']) */?>
    </p>-->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); echo \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [ 'attribute' => 'id', 'value' => function ($model) {
                return Html::a($model->id, \yii\helpers\Url::toRoute(['update', 'id'=>$model->id]), [ 'title' => Yii::t('app', 'Click to edit')]);
            }, 'format' => 'raw', 'filter' => true,
            ],
          //  [ 'attribute' => 'language_id', 'value' => 'language.name', 'format' => 'raw', 'filter' => Html::activeDropDownList($searchModel, 'language_id', $languageData, [ 'class' => 'form-control'])],
          //  'code',
            'name',
            'gujrati_name',
            'hindi_name',
            ['attribute' => 'category_id',
                'value' => function ($model) {
                    $myMemberModel =  \common\models\Category::find()->alias('c')->select(['c.id','name'])->leftJoin('medicine_category as mc', 'mc.category_id = c.id')->where(['mc.medicine_id'=> $model->id ])->all();
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
                },
                'filter' => Html::activeDropDownList($searchModel, 'category_id', \yii\helpers\ArrayHelper::map(\common\models\Category::find()->orderBy('name')->where(['is_active'=>1])->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Select Category']),
            ],
            ['attribute' => 'composition_id',
                'value' => function ($model) {
                    $myMemberModel =  \common\models\Composition::find()->alias('cm')->select(['cm.id','name','weight','weight_type'])->leftJoin('medicine_composition as mc', 'mc.composition_id = cm.id')->where(['mc.medicine_id'=> $model->id ])->all();
                    $sub_ids = '';
                    if (isset($myMemberModel) ){
                        $i = 0;
                        foreach ($myMemberModel as $composition){
                            if($i === 0){
                                $sub_ids = $composition['name']."\t\t".$composition['weight'].$composition['weight_type'];
                            }
                            else{
                                $sub_ids = $sub_ids.",". $composition['name']."\t\t".$composition['weight'].$composition['weight_type'];
                            }
                            $i++;
                        }
                        return $sub_ids;
                    } else {
                        return 'Not Assign';
                    }
                },
                'filter' => Html::activeDropDownList($searchModel, 'composition_id', \yii\helpers\ArrayHelper::map(\common\models\Composition::find()->orderBy('name')->where(['is_active'=>1])->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Select Composition']),

            ],
            ['attribute' => 'ingredient_id',
                'value' => function ($model) {
                    $myMemberModel =  \common\models\Ingredients::find()->alias('in')->select(['in.id','name'])->leftJoin('medicine_ingredient   as mi', 'mi.ingredient_id = in.id')->where(['mi.medicine_id'=> $model->id ])->all();
                    $sub_ids = '';
                    if (isset($myMemberModel) ){
                        $i = 0;
                        foreach ($myMemberModel as $ingredient){
                            if($i === 0){
                                $sub_ids = $ingredient['name'];
                            }
                            else{
                                $sub_ids = $sub_ids.",". $ingredient['name'];
                            }
                            $i++;
                        }
                        return $sub_ids;
                    } else {
                        return 'Not Assign';
                    }
                },
                'filter' => Html::activeDropDownList($searchModel, 'ingredient_id', \yii\helpers\ArrayHelper::map(\common\models\Ingredients::find()->orderBy('name')->where(['is_active'=>1])->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Select Ingredients']),

            ],
            ['attribute' => 'type_id',
                'value' => function ($model) {
                    $myMemberModel =  \common\models\Type::find()->alias('t')->select(['t.id','type'])->leftJoin('medicine_type   as mt', 'mt.type_id = t.id')->where(['mt.medicine_id'=> $model->id ])->all();
                    $sub_ids = '';
                    if (isset($myMemberModel) ){
                        $i = 0;
                        foreach ($myMemberModel as $type){
                            if($i === 0){
                                $sub_ids = $type['type'];
                            }
                            else{
                                $sub_ids = $sub_ids.",". $type['type'];
                            }
                            $i++;
                        }
                        return $sub_ids;
                    } else {
                        return 'Not Assign';
                    }
                },
                'filter' => Html::activeDropDownList($searchModel, 'type_id', \yii\helpers\ArrayHelper::map(\common\models\Type::find()->orderBy('type')->where(['is_active'=>1])->asArray()->all(), 'id', 'type'),['class'=>'form-control','prompt' => 'Select Types']),

            ],
            ['attribute' => 'brand_id',
                'value' => function ($model) {
                    $myMemberModel =  \common\models\Brand::find()->alias('b')->select(['b.id','name'])->leftJoin('medicine_brand  as mb', 'mb.brand_id = b.id')->where(['mb.medicine_id'=> $model->id ])->all();
                    $sub_ids = '';
                    if (isset($myMemberModel) ){
                        $i = 0;
                        foreach ($myMemberModel as $brand){
                            if($i === 0){
                                $sub_ids = $brand['name'];
                            }
                            else{
                                $sub_ids = $sub_ids.",". $brand['name'];
                            }
                            $i++;
                        }
                        return $sub_ids;
                    } else {
                        return 'Not Assign';
                    }
                },
                'filter' => Html::activeDropDownList($searchModel, 'brand_id', \yii\helpers\ArrayHelper::map(\common\models\Brand::find()->where(['is_active'=>1])->orderBy('name')->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Select Brands']),

            ],
            ['attribute' => 'packing_id',
                'value' => function ($model) {
                    $myMemberModel =  \common\models\Packing::find()->alias('p')->select(['p.id','weight','weight_type'])->leftJoin('medicine_packing  as mp', 'mp.packing_id = p.id')->where(['mp.medicine_id'=> $model->id ])->all();
                    $sub_ids = '';
                    if (isset($myMemberModel) ){
                        $i = 0;
                        foreach ($myMemberModel as $packing){
                            if($i === 0){
                                $sub_ids = $packing['weight'].$packing['weight_type'];
                            }
                            else{
                                $sub_ids = $sub_ids.",". $packing['weight'].$packing['weight_type'];
                            }
                            $i++;
                        }
                        return $sub_ids;
                    } else {
                        return 'Not Assign';
                    }
                },
                'filter' => Html::activeDropDownList($searchModel, 'packing_id', \yii\helpers\ArrayHelper::map(\common\models\Packing::find()->asArray()->orderBy('weight')->all(), 'id', 'weight'),['class'=>'form-control','prompt' => 'Select Packings']),

            ],
            ['attribute' => 'condition_id',
                'value' => function ($model) {
                    $myMemberModel =  \common\models\Conditions::find()->alias('c')->select(['c.id','condition'])->leftJoin('medicine_conditions as mc', 'mc.condition_id = c.id')->where(['mc.medicine_id'=> $model->id ])->all();
                    $sub_ids = '';
                    if (isset($myMemberModel) ){
                        $i = 0;
                        foreach ($myMemberModel as $condition){
                            if($i === 0){
                                $sub_ids = $condition['condition'];
                            }
                            else{
                                $sub_ids = $sub_ids.",". $condition['condition'];
                            }
                            $i++;
                        }
                        return $sub_ids;
                    } else {
                        return 'Not Assign';
                    }
                },
                'filter' => Html::activeDropDownList($searchModel, 'condition_id', \yii\helpers\ArrayHelper::map(\common\models\Conditions::find()->orderBy('condition')->asArray()->all(), 'id', 'condition'),['class'=>'form-control','prompt' => 'Select Condition']),

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
            [
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
                'contentOptions' =>function ($model, $key, $index, $column)
                {
                    if($model->is_active=='1'){
                        return ['style' =>'width:100px','class'=>'btn btn-success','onclick'=>"activeMedicine($model->id)"];

                    }
                    else
                    {
                        return ['style' =>'width:100px','class'=>'btn btn-danger','onclick'=>"activeMedicine($model->id)"];
                    }

                },
            ],
            [
                'attribute' => 'manufacture_date',
                'value' => function ($model){
                    if(!empty($model->manufacture_date)){
                        return $model->manufacture_date;
                    } else {
                        $manufacture_date = "-";
                        return $manufacture_date;
                    }
                },
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'manufacture_date',
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ])
            ],[
                'attribute' => 'expiry_date',
                'value' => function ($model){
                    if(!empty($model->expiry_date)){
                        return $model->expiry_date;
                    } else {
                        $expiry_date = "-";
                        return $expiry_date;
                    }
                },
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'expiry_date',
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ])
            ],
            'price',
            'MRP',
            [
                'attribute' => 'created_at',
                'value' => function ($model){
                    if(!empty($model->created_at)){
                        return $model->created_at;
                    } else {
                        $created_date = "-";
                        return $created_date;
                    }
                },
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ])
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model){
                    if(!empty($model->updated_at)){
                        return $model->updated_at;
                    } else {
                        $end_date = "-";
                        return $end_date;
                    }
                },
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'updated_at',
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ])
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete} {view}',
                'buttons' => [

                    'delete' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                            ['/medicines/delete', 'id' => $model->id],
                            [
                                'title' => Yii::t('yii', 'Delete'),
                                'class' => '',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]);
                    },
                ],
            ],
        ],
        'toolbar' =>  [
//            ['content'=>
//                Html::a('<i class="glyphicon glyphicon-plus"></i> Add Quantity', ['add-quantity'], ['class' => 'btn btn-success'])
//            ],
            '{export}',
            '{toggleData}'
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => false,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type' => 'info',
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            'button'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
        'persistResize' => false,
        'toggleDataOptions' => ['minCount' => 10],
    ]); Pjax::end(); ?></div>
<script>
    function activeMedicine($id){
        var result = confirm("Are you sure ?");
        if(result) {
            $.ajax({
                url: '<?php echo Yii::$app->request->baseUrl . '/medicines/active' ?>',
                type: 'post',
                data: {id: $id},
                success: function (data) {
                    location.reload(true);
                }
            });
        }
    }

</script>
