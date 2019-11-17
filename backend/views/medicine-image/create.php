<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MedicineImage */

$this->title = 'Create Medicine Image';
$this->params['breadcrumbs'][] = ['label' => 'Medicine Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicine-image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
