<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BlogThumbnailImages */

$this->title = 'Create Blog Thumbnail Images';
$this->params['breadcrumbs'][] = ['label' => 'Blog Thumbnail Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-thumbnail-images-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
