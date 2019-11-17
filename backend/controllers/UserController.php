<?php

namespace backend\controllers;

use common\models\Cart;
use Yii;
use common\models\User;
use backend\models\UserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
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
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionActive()
    {
        $id = $_POST['id'];
        $user = User::findOne(['id' => $id]);
        if ($user->status == 10) {
            $user->status = 9;
            $user->save();
            if ($user->save(false)) {
                echo "successfully inactive user";
            }
        } else {
            $user->status = 10;
            $user->save();
            if ($user->save(false)) {
                echo "successfully active user";
            }
        }
    }

    public function actionGetCartDetail()
    {
        if (Yii::$app->request->get()) {
            $user_id = Yii::$app->request->get('user_id');
            $anonymous_identifier = Yii::$app->request->get('anonymous_identifier');
            $offset = Yii::$app->request->get('offset');
            $cart = Cart::find();
            $cart->alias('c');
            $cart->select(['c.*']);
            $cart->with('medicine');
            if ($user_id) {
                /*$wishlist = (new Query())
                    ->select('count(id)')
                    ->from('wishlist')
                    ->where(['user_id' => $user_id])
                    ->andWhere('product_id = c.product_id');*/
                $user = Cart::findOne(['user_id' => $user_id]);
                if (empty($user)) {
                    $error_msg = "cart is empty";
                    $this->_sendErrorResponse(200, $error_msg, 501);
                }
                $cart->where(['c.user_id' => $user_id]);
               // $cart->addSelect(['wishlist' => $wishlist]);
            } else {
               /* $wishlist = (new Query())
                    ->select('count(id)')
                    ->from(Wishlist::tableName())
                    ->where(['anonymous_identifier' => $anonymous_identifier])
                    ->andWhere('product_id = c.product_id');*/
                $cart->where(['c.anonymous_identifier' => $anonymous_identifier]);
               // $cart->addSelect(['wishlist' => $wishlist]);
            }
            $cart->asArray();
            $cart->offset($offset);
            $cart->limit(10);
            $result = $cart->all();
            $user = User::findOne(['id' => $user_id]);
            $response['status'] = $user->status;
            if ($result == NULL) {
                $error_msg = "cart is empty";
                $this->_sendErrorResponse(200, $error_msg, 501);
            }
            $response['cart'] = $result;
            $message = 'successfully send cart detail';
            $this->_sendResponse($response, $message);
        } else {
            $error_msg = "parameter not set";
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
    }

    public function actionGetWhishlist()
    {
        //  $value = $this->_checkAuth();
        $offset = Yii::$app->request->get('offset');
        if (Yii::$app->request->get('user_id')) {
            $query = Wishlist::find()->alias('w');
            $query->where(['user_id' => Yii::$app->request->get('user_id')]);

            $query->with('product');

            $query->asArray();
            $query->offset($offset);
            $query->limit(10);
            $result = $query->all();

            if ($result == NULL) {
                $error_msg = 'Empty whishlist';
                $this->_sendErrorResponse(200, $error_msg, 501);
            } else {
                $response['whishlist'] = $result;
                // $response['ProductImage']=$modelImage;
                $message = 'whishlist send successfully';
                $this->_sendResponse($response, $message);
            }
        } else {
            $query = Wishlist::find()->alias('w');
            $query->where(['anonymous_identifier' => Yii::$app->request->get('anonymous_identifier')]);

            $query->with('product');

            $query->asArray();
            $query->offset($offset);
            $query->limit(10);
            $result = $query->all();

            if ($result == NULL) {
                $error_msg = 'Empty whishlist';
                $this->_sendErrorResponse(200, $error_msg, 501);
            } else {
                $response['whishlist'] = $result;
                // $response['ProductImage']=$modelImage;
                $message = 'whishlist send successfully';
                $this->_sendResponse($response, $message);
            }
        }
    }
}
