<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Medicines */

$this->title = 'Update Medicines: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Medicines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="medicines-update">

<!--    <h1><?/*= Html::encode($this->title) */?></h1>
-->
    <?= $this->render('_form', [
        'model' => $model,
        'image'=>$image,
        'selectedCategoryIds' => $selectedCategoryIds,
        'selectedTypeIds'=>$selectedTypeIds,
        'selectedBrandIds'=>$selectedBrandIds,
        'selectedCompositionIds'=>$selectedCompositionIds,
        'selectedIngredientIds'=>$selectedIngredientIds,
        'selectedPackingIds'=>$selectedPackingIds,
        'selectedConditionIds'=>$selectedConditionIds,
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
