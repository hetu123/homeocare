<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MedicineCompositionBase */

$this->title = 'Update Medicines Ingredient: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Medicines Ingredients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="medicines-ingredient-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
