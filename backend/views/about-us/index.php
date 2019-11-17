<?php

use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AboutUsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'About uses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="about-us-index">

    <!-- <h1> Html::encode($this->title) </h1> -->

    <!-- <p>
         Html::a('Create About Us', ['create'], ['class' => 'btn btn-success']) 
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'description:ntext',
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
                    /*'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            ['/deal/update', 'id' => $model->id],
                            [
                                'title' => Yii::t('yii', 'Update'),
                                'data' => [
                                    'confirm' => 'Are you sure you want to update this item?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },*/
                    'delete' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                            ['/about-us/delete', 'id' => $model->id],
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
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => false,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type' => 'info',
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?></div>
