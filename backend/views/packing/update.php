<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Packing */

$this->title = 'Update Packing: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Packings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="packing-update">

<!--    <h1><?/*= Html::encode($this->title) */?></h1>
-->
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
