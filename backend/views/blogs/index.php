<?php

use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BlogsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blogs';
$this->params['breadcrumbs'][] = $this->title;
$newses = \common\models\Blogs::find()->all();
$newsData = ['' => 'All'];

?>
<?php
$languages = \common\models\Language::find()->all();

$languageData = ['' => 'All'];

foreach ($languages as $language) {
    $languageData[$language['id']] = $language['name'];
}


?>
<div class="blogs-index">


    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            [ 'attribute' => 'id', 'value' => function ($model) {
                return Html::a($model->id, \yii\helpers\Url::toRoute(['update', 'id'=>$model->id]), [ 'title' => Yii::t('app', 'Click to edit')]);
            }, 'format' => 'raw', 'filter' => true,
            ],
         //   [ 'attribute' => 'language_id', 'value' => 'language.name', 'format' => 'raw', 'filter' => Html::activeDropDownList($searchModel, 'language_id', $languageData, [ 'class' => 'form-control'])],

            'title',
            'excerpt',
            'offer_url',
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
                            ['/blogs/delete', 'id' => $model->id],
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
