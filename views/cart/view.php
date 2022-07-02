<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;

if (empty($cart) && empty($cart['count'])) {
    $product_isset = 0;
} elseif(!empty($cart) && !empty($cart['count'])) {
    $product_isset = 1;
}
?>
<div data-isset="<?= $product_isset ?>" id="cart-view">
    <?php if (!empty($product_isset)) :
?>

    <table class="table">
        <thead class="thead-dark">
            <tr class="text-center">
                <th>Наименование</th>
                <th>Количество, шт.</th>
                <th>Цена, руб.</th>
                <th>Сумма, руб.</th>
                <th></th>
            </tr>
        </thead>
        <?php
        foreach ($cart['products'] as $key => $val) : ?>
            <tbody>
                <tr>
                    <td>
                        <div class='text-center'>
                            <?= Html::a("<img src='/uploads/{$val['photo']}' class='photo-shop mb-2'>
                            <p>{$val['title']}</p>", ['/catalog/view?id=' . $val['id']]) ?>
                        </div>
                    </td>
                    <td class="text-center mx-auto">
                        <?= empty($btn_no) ? Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" />
                            </svg>', [''], ['class' => 'svg svg-delete mr-2', 'data-key' => $key, 'data-id' => $val['id']]) : ''?>
                        <?= $val['count']; ?>
                        <?= empty($btn_no) ? Html::a("<svg data-id = {$val['id']} xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle' viewBox='0 0 16 16'>
                                <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z' />
                                <path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z' />
                            </svg>", [''], ['class' => 'svg svg-add ml-2', 'data-key' => $key, 'data-id' => $val['id']]) : ''?>
                    </td>
                    <td class="text-center"><?= $val['price']; ?></td>
                    <td class="text-center"><?= $val['price'] * $val['count']; ?></td>
                    <td>
                        <?= empty($btn_no) ? Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                        </svg>', [''], ['class' => 'svg delete', 'data-key' => $key, 'data-id' => $val['id']]) : '' ?>
                    </td>
                </tr>
            </tbody>
        <?php endforeach; ?>
        <thead class="thead-light">
                <tr>
                    <th>Итог:</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>
                        <?= $cart['sum_price'] ?> руб.
                    </th>
                </tr>
        </thead>
    </table>
<?php else : ?>
    <p>Ваша корзина пуста</p>
<?php endif; ?>
</div>