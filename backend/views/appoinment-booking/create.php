<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AppoinmentBooking */

$this->title = 'Create Appoinment Booking';
$this->params['breadcrumbs'][] = ['label' => 'Appoinment Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appoinment-booking-create">

    <!-- <h1> Html::encode($this->title) </h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
