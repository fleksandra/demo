<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap4\Carousel;

$this->title = 'О нас';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <div class="row m-5">
        <div class="col-4">
            <p>Логотип</p>
        </div>
        <div class="col-8">
            <p>Девиз</p>
        </div>
    </div>
    <div>
        <h3 class="text-center p-3">Новинки компании</h3>
        <?
        $items = [];
        foreach ($products as $product) {
            $items[] = ['content' => "<img src='/uploads/{$product['photo']}' class='d-block slider-photo mx-auto img-fluid'>", 'caption' => "<h3 class='text-dark slide-title'>{$product['title']}</h3>"];
        }
        //var_dump($items); die;
        echo Carousel::widget([
            'items' => $items,
            'options' => ['data-interval' => '3000', 'data-ride' => 'carousel'],
        ]);

        ?>
    </div>

</div>