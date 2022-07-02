<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Панель администратора', ['/admin/admin'], ['class' => 'btn btn-outline-success']) ?>
        <?= Html::a('Управление категориями', ['admin-category/index'], ['class' => 'btn btn-outline-success']) ?>
    </p>

    <p>
        <?= Html::a('Добавить товар', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'emptyCell' => ' ',
        'columns' => [

            [
                'attribute' => 'photo',
                'format'=>'raw',
                'filter'=>false,
                'value' => function($data){
                    $url = '/uploads/' .$data->photo;
                    return Html::img($url, ['alt'=>'Фото товара', 'class' => 'photo-shop']); 
                }
            ],
            [
                'attribute' => 'title',
                'format'=>'raw',
                'value' => function($data){
                    return Html::a($data->title, 'view?id=' .$data->id); 
                },
            ],
            [
                'attribute' => 'price',
            ],
            [
                'class' => ActionColumn::className(),
            ],
        ],
    ]); ?>


</div>
