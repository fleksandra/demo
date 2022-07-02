<?php

namespace app\controllers;

use app\models\LoginForm;
use Yii;
use app\models\Order;
use app\models\CompositionOrder;
use app\models\OrderSearch;
use app\models\Product;
use app\models\Status;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\bootstrap4\ActiveForm;

/**
 * ProfileController implements the CRUD actions for Order model.
 */
class ProfileController extends AppController
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

    /**
     * Lists all Order models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $status = Status::getStatus();
        $statusNew = Status::getStatusIdNew('Новый');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'status' => $status,
            'statusNew' => $statusNew,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $products = CompositionOrder::getProductOrder($id);
        $status = Status::getStatus();
        $statusNew = Status::getStatusIdNew('Новый');

        return $this->render('view', [
            'model' => $this->findModel($id),
            'products' => $products,
            'status' => $status,
            'statusNew' => $statusNew,
        ]);
    }

    /**
     * Creates a new CompositionOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $login = new LoginForm();
        $model = new CompositionOrder();
        $model_order = new Order();
        $login->login = Yii::$app->user->identity->login;

        if (Yii::$app->request->isAjax && $login->load(Yii::$app->request->post())) {
            $login->error = false;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($login);
        }

        if(Yii::$app->request->isPost) {
            if($login->load(Yii::$app->request->post())) {
                if($login->validate()) {
                    if($model_order->orderCreate()) {
                        if($model->compositionOrderCreate($model_order->id)) {
                            Yii::$app->session->setFlash('success', 'Заказ оформлен.');
                            return $this->redirect(['/profile']);
                        } else {
                            Yii::$app->session->setFlash('error', 'Ошибка при оформлении заказа.');
                        }
                    }
                }
            }
        }
        
        return $this->render('create', [
            'login' => $login,
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if($model = $this->findModel($id)) {
            if($product_order = CompositionOrder::getProductOrder($id)) {
                foreach ($product_order as $val) {
                    $product = Product::findOne($val['product_id']);
                    $product->count += $val['count'];
                    $product->save();
                    if($model->delete()) {
                        Yii::$app->session->setFlash('success', 'Заказ успешно отменен.');
                    }
                }
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
