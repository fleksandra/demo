<?php

namespace app\models;

use yii\base\Model;
use Yii;

class Cart extends Model
{
    /**
     * Метод добавляет товар в корзину
     */
    public function addToCart($id)
    {
        if ($product = Product::findOne($id)) {
            if ($product->count > 0) {
                $session = Yii::$app->session;
                if (!$session->has('cart')) {
                    $session->set('cart', []);
                } 
                
                $cart = $session->get('cart');

                if (isset($cart['products'][$product->id])) {
                    if($cart['products'][$product->id]['count'] < $product->count) {
                        $cart['products'][$product->id]['count']++;
                        $cart['products'][$product->id]['sum'] += $product->price;
                        $cart['count']++;
                        $cart['sum_price'] += $product->price;
                    } else {
                        return false;
                    }
                } else {
                    $cart['products'][$product->id]['id'] = $product->id;
                    $cart['products'][$product->id]['title'] = $product->title;
                    $cart['products'][$product->id]['price'] = $product->price;
                    $cart['products'][$product->id]['photo'] = $product->photo;
                    $cart['products'][$product->id]['count'] = 1;
                    $cart['products'][$product->id]['sum'] = $product->price;
                    $cart['count']++;
                    $cart['sum_price'] += $cart['products'][$product->id]['sum'];
                }
                $session->set('cart', $cart);

                return true;
            }
        }
    }

    /**
     * Метод удаляет товар из корзины
     */
    public function removeFromCart($id)
    {
        if ($product = Product::findOne($id)) {
            $session = Yii::$app->session;
            if ($session->has('cart')) {
                $cart = $session->get('cart');
                if ($cart['products'][$product->id]) {
                    unset($cart['products'][$product->id]);
                }
                $session->set('cart', $cart);
            }
        }
        if (empty($cart['products'])) {
            $session->set('cart', []);
        }
        return ['status' => true];
    }

    public function addCount($id)
    {
        if ($product = Product::findOne($id)) {
            $session = Yii::$app->session;
            if ($session->has('cart')) {
                $cart = $session->get('cart');

                if ($cart['products'][$product->id] && $cart['products'][$product->id]['count'] < $product->count) {
                    $cart['products'][$product->id]['count']++;
                    $cart['count']++;
                    $cart['sum_price'] += $cart['products'][$product->id]['price'];
                } else {
                    return false;
                }
                $session->set('cart', $cart);
            }
        }
        return true;
    }

    public function deleteCount($id)
    {
        if ($product = Product::findOne($id)) {
            $session = Yii::$app->session;
            if ($session->has('cart')) {
                $cart = $session->get('cart');
                if ($cart['products'][$product->id]) {
                    $cart['products'][$product->id]['count']--;
                    $cart['count']--;
                    $cart['sum_price'] -= $cart['products'][$product->id]['price'];
                    if($cart['products'][$product->id]['count'] == 0) {
                        unset($cart['products'][$product->id]);
                    }
                }
                $session->set('cart', $cart);
            }
        }
        return ['status' => true];
    }

    /**
     * Метод возвращает содержимое корзины
     */

    public function getCart()
    {
        $session = Yii::$app->session;
        if (!$session->has('cart')) {
            $session->set('cart', []);
            return [];
        } else {
            return $session->get('cart');
        }
    }

    public static function getCartInfo()
    {
        $session = Yii::$app->session;
        $cart = $session->get('cart')['products'];
        $res = [];
        foreach($cart as $val) {
            $res['count'] += $val['count'];
            $res['sum'] += $val['count']*$val['price'];
        }
        return $res;
    }
}
