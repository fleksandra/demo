<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = $model->id;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h1 class="pb-5 pt-3 text-center">Заказ № <?= Html::encode($this->title) ?></h1>
    <div class="pb-3">
        <?php 
        if($model['status_id'] == $statusNew) : ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Отменить заказ',
                        'method' => 'post',
                    ],
                ]) ?>
        <?php endif; ?>
        <?= Html::a('Личный кабинет', ['/profile'], ['class' => 'btn btn-outline-primary'])?>
    </div>
    <div class="row mt-3">
        <div class="col-4"><p class="font-weight-bold">Статус заказа:</p></div>
        <div class="col-8"><?= $status[$model['status_id']] ?></div>
    </div>
    <?php if($status[$model['status_id']] == 'Отмененный') : ?>
        <div class="row">
            <div class="col-4"><p class="font-weight-bold">Причина отказа:</p></div>
            <div class="col-8"><?= $model['refusal'] ?></div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-4"><p class="font-weight-bold">Дата совершения заказа:</p></div>
        <div class="col-8"><?= $model['timestamp'] ?></div>
    </div>
    <div class="row">
        <div class="col-4"><p class="font-weight-bold">Количество товара:</p></div>
        <div class="col-8"><?= $model['count'] ?> шт.</div>
    </div>
    <div class="row">
        <div class="col-4"><p class="font-weight-bold">Сумма:</p></div>
        <div class="col-8"><?= $model['sum_price'] ?> руб.</div>
    </div>
    <div class="row">
        <div class="col-4"><p class="font-weight-bold">Состав заказа:</p></div>
        <div class="col-8">
            <table>
                <?php 
                    foreach($products as $val) {
                        echo '<tr>
                                <td><a href="/catalog/view?id='.$val['product_id'] .'">' .Html::img('/uploads/' .$val['photo'], ['class' => 'photo-shop']) .'</a></td>
                                <td>' .Html::a($val['title'], ["/catalog/view?id={$val['product_id']}"]) .'</td>
                                <td>' .$val['count'] .' шт.</td>
                                <td>' .$val['price']*$val['count'] .' руб.</td>
                            </tr>';
                    }
                ?>
            </table>
        </div>
    </div>
</div>
