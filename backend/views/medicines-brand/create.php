<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MedicineBrand */

$this->title = 'Create Medicines Brand';
$this->params['breadcrumbs'][] = ['label' => 'Medicines Brands', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicines-brand-create">

<!--    <h1><?/*= Html::encode($this->title) */?></h1>
-->
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
