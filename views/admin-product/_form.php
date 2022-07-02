<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>
    
    <?php
    $params = [
        'prompt' => 'Выберите категорию'
    ];
    echo $form->field($model, 'category_id')->dropDownList($categories, $params);
    ?>

    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <?php
        if($update) {
            echo '<p>Фото товара</p>' .Html::img("/uploads/{$model->photo}", ['class' => 'img-update']);
            echo $form->field($model_file, 'imageFile')->fileInput()->label('Новое фото товара');
            echo '<div class="form-group">'
                .Html::submitButton('Сохранить', ['class' => 'btn btn-success'])
            .'</div>';
        } else {
    ?>

        <?= $form->field($model_file, 'imageFile')->fileInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
        </div>

        <?php }?>

    <?php ActiveForm::end(); ?>

</div>
