<?php 

namespace backend\controllers;


use Yii;

use yii\web\Controller;

class ChatController extends Controller{
    
    public function actionIndex()
    {
       // $searchModel = new CategorySearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
          //  'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        ]);
    }
}