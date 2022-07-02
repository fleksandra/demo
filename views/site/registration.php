<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Регистрация';

?>

<div class="site-registration mx-auto text-center mt-5">
<h1 class="text-center"><?= Html::encode($this->title) ?></h1>
        <div class="row">
            <div class="col-lg-5 col-sm-7 col-12 mx-auto">

                <?php $form = ActiveForm::begin([
                    'id' => 'registration-form',
                    //'enableAjaxValidation' => true,
                ]); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'surname')->textInput() ?>

                <?= $form->field($model, 'patronymic')->textInput() ?>

                <?= $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput(['email']) ?>

                <?= $form->field($model, 'login', ['enableAjaxValidation' => true])->textInput() ?>

                <?= $form->field($model, 'password', ['enableAjaxValidation' => true])->passwordInput() ?>

                <?= $form->field($model, 'password_repeat')->passwordInput() ?>

                <?= $form->field($model, 'rules')->checkbox() ?>

                <div class="form-group mx-auto">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'registration-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
</div>