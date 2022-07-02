<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мои заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

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
                'attribute' => 'id',
                'filter' => false,
                
            ],
            [
                'attribute' => 'timestamp',
                'filter' => false,
                
            ],
            [
                'attribute' => 'count',
                'filter' => false,
                
            ],
            [
                'attribute' => 'sum_price',
                'filter' => false,
                
            ],
            [
                'attribute' => 'refusal',
                'filter' => false,
                
            ],
            [
                'attribute' => 'status_id',
                'value' => function($model) use($status) {
                    return $status[$model['status_id']];
                },
                'filter' => $status,
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model) use($statusNew) {
                        if($model['status_id'] == $statusNew) {
                            return Html::a('Удалить', $url, ['class' => 'btn btn-danger m-1',
                            'data' => [
                                'confirm' => 'Отменить заказ?',
                                'method' => 'post',
                            ],]);
                        }
                    },
                    'view' => function ($url, $model) {
                        return Html::a('Подробнее', $url, ['class' => 'btn btn-primary m-1']);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
