<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CompositionOrder */


?>
<div class="composition-order-create">
    <div class="text-center">
        <h2>Состав заказа</h2>
        <p>Проверте соста вашего заказа</p>
    </div>
    <?= $this->render('/cart/view', ['cart' => Yii::$app->session->get('cart'),  'btn_no' => true]); ?>
    <div class="text-center m-3" id="agree">
        <p class="p-3">Для подтверждения заказа введите свой пароль</p>
        <?php $form = ActiveForm::begin([
            'id' => 'confirm-form',
            'fieldConfig' => [
                'inputOptions' => ['class' => 'col-lg-5 form-control mx-auto'],
            ],
            'enableAjaxValidation' => true,
            ]); ?>
            
                <?= $form->field($login, 'password')->passwordInput(['placeholder' => "Введите ваш пароль", 'id' => 'psw'])->label(false) ?>

                <?= Html::submitButton('Сформировать заказ', ['class' => 'btn btn-primary', 'name' => 'confirm-button', 'id' => 'agree']) ?>

            <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
    //$this->registerJsFile('/web/js/order.js', ['depends' => ['yii\web\YiiAsset', 'yii\bootstrap4\BootstrapAsset'], 'position' => yii\web\View::POS_END]);
?>
