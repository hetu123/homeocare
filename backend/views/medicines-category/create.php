<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MedicineCategory */

$this->title = 'Create Medicines Category';
$this->params['breadcrumbs'][] = ['label' => 'Medicines Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicines-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
