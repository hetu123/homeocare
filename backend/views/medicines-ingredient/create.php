<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MedicineCompositionBase */

$this->title = 'Create Medicines Ingredient';
$this->params['breadcrumbs'][] = ['label' => 'Medicines Ingredients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicines-ingredient-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
