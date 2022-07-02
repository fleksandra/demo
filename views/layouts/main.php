<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap4\Modal;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <header>
        <?php
        NavBar::begin([
            'brandLabel' => 'CopyStar',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);

        $items = [];

        $items[] = ['label' => 'Каталог', 'url' => ['/catalog']];
        $items[] = ['label' => 'О нас', 'url' => ['/site/about']];
        $items[] = ['label' => 'Где нас найти?', 'url' => ['/site/contact']];

        if (Yii::$app->user->isGuest) {
            $items[] = ['label' => 'Регистрация', 'url' => ['/site/registration']];
            $items[] = ['label' => 'Вход', 'url' => ['/site/login']];
        } elseif (Yii::$app->user->identity->isAdmin) {
            $items[] = ['label' => 'Панель администратора', 'url' => ['/admin']];
            $items[] = '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                . Html::submitButton(
                    'Выход (' . Yii::$app->user->identity->login . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>';
        } else {
            $items[] = ['label' => 'Личный кабинет', 'url' => ['/profile']];
            $items[] = '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                . Html::submitButton(
                    'Выход (' . Yii::$app->user->identity->login . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>';
        }
        ?>


        <?
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => $items,
        ]);
        ?>
        <?php
            if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin) : ?>
            <div style="flex-grow: 1">
                <div style="float: right; color: #fff;" class='btn btn-primary' id ='cart-link'>Корзина</div>
            </div>
        <?php
            endif;
        ?>
        <?
        NavBar::end();
        ?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-left">&copy; My Company <?= date('Y') ?></p>
            <p class="float-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php

    if (!(Yii::$app->user->isGuest || Yii::$app->user->identity->isAdmin)) {
        Modal::begin([
            'title' => 'Корзина',
            'options' => ['id' => 'cart', 'class' => 'footer-model'],
            'size' => 'modal-lg',
            'bodyOptions' => ['id' => 'body-cart'],
            'footer' => '
            <div><a href="" class="btn btn-danger disabled m-1" id="clear">Очистить корзину</a></div>
            <div><button class="btn btn-primary m-1" data-dismiss="modal">Продолжить покупки</button></div>
            <div><a href="/profile/create" class="btn btn-success disabled m-1" id="order">Оформить заказ</a></div>', 
        ]);
        Modal::end();
        
        Modal::begin([
            'title' => 'Ошибка',
            'options' => ['id' => 'error'],
        ]); ?>
            <p>Добавлено доступное количество товара.</p>
        <?php Modal::end(); 
    }

    

    $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>