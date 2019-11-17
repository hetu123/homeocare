<?php
use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AppoinmentBookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Appoinment Bookings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appoinment-booking-index">

    <!-- <h1> Html::encode($this->title) </h1>

    <p>
         Html::a('Create Appoinment Booking', ['create'], ['class' => 'btn btn-success']) 
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'age_group_id',
            'date',
            'time_slot_id:datetime',
            'symptoms',
           // 'is_approve',
            [
                'attribute'=>'is_cancel',
                'label' => 'Is Cancel',
                'filter' => [

                        '1' => 'cancel',
                        '0' => 'accept'

                ],
                'format'=>'raw',
                'value' => function($model, $key, $index)
                {
                    if($model->is_cancel == '1')
                    {
                        return '<button class="btn  btn-success" >accept</button>';
                    }
                    else
                    {
                        return '<button class="btn btn-danger">cancel</button>';
                    }
                },
            ],

            [
                'label' => 'Is Approve',
                'attribute' => 'is_approve',
                // 'class' => 'yii\grid\ActionColumn',


                'filter' => [
                    '1' => 'approve',
                    '0' => 'disapprove'
                ],

                // translate lookup value
                'value' => function ($model) {
                    $active = [
                        '1' => 'approve',
                        '0' => 'disapprove'
                    ];


                    return $active[$model->is_approve];
                },
                'contentOptions' =>function ($model, $key, $index, $column)
                {
                    if($model->is_approve=='1'){
                        return ['style' =>'width:100px','class'=>'btn btn-success','onclick'=>"approve($model->id)"];

                    }
                    else
                    {
                        return ['style' =>'width:100px','class'=>'btn btn-danger','onclick'=>"approve($model->id)"];
                    }

                },
            ],
//             'is_cancel',
//            [
//                'label' => 'Is Cancel',
//                'attribute' => 'is_cancel',
//                // 'class' => 'yii\grid\ActionColumn',
//
//
//                'filter' => [
//                    '1' => 'cancel',
//                    '0' => 'accept'
//                ],
//
//                // translate lookup value
//                'value' => function ($model) {
//                    $active = [
//                        '1' => 'cancel',
//                        '0' => 'accept'
//                    ];
//
//                    return $active[$model->is_cancel];
//                },
//                'contentOptions' =>function ($model, $key, $index, $column)
//                {
//                    if($model->is_cancel=='0'){
//                        return ['style' =>'width:100px','class'=>'btn btn-success','onclick'=>"cancel($model->id)"];
//
//                    }
//                    else
//                    {
//                        return ['style' =>'width:100px','class'=>'btn btn-danger','onclick'=>"cancel($model->id)"];
//                    }
//
//                },
//            ],
            //'status',
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
                'template' => '{view}',
                // 'buttons' => [

                //     'delete' => function($url, $model){
                //         return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                //             ['/conditions/delete', 'id' => $model->id],
                //             [
                //                 'title' => Yii::t('yii', 'Delete'),
                //                 'class' => '',
                //                 'data' => [
                //                     'confirm' => 'Are you sure you want to delete this item?',
                //                     'method' => 'post',
                //                 ],
                //             ]);
                //     },
                // ],
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
    function approve($id){
        var result = confirm("Are you sure ?");
        if(result) {
            $.ajax({
                url: '<?php echo Yii::$app->request->baseUrl . '/appoinment-booking/approve' ?>',
                type: 'post',
                data: {id: $id},
                success: function (data) {
                    location.reload(true);
                }
            });
        }
    }
    function cancel($id){
        var result = confirm("Are you sure ?");
        if(result) {
            $.ajax({
                url: '<?php echo Yii::$app->request->baseUrl . '/appoinment-booking/cancel' ?>',
                type: 'post',
                data: {id: $id},
                success: function (data) {
                    location.reload(true);
                }
            });
        }
    }

</script>
