<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\Category;
use app\models\UploadFile;
use app\models\AdminProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;


/**
 * AdminProductController implements the CRUD actions for Product model.
 */
class AdminProductController extends AppAdminController
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
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AdminProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $category = Category::getCategory();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'category' => $category,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();
        $model_file = new UploadFile;
        $categories = Category::getCategory();

        $model_file->scenario = UploadFile::SCENARIO_CREATE;

        if ($this->request->isPost) {
            $model_file->imageFile = UploadedFile::getInstance($model_file, 'imageFile');
            if ($model_file->upload()) {
                if ($model->load($this->request->post())) {
                    $model->photo = Yii::$app->user->identity->login .time() .'.' .$model_file->imageFile->extension;
                    if($model->save()) {
                        Yii::$app->session->setFlash('success', 'Товар успешно добавлен.');
                        return $this->redirect(['/admin-product/index']);
                    } else {
                        Yii::$app->session->setFlash('error', 'Ошибка при добавление товара.');
                    }
                } else {
                    var_dump($model);
                    die;
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'model_file' => $model_file,
            'categories' => $categories,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_file = new UploadFile;
        $file = Yii::getAlias('@webroot') . "/uploads/{$model->photo}";
        $update = true;
        $categories = Category::getCategory();

        $model_file->scenario = UploadFile::SCENARIO_UPDATE;

        if ($this->request->isPost) {
            if($model_file->imageFile = UploadedFile::getInstance($model_file, 'imageFile')) {
                if ($model_file->upload()) {
                    if ($model->load($this->request->post())) {
                        $model->photo = Yii::$app->user->identity->login .time() .'.' .$model_file->imageFile->extension;
                        if($model->save()) {
                            if(unlink($file)) {
                                Yii::$app->session->setFlash('success', 'Товар успешно изменен.');
                                return $this->redirect(['/admin-product/index']);
                            }
                        } else {
                            Yii::$app->session->setFlash('error', 'Ошибка при изменении товара.');
                        }
                    }
                }
            } else {
                if ($model->load($this->request->post())) {
                    if($model->save()) {
                        Yii::$app->session->setFlash('success', 'Товар успешно изменен.');
                        return $this->redirect(['/admin-product/index']);
                    } else {
                        Yii::$app->session->setFlash('error', 'Ошибка при изменении товара.');
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'model_file' => $model_file,
            'categories' => $categories,
            'update' => $update,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $file = Yii::getAlias('@webroot') . "/uploads/{$model->photo}";
        if($model->delete()) {
            if(unlink($file)){
                Yii::$app->session->setFlash('success', 'Товар успешно удален.');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при удалении товара.');
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
