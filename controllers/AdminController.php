<?php

namespace app\controllers;

use Yii;
use app\models\Order;
use app\models\AdminSearch;
use app\models\Category;
use app\models\Status;
use app\models\User;
use app\models\CompositionOrder;
use app\models\Product;
use yii\web\NotFoundHttpException;

/**
 * AdminController implements the CRUD actions for Order model.
 */
class AdminController extends AppAdminController
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
                    if(!Yii::$app->user->identity->isAdmin || Yii::$app->user->isGuest) {
                        return $this->$this->goHome();
                    }
                },
                'rules' => [
                    [
                        'allow'   => true,
                        'roles'   => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->isAdmin;
                        }
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
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProviderOld = $searchModel->searchOld($this->request->queryParams);
        $count_category = Category::getCountCategory();
        $status = Status::getStatus();
        $statusOld = Status::getStatusOld();
        $statusNew = Status::getStatusIdNew('Новый');
        $user = User::getUser();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderOld' => $dataProviderOld,
            'count_category' => $count_category,
            'status' => $status,
            'statusOld' => $statusOld,
            'statusNew' => $statusNew,
            'user' => $user,
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

    public function actionConfirm($id)
    {
        if($model = $this->findModel($id)) {
            $model->status_id = Status::getStatusIdNew('Подтвержденный');
            if($model->save()) {
                Yii::$app->session->setFlash('success', 'Статус заказа изменен.');
                return $this->redirect(['/admin']);
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при изменении статус заказа.');
            }
        }
    }

    public function actionRefusal($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            Order::SCENARIO_REFUSAL;
            $model->status_id = Status::getStatusIdNew('Отмененный');
            if($model->save()) {
                if($product_order = CompositionOrder::getProductOrder($id)) {
                    foreach ($product_order as $val) {
                        $product = Product::findOne($val['product_id']);
                        $product->count += $val['count'];
                            $product->save();
                    }
                }
                Yii::$app->session->setFlash('success', 'Статус заказа изменен.');
                return $this->redirect(['/admin']);
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при изменении статус заказа.');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
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
