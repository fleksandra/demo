<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
$this->title = $model->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <div class="row pt-5">
        <div class="col-5 text-center">
            <?= Html::img('/uploads/' .$model->photo, ['alt'=>'Фото товара', 'class' => 'photo-shop-view pb-3']) ?>
            <p class="font-weight-bold text-success"><?= $model->price ?> руб.</p>
            <p>Осталось: <?= $model->count ?>шт.</p>
        </div>
        <div class="col-7">
            <div class="row">
                <div class="col-5">
                    <p class="font-weight-bold">Название:</p>
                    <p class="font-weight-bold">Категория:</p>
                    <p class="font-weight-bold">Модель:</p>
                    <p class="font-weight-bold">Страна производителя:</p>
                    <p class="font-weight-bold">Год выпуска:</p>
                </div>
                <div class="col-7 mb-3">
                    <p><?= $model->title ?></p>
                    <p><?= $category[$model->category_id] ?></p>
                    <p><?= $model->model ?></p>
                    <p><?= $model->country ?></p>
                    <p><?= $model->year ?></p>
                </div>
            </div>
            <p>
                <?= "<div>"
                .(!(Yii::$app->user->isGuest || Yii::$app->user->identity->isAdmin) ?
                        Html::a('Добавить в корзину', [''], ['data-book-id' => $model['id'], 'class' => "btn btn-primary add", 'id' => 'btn-add-' . $model['id']]) : '')
                ."</div>"; ?>
            </p>
        </div>
    </div>
</div>
