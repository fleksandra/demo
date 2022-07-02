<?php

use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
?>

<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Управление категориями', ['admin-category/index'], ['class' => 'btn btn-success']) ?>
        <?= !empty($count_category) ? Html::a('Управление товарами', ['admin-product/index'], ['class' => 'btn btn-success']) : '' ?>
    </p>
    <h3 class="p-3 text-center">Новые заказы</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showOnEmpty' => '',
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '-',
        ],
        'columns' => [

            [
                'attribute' => 'timestamp',
                'filter' => false,
                
            ],
            [
                'attribute' => 'id',
                'filter' => false,
                
            ],
            [
                'attribute' => 'user_id',
                'label' => 'ФИО',
                'value' => function($model) use($user) {
                    return $user[$model['user_id']];
                },
                'filter' => false,
                
            ],
            [
                'attribute' => 'count',
                'filter' => false,
                
            ],
            [
                'attribute' => 'status_id',
                'value' => function($model) use($status) {
                    return $status[$model['status_id']];
                },
                'filter' => false,
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {confirm} {refusal}',
                'buttons' => [
                    'confirm' => function ($url, $model) use($statusNew) {
                        if($model['status_id'] == $statusNew) {
                            return Html::a('Подтвердить', $url, ['class' => 'btn btn-success confirm m-1']);
                        }
                    },
                    'refusal' => function ($url, $model) use($statusNew) {
                        if($model['status_id'] == $statusNew) {
                            return Html::a('Отклонить', $url, ['class' => 'btn btn-danger refusal m-1']);
                        }
                    },
                    'view' => function ($url, $model) {
                        return Html::a('Подробнее', $url, ['class' => 'btn btn-primary m-1']);
                    },
                ],
            ],
        ],
    ]); ?>
    <h3 class="p-3 text-center">Выполненные заказы</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProviderOld,
        'filterModel' => $searchModel,
        'showOnEmpty' => '',
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
        ],
        'pager' => ['class' => \yii\bootstrap4\LinkPager::class],
        'columns' => [

            [
                'attribute' => 'timestamp',
                'filter' => false,
                
            ],
            [
                'attribute' => 'id',
                'filter' => false,
                
            ],
            [
                'attribute' => 'user_id',
                'label' => 'ФИО',
                'value' => function($model) use($user) {
                    return $user[$model['user_id']];
                },
                'filter' => false,
                
            ],
            [
                'attribute' => 'count',
                'filter' => false,
                
            ],
            [
                'attribute' => 'status_id',
                'value' => function($model) use($status) {
                    return $status[$model['status_id']];
                },
                'filter' => $statusOld,
            ],
            [
                'attribute' => 'refusal',
                'filter' => false,
                
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('Подробнее', $url, ['class' => 'btn btn-primary m-1']);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
