<?php

use yii\bootstrap4\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Каталог';
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin([
        'id' => 'catalog-pjax',
        'enablePushState' => false, 
        'timeout' => 5000, 
    ]); ?>
    <div class="row">
        <div class="col-6">
            <p>Сортировать по:</p>
            <div class="row sort">
                <div class="sort-item first-item"><?= $dataProvider->sort->link('title')  ?></div>
                <div class="sort-item"><?= $dataProvider->sort->link('price')  ?></div>
                <div class="sort-item last-item"><?= $dataProvider->sort->link('year')  ?></div>
            </div>
        </div>
        <div class="col-6">
            <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'id' => 'form-search',
            'options' => [
                'data-pjax' => 1
            ],
        ]); ?>

            <?php
                $params = [
                    'prompt' => 'Все категории'
                ];
                echo $form->field($searchModel, 'category_id', ['options' =>[]])->dropDownList($categories, $params)->label('Выберете категорию');
            ?>

            <div class="form-group">
                <?# Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div>
            <?= Html::a('Сбросить все', ['/catalog'], ['class' => 'btn btn-outline-secondary m-3']) ?>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '<div class="row">{items}</div>{pager}',
        'itemOptions' => ['class' => 'item m-3'],
        'pager' => ['class' => \yii\bootstrap4\LinkPager::class],
        'itemView' => function ($model, $key, $index, $widget) {
            return '<div class="card border-secondary mb-3 shop-cart" style="max-width: 15rem;">
                <div>'
                    . Html::a('<img class="card-img-top img-card photo-shop-cart" src="/uploads/' . $model['photo'] . '" alt="Фото товара">',
                    ['/catalog/view?id=' . $model['id']])
                .'</div>
                <div class="card-body text-secondary">'
                    . Html::a('<h5 class="card-title title-book">' . $model['title'] . '</h5>',
                        ['/catalog/view?id=' . $model['id']])
                    . '<p class="card-text font-weight-bold text-success">' . $model['price'] . ' руб.</p>
                    <div class="btn-group">'
                    . ((!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin) ?
                        Html::a('В корзину', [''], ['data-id' => $model['id'], 'class' => "btn btn-sm btn-outline-primary add"]) : '')
                    . '</div>
                </div>
            </div>';
        },
    ]) ?>

    <?php Pjax::end(); ?>

</div>
