<?php

use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$languages = \common\models\Language::find()->all();

$languageData = ['' => 'All'];

foreach ($languages as $language) {
    $languageData[$language['id']] = $language['name'];
}

$categories = \common\models\Category::find()->all();

$categoriesData = ['' => 'All'];

foreach ($categories as $category) {
    $categoriesData[$category['id']] = $category['name'];
}

?>

<div class="category-index">

<!--    <h1><?/*= Html::encode($this->title) */?></h1>
-->
   <!-- <p>
        <?/*= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) */?>
    </p>-->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [ 'attribute' => 'id', 'value' => function ($model) {
                return Html::a($model->id, \yii\helpers\Url::toRoute(['update', 'id'=>$model->id]), [ 'title' => Yii::t('app', 'Click to edit')]);
            }, 'format' => 'raw', 'filter' => true,
            ],
          //  [ 'attribute' => 'language_id', 'value' => 'language.name', 'format' => 'raw', 'filter' => Html::activeDropDownList($searchModel, 'language_id', $languageData, [ 'class' => 'form-control'])],
            'name',
            // 'pid',
            [
                'attribute' => 'pid',
                'value' => function ($model){

                    if($model->pid == 0){
                        return Html::label('Parent');
                    } else {
                       // return Html::label('category.name');
                        return Html::label(''.$model->pid.'');
                    }
                },'format' => 'raw',

            ],
         //   [ 'attribute' => 'pid', 'value' => 'pid.name', 'format' => 'raw', 'filter' => Html::activeDropDownList($searchModel, 'pid', $categoriesData, [ 'class' => 'form-control'])],



            'description:ntext',
           // 'image',
            [

                'attribute'=>'image',

                //  'value'=>$model->image,

                'format' => ['image',['width'=>'100','height'=>'100']],

            ],
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
                        return ['style' =>'width:100px','class'=>'btn btn-success','onclick'=>"activeCategory($model->id)"];

                    }
                    else
                    {
                        return ['style' =>'width:100px','class'=>'btn btn-danger','onclick'=>"activeCategory($model->id)"];
                    }

                },
            ],
            //'is_active',
            //'created_at',
            //'updated_at',
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
                'attribute' => 'end_date',
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
                            ['/category/delete', 'id' => $model->id],
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



<script>
    function activeCategory($id){
        var result = confirm("Are you sure ?");
        if(result) {
            $.ajax({
                url: '<?php echo Yii::$app->request->baseUrl . '/category/active' ?>',
                type: 'post',
                data: {id: $id},
                success: function (data) {
                    location.reload(true);
                }
            });
        }
    }

</script>
