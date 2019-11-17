<?php

namespace backend\controllers;

use common\models\BlogThumbnailImages;
use Yii;
use common\models\Blogs;
use backend\models\BlogsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\filters\AccessControl;
/**
 * BlogsController implements the CRUD actions for Blogs model.
 */
class BlogsController extends Controller
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
     * Lists all Blogs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blogs model.
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
     * Creates a new Blogs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*public function actionCreate()
    {
        $model = new Blogs();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }*/
    /**
     * Finds the Blogs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blogs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blogs::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionCreate()
    {
        $model = new Blogs();
        if ($model->load(Yii::$app->request->post())) {
            //echo "<pre>"; print_r(Yii::$app->request->post()); exit;
            $time = time();
            $thumbnail_image = UploadedFile::getInstance($model, 'thumbnail_image');

            $path = Yii::$app->params['newsImagePath'] . date('Y') . '/' . date('m');
            //echo $path; exit;
            $pathUrl = Yii::$app->params['newsImageUrl'] . date('Y') . '/' . date('m');
            if (!empty($thumbnail_image)) {
                $model->thumbnail = $pathUrl . '/' . $time . '.' . $thumbnail_image->extension;
                $fileUpload = $path . '/' . $time . '.' . $thumbnail_image->extension;
            } else {
                $model->thumbnail = '';
                $fileUpload = '';
            }
            $slug = str_replace('–', ' ', strtolower($model->title));
            $slug = str_replace('&', 'and', $slug);
            $slug = str_replace(',', 'coma', $slug);
            $model->slug = preg_replace('/\s+/', '-', $slug);
            if ($model->save()) {
                if (!file_exists($path)) {
                    FileHelper::createDirectory($path);
                }
                if (!empty($thumbnail_image)) {
                    $thumbnail_image->saveAs($fileUpload);
                }

                $more_thumbnail_images = UploadedFile::getInstances($model, 'more_thumbnail_images');
                $i = 0;
                foreach ($more_thumbnail_images as $file) {
                    $thumbnail = new BlogThumbnailImages();
                    $thumbnail->image = $pathUrl . '/' . $time . $i . '.' . $file->extension;
                    $fileUpload = $path . '/' . $time . $i . '.' . $file->extension;
                    $thumbnail->blogs_id = $model->id;
                    if ($thumbnail->save()) {
                        $file->saveAs($fileUpload);
                        $i++;
                    }

                }

                Yii::$app->session->setFlash('success', 'blog created successfully');
                return $this->redirect(['index']);
            } else {
                return $this->render('create', ['model' => $model]);
            }
        } else {
            return $this->render('create', ['model' => $model]);
        }

    }

    /**
     * Updates an existing Blogs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //for edit mode
        $old_thumbnail = $model->thumbnail;
        if ($model->load(Yii::$app->request->post())) {
            $time = time();
            $thumbnail_image = UploadedFile::getInstance($model, 'thumbnail_image');

            $path = Yii::$app->params['newsImagePath'] . date('Y') . '/' . date('m');

            $pathUrl = Yii::$app->params['newsImageUrl'] . date('Y') . '/' . date('m');
            if (!empty($thumbnail_image)) {
                //deleting old thumbnail image if exists
                if ($old_thumbnail != '') {
                    $path_parts = explode('/', $old_thumbnail);
                    if (file_exists(Yii::$app->params['newsImagePath'] . $path_parts[3] . '/' . $path_parts[4] . '/' . $path_parts[5])) {
                        unlink(Yii::$app->params['newsImagePath'] . $path_parts[3] . '/' . $path_parts[4] . '/' . $path_parts[5]);
                    }
                }

                $model->thumbnail = $pathUrl . '/' . $time . '.' . $thumbnail_image->extension;
                $fileUpload = $path . '/' . $time . '.' . $thumbnail_image->extension;
            }
            $slug = str_replace('–', ' ', strtolower($model->title));
            $slug = str_replace('&', 'and', $slug);
            $slug = str_replace(',', 'coma', $slug);
            $model->slug = preg_replace('/\s+/', '-', $slug);
            //saving data and uploading image file
            if ($model->save(false)) {
                if (!file_exists($path)) {
                    FileHelper::createDirectory($path);
                }
                if (!empty($thumbnail_image)) {
                    $thumbnail_image->saveAs($fileUpload);
                }
                //more thumbnail image manipulation
                $more_thumbnail_images = UploadedFile::getInstances($model, 'more_thumbnail_images');
                $i = 0;
                foreach ($more_thumbnail_images as $file) {
                    $thumbnail = new BlogThumbnailImages();
                    $thumbnail->image = $pathUrl . '/' . $time . $i . '.' . $file->extension;
                    $fileUpload = $path . '/' . $time . $i . '.' . $file->extension;
                    $thumbnail->blog_id = $model->id;
                    if ($thumbnail->save()) {
                        $file->saveAs($fileUpload);
                        $i++;
                    }
                }
                Yii::$app->session->setFlash('success', 'Blog updated successfully');
                return $this->redirect(['index']);
            }


        } else {
            return $this->render('update', [
                'model' => $model,
                //'dataProvider' => $dataProvider,
            ]);
        }
    }


    /**
     * Deletes an existing Blogs model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $news = $this->findModel($id);
        $path_parts = explode('/', $news->thumbnail);
        $news->delete();

        if (file_exists(Yii::$app->params['newsImagePath'] . $path_parts[3] . '/' . $path_parts[4] . '/' . $path_parts[5])) {
            unlink(Yii::$app->params['newsImagePath'] . $path_parts[3] . '/' . $path_parts[4] . '/' . $path_parts[5]);
        }

        $thumbnails = BlogThumbnailImages::find()->where(['blog_id' => $id])->all();
        foreach ($thumbnails as $thumbnail) {
            $path_parts = explode('/', $thumbnail->image);
            $thumbnail->delete();
            if (file_exists(Yii::$app->params['newsImagePath'] . $path_parts[3] . '/' . $path_parts[4] . '/' . $path_parts[5])) {
                unlink(Yii::$app->params['newsImagePath'] . $path_parts[3] . '/' . $path_parts[4] . '/' . $path_parts[5]);
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Delete the new Thumbnail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return 0 or 1 on fail or success respectively
     */
    public function actionDeleteThumbMore($id)
    {
        $thumbnail = $this->findThumbnailModel($id);
        $path_parts = explode('/', $thumbnail->image);
        $thumbnail->delete();
        if (file_exists(Yii::$app->params['newsImagePath'] . $path_parts[3] . '/' . $path_parts[4] . '/' . $path_parts[5])) {
            unlink(Yii::$app->params['newsImagePath'] . $path_parts[3] . '/' . $path_parts[4] . '/' . $path_parts[5]);
            return '1';
        } else {
            return '0';
        }

    }

    /**
     * Finds the Thumbnail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Thumbnail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findThumbnailModel($id)
    {
        if (($thumbnail = BlogThumbnailImages::findOne($id)) !== null) {
            return $thumbnail;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
