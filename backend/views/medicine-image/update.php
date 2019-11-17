<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MedicineImage */

$this->title = 'Update Medicine Image: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Medicine Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="medicine-image-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
