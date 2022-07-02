<?php

namespace app\controllers;

use Yii;
use app\models\Cart;
use app\models\Product;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AdminController implements the CRUD actions for Order model.
 */
class CartController extends AppController
{

    /**
     * @inheritDoc
     */
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    if(Yii::$app->user->identity->isAdmin || Yii::$app->user->isGuest) {
                        return $this->redirect(['/site/login']);
                    }
                },
                'rules' => [
                    [
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }*/

    public function actionView()
    {
        $cart = (new Cart())->getCart();

        return $this->renderPartial('view', [
            'cart' => $cart,
        ]);
    }

    public function actionAdd()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->post()) { 
            $cart = new Cart();
            $data = Yii::$app->request->post();
            if(!empty($data['id'])) {
                if($cart->addToCart($data['id'])) {
                    return true;
                } else {
                    return false;
                }
            } 
        }
    }

    public function actionDelete()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->post()) { 
            $cart = new Cart();
            $data = Yii::$app->request->post();
            if(!empty($data['id'])) {
                if($cart->removeFromCart($data['id'])) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function actionAddCount()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->post()) { 
            $cart = new Cart();
            $data = Yii::$app->request->post();
            if(!empty($data['id'])) {
                if($cart->addCount($data['id'])) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function actionDeleteCount()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->post()) { 
            $cart = new Cart();
            $data = Yii::$app->request->post();
            if(!empty($data['id'])) {
                if($cart->deleteCount($data['id'])) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function actionClearCart()
    {
        Yii::$app->session->set('cart', []);
    }
}
