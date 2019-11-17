<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Conditions */

$this->title = 'Update Conditions: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Conditions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="conditions-update">

<!--    <h1><?/*= Html::encode($this->title) */?></h1>
-->
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
