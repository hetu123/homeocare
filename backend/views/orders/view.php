<?php

use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Orders */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="orders-view">

<!--    <h1> Html::encode($this->title) </h1>-->
<!---->
<!--    <p>-->
<!--         Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) -->
<!--         Html::a('Delete', ['delete', 'id' => $model->id], [-->
<!--            'class' => 'btn btn-danger',-->
<!--            'data' => [-->
<!--                'confirm' => 'Are you sure you want to delete this item?',-->
<!--                'method' => 'post',-->
<!--            ],-->
<!--        ]) -->
<!--    </p>-->

<!--   Html::a('View OrderItems', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) -->

    <?php
    function getPaymentMethod($model)
    {
        $myMemberModel =  \common\models\PaymentMethods::find()->alias('pm')->select(['pm.id','pm.name'])->where(['pm.id'=> $model->payment_method_id ])->all();
        $sub_ids = '';
        if (isset($myMemberModel)) {
            $i = 0;
            foreach ($myMemberModel as $payment_method) {
                if ($i === 0) {
                    $sub_ids = $payment_method['name'];
                } else {
                    $sub_ids = $sub_ids . ', ' . $payment_method['name'];
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
            'user_id',
            'address_id',
           // 'payment_method_id',
            [
                'attribute' => 'payment_method_id',
                'format' => 'raw',
                'value' => getPaymentMethod($model),
            ],
            'name',
            'email:email',
            'is_order',
          //  'card_num',
          //  'card_cvc',
          //  'card_exp_month',
          //  'card_exp_year',
            'paid_amount',
            'is_canceled',
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
        'enableEditMode' => false,
    ]) ?>

</div>
</br></br>

<div class="order-item-index">

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'order_id',
            'medicine_id',
            'item_name',
          //  'item_number',
            'item_price',
            'quantity',
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
                'template' => '',
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
  //                    'delete' => function($url, $model){
  //                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
  //                            ['/about-us/delete', 'id' => $model->id],
  //                            [
  //                                'title' => Yii::t('yii', 'Delete'),
  //                                'class' => '',
  //                                'data' => [
  //                                    'confirm' => 'Are you sure you want to delete this item?',
  //                                    'method' => 'post',
  //                                ],
  //                            ]);
  //                    },
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
