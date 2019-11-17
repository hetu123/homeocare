<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MedicineType */

$this->title = 'Create Medicines Type';
$this->params['breadcrumbs'][] = ['label' => 'Medicines Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicines-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
