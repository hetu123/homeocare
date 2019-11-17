<?php
use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TimeSlotSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Time Slots';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="time-slot-index">

    <!-- <h1> Html::encode($this->title) </h1>

    <p>
         Html::a('Create Time Slot', ['create'], ['class' => 'btn btn-success']) 
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'day',
            'morning_hours_from',
            'morning_hours_to',
            'evening_hours_from',
            'evening_hours_to',
            [
                'label' => 'Is Open',
                'attribute' => 'is_open',
                // 'class' => 'yii\grid\ActionColumn',


                'filter' => [
                    '1' => 'open',
                    '0' => 'close'
                ],

                // translate lookup value
                'value' => function ($model) {

                    $active = [
                        '1' => 'open',
                        '0' => 'close'
                    ];

                    return $active[$model->is_open];
                },
                'contentOptions' =>function ($model, $key, $index, $column)
                {
                    if($model->is_open=='1'){
                        return ['style' =>'width:100px','class'=>'btn btn-success','onclick'=>"activeCondition($model->id)"];

                    }
                    else
                    {
                        return ['style' =>'width:100px','class'=>'btn btn-danger','onclick'=>"activeCondition($model->id)"];
                    }

                },
            ],
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
                            ['/time-slot/delete', 'id' => $model->id],
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
    function activeCondition($id){
        var result = confirm("Are you sure ?");
        if(result) {
            $.ajax({
                url: '<?php echo Yii::$app->request->baseUrl . '/conditions/active' ?>',
                type: 'post',
                data: {id: $id},
                success: function (data) {
                    location.reload(true);
                }
            });
        }
    }

</script>
