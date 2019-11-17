<?php

use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

   <!-- <h1><?/*= Html::encode($this->title) */?></h1>

    <p>
        <?/*= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) */?>
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
            'fullname',
            'username',
           // 'gender',
            [
                'attribute' => 'gender',
                'value' => function ($model) {
                    /** @var User $model */
                    if ($model->gender == "f") {
                        return "F";
                    } else {
                        return "M";
                    }
                }, 'format' => 'raw', 'filter' => Html::activeDropDownList($searchModel, 'gender', ['' => 'All', 'm' => 'Male', 'f' => 'Female'], ['class' => 'form-control'])
            ],

            'email:email',
            'address',
            'phonenumber',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
          //  'profile_pic',
            [

                'attribute'=>'profile_pic',

                //  'value'=>$model->image,

                'format' => ['image',['width'=>'100','height'=>'100']],

            ],
            //'google_id',
            //'facebook_id',
           // 'status',
            [
                'label' => 'Status',
                'attribute' => 'status',
                // 'class' => 'yii\grid\ActionColumn',


                'filter' => [
                    '10' => 'active',
                    '9' => 'inactive'
                ],

                // translate lookup value
                'value' => function ($model) {
                    $active = [
                        '10' => 'active',
                        '9' => 'inactive'
                    ];

                    return $active[$model->status];
                },
                'contentOptions' =>function ($model, $key, $index, $column)
                {
                    if($model->status=='10'){
                        return ['style' =>'width:100px','class'=>'btn btn-success','onclick'=>"activeUser($model->id)"];

                    }
                    else
                    {
                        return ['style' =>'width:100px','class'=>'btn btn-danger','onclick'=>"activeUser($model->id)"];
                    }

                },
            ],

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
            //'verification_token',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [

                    'delete' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                            ['/user/delete', 'id' => $model->id],
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
            //'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?></div>


<script>
    function activeUser($id){
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/user/active' ?>',
            type: 'post',
            data: {id: $id },
            success: function (data) {
                location. reload(true);
                alert(data);

            }
        });
    }

</script>

