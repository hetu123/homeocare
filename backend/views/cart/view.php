<?php

use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Cart */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Carts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cart-view">

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
    <?php
    function getMedicine($model)
    {
        $myMemberModel =  \common\models\Medicines::find()->alias('m')->select(['m.id','m.name'])->where(['m.id'=> $model->medicine_id ])->all();
        $sub_ids = '';
        if (isset($myMemberModel)) {
            $i = 0;
            foreach ($myMemberModel as $medicine) {
                if ($i === 0) {
                    $sub_ids = $medicine['name'];
                } else {
                    $sub_ids = $sub_ids . ', ' . $medicine['name'];
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
            'anonymous_identifier',
           // 'medicine_id',
            [
                'attribute' => 'medicine_id',
                'format' => 'raw',
                'value' => getMedicine($model),
            ],
            'store_price',
            'discount',
            'quantity',
            'total_price',
            'paid_price',
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


