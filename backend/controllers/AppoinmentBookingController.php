<?php

namespace backend\controllers;

use Yii;
use common\models\AppoinmentBooking;
use backend\models\AppoinmentBookingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * AppoinmentBookingController implements the CRUD actions for AppoinmentBooking model.
 */
class AppoinmentBookingController extends Controller
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
     * Lists all AppoinmentBooking models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AppoinmentBookingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AppoinmentBooking model.
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
     * Creates a new AppoinmentBooking model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AppoinmentBooking();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AppoinmentBooking model.
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
     * Deletes an existing AppoinmentBooking model.
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

    /**
     * Finds the AppoinmentBooking model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AppoinmentBooking the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AppoinmentBooking::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionApprove()
    {
        $id= $_POST['id'];
        $booking = AppoinmentBooking::findOne(['id'=>$id]);
        if($booking->is_approve==1)
        {
            $booking->is_approve = 0;
            $booking->save();
            if($booking->save(false))
            {
                Yii::$app->session->setFlash('success', 'successfully Approve booking Request');
            }
        }
        else
        {
            $booking->is_approve = 1;
            $booking->save();
            if($booking->save(false))
            {
                Yii::$app->session->setFlash('success', 'successfully Disapprove booking Request');
            }
        }
    }
    public function actionCancel()
    {
        $id= $_POST['id'];
        $booking = AppoinmentBooking::findOne(['id'=>$id]);
        if($booking->is_cancel==1)
        {
            $booking->is_cancel = 0;
            $booking->save();
            if($booking->save(false))
            {
                Yii::$app->session->setFlash('success', 'successfully Cancel booking Request');
            }
        }
        else
        {
            $booking->is_cancel = 1;
            $booking->save();
            if($booking->save(false))
            {
                Yii::$app->session->setFlash('success', 'successfully Reaccept booking Request');
            }
        }
    }
}
