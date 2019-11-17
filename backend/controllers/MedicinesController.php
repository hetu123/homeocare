<?php

namespace backend\controllers;

use backend\models\MedicineImageSearch;
use common\models\Category;
use common\models\MedicineComposition;
use common\models\MedicineConditions;
use common\models\MedicineImage;
use common\models\MedicineIngredient;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use common\models\MedicineBrand;
use common\models\MedicineCategory;
use common\models\MedicinesPacking;
use common\models\MedicineType;
use Yii;
use common\models\Medicines;
use backend\models\MedicinesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
/**
 * MedicinesController implements the CRUD actions for Medicines model.
 */
class MedicinesController extends Controller
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
     * Lists all Medicines models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MedicinesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);




        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Medicines model.
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
     * Creates a new Medicines model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Medicines();
        $packing = new MedicinesPacking();
        $image = new MedicineImage();
        if ($model->load(Yii::$app->request->post())) {
            $discount_in_percentage =$model->discount_in_percentage;
            $discount_in_amount = $model->discount_in_amount;
            $original_price =$model->MRP;
            $sale_price=$model->price;
            if($model->price){
                $discount_in_percentage=($original_price - $sale_price)/$original_price*100;
                $discount_in_amount = $original_price - $sale_price;
                $model->discount_in_amount =$discount_in_amount;
                $model->discount_in_percentage = $discount_in_percentage;
            }
            elseif($model->discount_in_percentage){
                $sale_price =$original_price - ($original_price * ($discount_in_percentage / 100));
                $discount_in_amount = $original_price->$sale_price;
                $model->discount_in_amount =$discount_in_amount;
                $model->price = $sale_price;
            }
            else{
                $sale_price = $original_price - $discount_in_amount;
                $discount_in_percentage=($original_price - $sale_price)/$original_price*100;
                $model->price = $sale_price;
                $model->discount_in_percentage = $discount_in_percentage;
            }
           /* $objMedicine = Medicines::findOne(['code' => $model['code'], 'language_id' => $model['language_id']]);
            if(!empty($objMedicine)){
                Yii::$app->session->setFlash('error', 'Code All ready availbale please choose another one.');
                return $this->render('create', [
                    'model' => $model,
                    'image'=>$image,
                ]);
            }*/
            if ($model->save(false)) {
                if ($model->category_id != null) {
                    foreach ($model->category_id as $category_id) {
                        $medicineCategory = new MedicineCategory();
                        $medicineCategory->category_id = $category_id;
                        $medicineCategory->medicine_id = $model->id;
                        $medicineCategory->save(false);
                    }
                }
                if ($model->type_id != null) {
                    foreach ($model->type_id as $type_id) {
                        $medicineType = new MedicineType();
                        $medicineType->type_id = $type_id;
                        $medicineType->medicine_id = $model->id;
                        $medicineType->save(false);
                    }
                }
                if ($model->brand_id != null) {
                    foreach ($model->brand_id as $brand_id) {
                        $medicineBrand = new MedicineBrand();
                        $medicineBrand->brand_id = $brand_id;
                        $medicineBrand->medicine_id = $model->id;
                        $medicineBrand->save(false);
                    }
                }
                if ($model->composition_id != null) {
                    foreach ($model->composition_id as $composition_id) {
                        $medicineComposition = new MedicineComposition();
                        $medicineComposition->composition_id = $composition_id;
                        $medicineComposition->medicine_id = $model->id;
                        $medicineComposition->save(false);
                    }
                }
                if ($model->ingredient_id != null) {
                    foreach ($model->ingredient_id as $ingredient_id) {
                        $medicineIngredient = new MedicineIngredient();
                        $medicineIngredient->ingredient_id = $ingredient_id;
                        $medicineIngredient->medicine_id = $model->id;
                        $medicineIngredient->save(false);
                    }
                }
                if ($model->packing_id != null) {
                    foreach ($model->packing_id as $packing_id) {
                        $medicinePacking = new MedicinesPacking();
                        $medicinePacking->packing_id = $packing_id;
                        $medicinePacking->medicine_id = $model->id;
                        $medicinePacking->save(false);
                    }
                }
                if ($model->condition_id != null) {
                    foreach ($model->condition_id as $condition_id) {
                        $medicineCondition = new MedicineConditions();
                        $medicineCondition->condition_id = $condition_id;
                        $medicineCondition->medicine_id = $model->id;
                        $medicineCondition->save(false);
                    }
                }
               /* $model->left_stock = $model->total_stock;
                $model->use_stock = 0;*/
            }

            Yii::$app->session->setFlash('success', 'Medicine insert successfully');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'image'=>$image,
        ]);
    }

    /**
     * Updates an existing Medicines model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
       // $old_use_stock = $model->use_stock;
        $image = new MedicineImage();
        $medicineCategory = $this->findCategory($id);
        $medicineCategory = MedicineCategory::find()->select('category_id')->where(['medicine_id' => $id])->asArray()->all();
        $selectedCategoryIds = ArrayHelper::getColumn($medicineCategory, 'category_id');

        $medicineType = $this->findType($id);
        $medicineType = MedicineType::find()->select('type_id')->where(['medicine_id' => $id])->asArray()->all();
        $selectedTypeIds = ArrayHelper::getColumn($medicineType, 'type_id');

        $medicineBrand = $this->findBrand($id);
        $medicineBrand = MedicineBrand::find()->select('brand_id')->where(['medicine_id' => $id])->asArray()->all();
        $selectedBrandIds = ArrayHelper::getColumn($medicineBrand, 'brand_id');

        $medicineComposition = $this->findComposition($id);
        $medicineComposition = MedicineComposition::find()->select('composition_id')->where(['medicine_id' => $id])->asArray()->all();
        $selectedCompositionIds = ArrayHelper::getColumn($medicineComposition, 'composition_id');

        $medicineIngredient = $this->findIngredient($id);
        $medicineIngredient = MedicineIngredient::find()->select('ingredient_id')->where(['medicine_id' => $id])->asArray()->all();
        $selectedIngredientIds = ArrayHelper::getColumn($medicineIngredient, 'ingredient_id');

        $medicinePacking = $this->findPacking($id);
        $medicinePacking = MedicinesPacking::find()->select('packing_id')->where(['medicine_id' => $id])->asArray()->all();
        $selectedPackingIds = ArrayHelper::getColumn($medicinePacking, 'packing_id');

        $medicineCondition = $this->findCondition($id);
        $medicineCondition = MedicineConditions::find()->select('condition_id')->where(['medicine_id' => $id])->asArray()->all();
        $selectedConditionIds = ArrayHelper::getColumn($medicineCondition, 'condition_id');

        $searchModel = new MedicineImageSearch();
        $dataProvider = $searchModel->search2($id);
        if ($model->load(Yii::$app->request->post())) {
            $discount_in_percentage =$model->discount_in_percentage;
            $discount_in_amount = $model->discount_in_amount;
            $original_price =$model->MRP;
            $sale_price=$model->price;
            if($model->price && $original_price > 0){
                $discount_in_percentage=($original_price - $sale_price)/$original_price*100;
                $discount_in_amount = $original_price - $sale_price;
                $model->discount_in_amount =$discount_in_amount;
                $model->discount_in_percentage = $discount_in_percentage;
            }
            elseif($model->discount_in_percentage && $original_price > 0){
                $sale_price =$original_price - ($original_price * ($discount_in_percentage / 100));
                $discount_in_amount = $original_price->$sale_price;
                $model->discount_in_amount =$discount_in_amount;
                $model->price = $sale_price;
            }
            elseif($original_price > 0 && $model->discount_in_amount){
                $original_price = '1';
                $sale_price = $original_price - $discount_in_amount;
                $discount_in_percentage=($original_price - $sale_price)/$original_price*100;
                $model->price = $sale_price;
                $model->discount_in_percentage = $discount_in_percentage;
            }

            if ($model->save(false)) {
                MedicineCategory::deleteAll(['medicine_id' => $model->id]);
                if ($model->category_id != null) {
                    foreach ($model->category_id as $category_id) {
                        $medicineCategory = new MedicineCategory();
                        $medicineCategory->category_id = $category_id;
                        $medicineCategory->medicine_id = $model->id;
                        $medicineCategory->save(false);
                    }
                }
                MedicineType::deleteAll(['medicine_id' => $model->id]);
                if ($model->type_id != null) {
                    foreach ($model->type_id as $type_id) {
                        $medicineType = new MedicineType();
                        $medicineType->type_id = $type_id;
                        $medicineType->medicine_id = $model->id;
                        $medicineType->save(false);
                    }
                }
                MedicineBrand::deleteAll(['medicine_id' => $model->id]);
                if ($model->brand_id != null) {
                    foreach ($model->brand_id as $brand_id) {
                        $medicineBrand = new MedicineBrand();
                        $medicineBrand->brand_id = $brand_id;
                        $medicineBrand->medicine_id = $model->id;
                        $medicineBrand->save(false);
                    }
                }
                MedicineComposition::deleteAll(['medicine_id' => $model->id]);
                if ($model->composition_id != null) {
                    foreach ($model->composition_id as $composition_id) {
                        $medicineComposition = new MedicineComposition();
                        $medicineComposition->composition_id = $composition_id;
                        $medicineComposition->medicine_id = $model->id;
                        $medicineComposition->save(false);
                    }
                }

                MedicineIngredient::deleteAll(['medicine_id' => $model->id]);
                if ($model->ingredient_id != null) {
                    foreach ($model->ingredient_id as $ingredient_id) {
                        $medicineIngredient = new MedicineIngredient();
                        $medicineIngredient->ingredient_id = $ingredient_id;
                        $medicineIngredient->medicine_id = $model->id;
                        $medicineIngredient->save(false);
                    }
                }
                MedicinesPacking::deleteAll(['medicine_id' => $model->id]);
                if ($model->packing_id != null) {
                    foreach ($model->packing_id as $packing_id) {
                        $medicinePacking = new MedicinesPacking();
                        $medicinePacking->packing_id = $packing_id;
                        $medicinePacking->medicine_id = $model->id;
                        $medicinePacking->save(false);
                    }
                }
                MedicineConditions::deleteAll(['medicine_id' => $model->id]);
                if ($model->condition_id != null) {
                    foreach ($model->condition_id as $condition_id) {
                        $medicineCondition = new MedicineConditions();
                        $medicineCondition->condition_id = $condition_id;
                        $medicineCondition->medicine_id = $model->id;
                        $medicineCondition->save(false);
                    }
                }
               /* if($old_use_stock === 0){
                    $model->left_stock = $model->total_stock;
                }
                else{
                    $model->left_stock = $model->total_stock-$old_use_stock;

                }*/
                $model->save();
            }

            Yii::$app->session->setFlash('success', 'Medicine update successfully');
           // return $this->redirect(['update', 'id' => $id]);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'image'=>$image,
                'selectedCategoryIds' => $selectedCategoryIds,
                'selectedTypeIds'=>$selectedTypeIds,
                'selectedBrandIds'=>$selectedBrandIds,
                'selectedCompositionIds'=>$selectedCompositionIds,
                'selectedIngredientIds'=>$selectedIngredientIds,
                'selectedPackingIds'=>$selectedPackingIds,
                'selectedConditionIds'=>$selectedConditionIds,
                'dataProvider' => $dataProvider,
            ]);
        }

    }

    private function findCategory($id)
    {
        if (($model = MedicineCategory::findAll(['category_id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    private function findType($id)
    {
        if (($model = MedicineType::findAll(['type_id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    private function findBrand($id)
    {
        if (($model = MedicineBrand::findAll(['brand_id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    private function findComposition($id)
    {
        if (($model = MedicineComposition::findAll(['composition_id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    private function findIngredient($id)
    {
        if (($model = MedicineIngredient::findAll(['ingredient_id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    private function findPacking($id)
    {
        if (($model = MedicinesPacking::findAll(['packing_id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    private function findCondition($id)
    {
        if (($model = MedicineConditions::findAll(['condition_id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Deletes an existing Medicines model.
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
     * Finds the Medicines model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Medicines the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Medicines::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionMedicinesImages($id)
    {
        $searchModel = new MedicineImageSearch();
        $dataProvider = $searchModel->search1($id);
        $model = new MedicineImage();
        if ($model->load(Yii::$app->request->post())) {
            $images = UploadedFile::getInstances($model, 'medicineImages');
            if ($images !== null) {
                $i = 1;
                foreach ($images as $image) {
                    $medicinesImages = new MedicineImage();
                    $medicinesImages->medicine_id = $id;
                    $medicinesImages->getImageUpload($image, $id, $i);
                    $medicinesImages->save(false);
                    $i++;
                }
            }
            Yii::$app->session->setFlash('success', 'Medicine Images upload successfully');
            return $this->redirect(['medicines-images', 'id' => $id]);
        }
        return $this->render('medicines-images', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
    public function actionDeleteImage($id, $medicine_id)
    {
        $images = MedicineImage::deleteAll(['id' => $id]);
        Yii::$app->session->setFlash('success', 'Medicine image delete successfully');
        return $this->redirect(['medicines-images', 'id' => $medicine_id]);
    }
    public function actionAddQuantity(){
        $model = new Medicines() ;
        if ($model->load(Yii::$app->request->post())) {
            $medicine_id =$_POST['Medicines']['id'];
            $new_stock =$_POST['Medicines']['total_stock'];
            $medicine =  $this->findModel($medicine_id);
            $old_total_stock = $medicine->total_stock;
            $old_left_stock = $medicine->left_stock;
            $old_use_stock = $medicine->use_stock;
            $medicine->total_stock +=  $new_stock;
            $medicine->left_stock += $new_stock;
            $medicine->save(false);

            return $this->redirect(['index']);
        }

        return $this->render('add-quantity', [
            'model' => $model,
        ]);
    }
    public function actionMakeCover($id, $medicine_id)
    {
        MedicineImage::updateAll(['is_cover' => 0], ['medicine_id' => $medicine_id]);
        $deal_image = MedicineImage::findOne($id);
        $deal_image->is_cover = 1;
        $deal_image->save(false);
        Yii::$app->session->setFlash('success', 'cover image make successfully');
        return $this->redirect(['medicines-images', 'id' => $medicine_id]);
    }
    public function actionActive()
    {
        $id= $_POST['id'];
        $medicine = Medicines::findOne(['id'=>$id]);
        if($medicine->is_active==1)
        {
            $medicine->is_active = 0;
            $medicine->save();
            if($medicine->save(false))
            {
                Yii::$app->session->setFlash('success', 'successfully Inactive Medicine');
        }
        }
        else
        {
            $medicine->is_active=1;
            $medicine->save();
            if($medicine->save(false))
            {
                Yii::$app->session->setFlash('success', 'successfully active Medicine');
            }
        }
    }
}
