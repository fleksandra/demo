<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Изменение товара: ' . $model->title;
?>
<div class="product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_file' => $model_file,
        'categories' => $categories,
        'update' => $update,
    ]) ?>

</div>
