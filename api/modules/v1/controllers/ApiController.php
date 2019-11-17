<?php

namespace api\modules\v1\controllers;

use common\models\Brand;
use common\models\Cart;
use common\models\Category;
use common\models\Composition;
use common\models\Conditions;
use common\models\Ingredients;
use common\models\Language;
use common\models\MedicineCategory;
use common\models\MedicineConditions;
use common\models\MedicineImage;
use common\models\Medicines;
use common\models\OrderItem;
use common\models\Orders;
use common\models\PaymentMethods;
use common\models\Type;
use common\models\Cities;
use common\models\Countries;
use common\models\User;
use common\models\States;
use common\models\Addresses;
use common\models\Wishlist;
use common\models\ContactUs;
use common\models\ContactForm;
use common\models\AgeGroup;
use common\models\AboutUs;
use common\models\TimeSlot;
use Yii;
use paragraph1\phpFCM\Client;
use paragraph1\phpFCM\Notification;
use paragraph1\phpFCM\Recipient\Device;
use yii\db\Query;


/**
 * Api controller
 */
class  ApiController extends BaseApiController
{

    public function actionCategories($category_id = null,$offset = 0, $limit = null)
    {
        if ($limit == null) {
            $limit = \Yii::$app->params['records_limit'];
        }
        $categoryQuery = Category::find();
        if (!empty($category_id)) {
            $categoryQuery->andWhere(['pid' => $category_id]);
        } else {
            $categoryQuery->andWhere(['pid' => NULL]);
        }
        if (!empty($language_id)) {
            $categoryQuery->andWhere(['language_id' => $language_id]);
        }
        $categoryQuery->select(['id','pid as parent_id','name','description','image','is_active']);
        $categoryQuery->andWhere(['is_active' => 1]);
        $categoryQuery->orderBy('name ASC');
        $categoryQuery->offset($offset);
        $categoryQuery->limit($limit);
        $arrCategories = $categoryQuery->all();

        if ($arrCategories == null) {
            $arrCategories = [];
        }

        //        $sql = $dealsQuery->createCommand()->rawSql;

        $p['offset'] = $offset;
        $p['limit'] = $limit;
        $p['record_sent'] = count($arrCategories);
        $response = ['categorieList' => $arrCategories, 'pagination' => $p];
//        $response = [$sql,'deals' => $arrDeals, 'pagination' => $p];
        $message = "Categories List Sent successfully";
        $this->_sendResponse($response, $message);
    }

    public function actionConditions($offset = 0, $limit = null)
    {
        if ($limit == null) {
            $limit = \Yii::$app->params['records_limit'];
        }
        $conditionQuery = Conditions::find();
        if (!empty($language_id)) {
            $conditionQuery->andWhere(['language_id' => $language_id]);
        }
        $conditionQuery->select(['id','condition','description','is_active']);
        $conditionQuery->andWhere(['is_active' => 1]);
        $conditionQuery->orderBy(' condition ASC');
        $conditionQuery->offset($offset);
        $conditionQuery->limit($limit);
        $arrConditions = $conditionQuery->all();

        if ($arrConditions == null) {
            $arrConditions = [];
        }

      //        $sql = $dealsQuery->createCommand()->rawSql;

        $p['offset'] = $offset;
        $p['limit'] = $limit;
        $p['record_sent'] = count($arrConditions);
        $response = ['conditionList' => $arrConditions, 'pagination' => $p];
//        $response = [$sql,'deals' => $arrDeals, 'pagination' => $p];
        $message = "Condition List Sent successfully";

        $this->_sendResponse($response, $message);


    }

    public function actionMedicines($language_id = null, $category_ids = null, $condition_ids = null, $offset = 0, $limit = null, $searchTerm = null)
    {
        /* Check if the user is banned or not */
        /** @var User $user */
//        $user = $this->_checkAuth();

        if ($limit == null) {
            $limit = \Yii::$app->params['records_limit'];
        }

        //prepare deal array based on language
        $medicineQuery = Medicines::findWith($language_id);


        /*
                    $isFavoriteCount = (new Query())
                        ->select('count(id)')
                        ->from(UserFavoriteDeal::tableName())
                        ->where('user_id = ' . $user_id)
                        ->andWhere('deal_id = d.id');
                    $dealsQuery->addSelect(['isFavorite' => $isFavoriteCount]);
                }*/

        if ($category_ids != null) {
            $category_ids = explode(',', $category_ids);

            $medicineIds = (new Query())
                ->select('medicine_id')
                ->from(MedicineCategory::tableName())
                ->where(['category_id' => $category_ids]);
            $medicineQuery->andWhere(['m.id' => $medicineIds]);
        }
        if ($condition_ids != null) {
            $condition_ids = explode(',', $condition_ids);
      

            $medicineIds = (new Query())
                ->select('medicine_id')
                ->from(MedicineConditions::tableName())
                ->where(['condition_id' => $condition_ids]);
            $medicineQuery->andWhere(['m.id'=>$medicineIds]);


        }

        if ($searchTerm != null) {
            $searchTerms = explode(" ", $searchTerm);

            $likeTitle = 'm.name LIKE ("%' . $searchTerm . '%") OR m.description LIKE ("%' . $searchTerm . '%") OR m.tags LIKE ("%' . $searchTerm . '%") OR m.gujrati_name LIKE ("%' . $searchTerm . '%") OR m.hindi_name LIKE ("%' . $searchTerm . '%") OR m.gujrati_description LIKE ("%' . $searchTerm . '%") OR m.hindi_description LIKE ("%' . $searchTerm . '%") OR m.	gujrati_tags LIKE ("%' . $searchTerm . '%") OR m.hindi_tags LIKE ("%' . $searchTerm . '%")';
            if (count($searchTerms) > 1) {
                foreach ($searchTerms as $searchTerm) {
                    $likeTitle .= ' OR m.name LIKE ("%' . $searchTerm . '%") OR d.description LIKE ("%' . $searchTerm . '%") OR m.tags LIKE ("%' . $searchTerm . '%")OR m.description LIKE ("%' . $searchTerm . '%") OR m.tags LIKE ("%' . $searchTerm . '%")OR m.gujrati_name LIKE ("%' . $searchTerm . '%") OR m.hindi_name LIKE ("%' . $searchTerm . '%") OR m.gujrati_description LIKE ("%' . $searchTerm . '%") OR m.hindi_description LIKE ("%' . $searchTerm . '%") OR m.	gujrati_tags LIKE ("%' . $searchTerm . '%") OR m.hindi_tags LIKE ("%' . $searchTerm . '%")';
                }
            }

            $medicineQuery = $medicineQuery->andWhere($likeTitle);
        }

        $medicineQuery->offset($offset);
        $medicineQuery->limit($limit);
        $arrMedicines = $medicineQuery->all();

        if ($arrMedicines == null) {
            $arrMedicines = [];
        }
        $p['offset'] = $offset;
        $p['limit'] = $limit;
        $p['record_sent'] = count($arrMedicines);
        $response = ['medicineList' => $arrMedicines, 'pagination' => $p];
//        $response = [$sql,'deals' => $arrDeals, 'pagination' => $p];
        $message = "Medicine List Sent successfully";

        $this->_sendResponse($response, $message);
    }

    public function actionType($offset = 0,$limit = null)
    {
        if ($limit == null) {
            $limit = \Yii::$app->params['records_limit'];
        }
        $typeQuery = Type::find();
        $typeQuery->select(['id','type','is_active']);
        $typeQuery->andWhere(['is_active' => 1]);
        $typeQuery->orderBy('type ASC');
        $typeQuery->offset($offset);
        $typeQuery->limit($limit);
        $typeQuery->limit(10);
        $arrTypes = $typeQuery->all();

        if ($arrTypes == null) {
            $arrTypes = [];
        }

        $p['offset'] = $offset;
        $p['limit'] = $limit;
        $p['record_sent'] = count($arrTypes);
        $response = ['typeList' => $arrTypes, 'pagination' => $p];
        $message = "Type List Sent successfully";
        $this->_sendResponse($response, $message);
    }
    public function actionLanguage($offset = 0,$limit = null)
    {
        if ($limit == null) {
            $limit = \Yii::$app->params['records_limit'];
        }
        $typeQuery = Language::find();
        $typeQuery->select(['id','name','code','is_active']);
        $typeQuery->andWhere(['is_active' => 1]);
        $typeQuery->orderBy('name ASC');
        $typeQuery->offset($offset);
        $typeQuery->limit($limit);
        $typeQuery->limit(10);
        $arrTypes = $typeQuery->all();

        if ($arrTypes == null) {
            $arrTypes = [];
        }

        $p['offset'] = $offset;
        $p['limit'] = $limit;
        $p['record_sent'] = count($arrTypes);
        $response = ['languageList' => $arrTypes, 'pagination' => $p];
        $message = "Language List Sent successfully";
        $this->_sendResponse($response, $message);
    }
    public function actionIngredients($language_id = null, $offset = 0,$limit = null)
    {
        if ($limit == null) {
            $limit = \Yii::$app->params['records_limit'];
        }
        $ingredientQuery = Ingredients::find();
        if (!empty($language_id)) {
            $ingredientQuery->andWhere(['language_id' => $language_id]);
        }
        $ingredientQuery->select(['id','name','is_active']);
        $ingredientQuery->andWhere(['is_active' => 1]);
        $ingredientQuery->orderBy('name ASC');
        $ingredientQuery->offset($offset);
        $ingredientQuery->offset($offset);
        $ingredientQuery->limit($limit);
        $arrIngredients = $ingredientQuery->all();

        if ($arrIngredients == null) {
            $arrIngredients = [];
        }

        $p['offset'] = $offset;
        $p['limit'] = $limit;
        $p['record_sent'] = count($arrIngredients);
        $response = ['ingredientList' => $arrIngredients, 'pagination' => $p];
        $message = "Ingredients List Sent successfully";
        $this->_sendResponse($response, $message);
    }

    public function actionComposition($language_id = null, $offset = 0,$limit = null)
    {
        if ($limit == null) {
            $limit = \Yii::$app->params['records_limit'];
        }
        $compositionQuery = Composition::find();
        if (!empty($language_id)) {
            $compositionQuery->andWhere(['language_id' => $language_id]);
        }
        $compositionQuery->select(['id','weight','weight_type','is_active']);
        $compositionQuery->andWhere(['is_active' => 1]);
        $compositionQuery->orderBy('name ASC');
        $compositionQuery->offset($offset);
        $compositionQuery->limit($limit);
        $arrCompositions = $compositionQuery->all();

        if ($arrCompositions == null) {
            $arrCompositions = [];
        }

        $p['offset'] = $offset;
        $p['limit'] = $limit;
        $p['record_sent'] = count($arrCompositions);
        $response = ['compositionList' => $arrCompositions, 'pagination' => $p];
        $message = "Composition List Sent successfully";
        $this->_sendResponse($response, $message);
    }
    public function actionPaymentMethods($offset = 0, $limit = null){
        if ($limit == null) {
            $limit = \Yii::$app->params['records_limit'];
        }
        $paymentMethodQuery = PaymentMethods::find();
        $paymentMethodQuery->select(['id','name','code','is_active']);
        $paymentMethodQuery->andWhere(['is_active' => 1]);
        $paymentMethodQuery->orderBy('name ASC');
        $paymentMethodQuery->offset($offset);
        $paymentMethodQuery->limit($limit);
        $arrpaymentMethod = $paymentMethodQuery->all();

        if ($arrpaymentMethod == null) {
            $arrpaymentMethod = [];
        }

        $p['record_sent'] = count($arrpaymentMethod);
        $response = ['paymentMethodList' => $arrpaymentMethod];
//        $response = [$sql,'deals' => $arrDeals, 'pagination' => $p];
        $message = "paymentMethod List Sent successfully";
        $this->_sendResponse($response, $message);
    }
    public function actionCountries()
    {
        $countryQuery = Countries::find();
        $countryQuery->select(['id','name']);
        $countryQuery->orderBy('name ASC');
        $arrCountries = $countryQuery->all();

        if ($arrCountries == null) {
            $arrCountries = [];
        }
        $response = ['countryList' => $arrCountries];
        $message = "Countries List Sent successfully";
        $this->_sendResponse($response, $message);
    }
    public function actionStates($country_id = Null)
    {
        $statesQuery = States::find();
        if (!empty($country_id)) {
            $statesQuery->andWhere(['country_id' => $country_id]);
        }
        $statesQuery->select(['id','name','country_id']);
        $statesQuery->orderBy('name ASC');
        $arrStates = $statesQuery->all();

        if ($arrStates == null) {
            $arrStates = [];
        }

        $response = ['stateList' => $arrStates];
        //        $response = [$sql,'deals' => $arrDeals, 'pagination' => $p];
        $message = "State List Sent successfully";
        $this->_sendResponse($response, $message);
    }
    public function actionCities($state_id = Null)
    {
        $citiesQuery = Cities::find();
        if (!empty($state_id)) {
            $citiesQuery->andWhere(['state_id' => $state_id]);
        }
        $citiesQuery->select(['id','name','state_id']);
        $citiesQuery->orderBy('name ASC');
        $arrCities = $citiesQuery->all();

        if ($arrCities == null) {
            $arrCities = [];
        }
        $response = ['cityList' => $arrCities];
        //        $response = [$sql,'deals' => $arrDeals, 'pagination' => $p];
        $message = "State List Sent successfully";
        $this->_sendResponse($response, $message);
    }

    public function actionBrand($language_id = null, $offset = 0,$limit = null)
    {
      if ($limit == null) {
          $limit = \Yii::$app->params['records_limit'];
      }
        $brandQuery = Brand::find();
        if (!empty($language_id)) {
            $brandQuery->andWhere(['language_id' => $language_id]);
        }
        $brandQuery->select(['id','name','code','is_active']);
        $brandQuery->andWhere(['is_active' => 1]);
        $brandQuery->orderBy('name ASC');
        $brandQuery->offset($offset);
        $brandQuery->limit($limit);
        $arrBrands = $brandQuery->all();

        if ($arrBrands == null) {
            $arrBrands = [];
        }

        $p['offset'] = $offset;
        $p['limit'] = $limit;
        $p['record_sent'] = count($arrBrands);
        $response = ['brandList' => $arrBrands, 'pagination' => $p];
        $message = "Brand List Sent successfully";
        $this->_sendResponse($response, $message);

    }

    public function actionAddToCart($user_id = null,$language_id = null){
        //   if (isset($_SERVER['HTTP_AUTH_TOKEN'])) {
        //        $user = $this->_checkAuth();
        //        $user_id = $user->id;
        //     }
        //     else{
        //       $user_id = null;
        //     }
        $medicine_id = Yii::$app->request->get('medicine_id');
        $anonymous_identifier = Yii::$app->request->get('anonymous_identifier');
        $quantity = Yii::$app->request->get('quantity');
        $medicine = Medicines::findOne(['id' => $medicine_id]);

        if ($medicine == NULL) {
            $error_msg = 'Product Id not metch';
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
//            if ($medicine->left_stock < $quantity) {
//                if ($medicine->left_stock <= 0) {
//                    $error_msg = 'stock not available';
//                } else {
//                    $error_msg = 'You can select more than available stock';
//                }
//                $this->_sendErrorResponse(200, $error_msg, 501);
//            }
        if ($user_id) {
            $result = Cart::findOne(['user_id' => $user_id, 'medicine_id' => $medicine_id]);
            $old_quantity = 0;
            if (!empty($result)) {
                $old_quantity = $result->quantity;
                $this->_sendErrorResponse(200, 'Product All ready available into Cart', 501);
            } else {
                $result = new Cart();
                $result->user_id = $user_id;
                $result->medicine_id = $medicine_id;
            }
        } else {
            $result = Cart::findOne(['anonymous_identifier' => $anonymous_identifier, 'medicine_id' => $medicine_id]);
            $old_quantity = 0;
            if (!empty($result)) {
                $old_quantity = $result->quantity;
                $this->_sendErrorResponse(200, 'Product All ready available into Cart', 501);
            } else {
                $result = new Cart();
                $result->anonymous_identifier = $anonymous_identifier;
                $result->medicine_id = $medicine_id;
            }
        }
        $result->quantity = $quantity + $old_quantity;
        $result->store_price = $medicine['price'];
        $result->discount = 0;
        $result->total_price = $result->quantity * $medicine['price'];
        $result->paid_price = $result->total_price;
        if ($result->save(false)) {
            // $success = Medicines::updateStock($medicine_id,$quantity);
            // $medicine->use_stock += $quantity;
            // $medicine->left_stock -= $quantity;
            // $medicine->save(false);
            //  if ($success) {
            $findQuery = Cart::findByRelation($language_id);
            $findQuery->where(['c.id'=>$result->id]);
            //    echo $findQuery->createCommand()->getRawSql();die();
            $cartData = $findQuery->all();
            // print_r($categoryData);die();
            $response['cart'] = $cartData;
            $message = 'successfully add to cart';
            $this->_sendResponse($response, $message);
            // }
        } else {
            $error_msg = 'Something went wrong';
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
    }

    public function actionRemoveFromCart($cart_id=null){
        $cart = Cart::findOne(['id'=> $cart_id]);
        if ($cart === NULL) {
            $error_msg = "product not available ";
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
        $strore_quantity = $cart->quantity;
        $medicine_id = $cart->medicine_id;
        $result = $cart->delete();

        if ($result == true) {
            $medicine = Medicines::findOne(['id' =>$medicine_id]);
            //  $medicine->use_stock -= $strore_quantity;
            // $medicine->left_stock += $strore_quantity;
            if ($medicine->save(false)) {
                $response['cart'] = '';
                $message = 'successfully remove from cart';
                $this->_sendResponse($response, $message);
            } else {
                $error_msg = "something went wrong";
                $this->_sendErrorResponse(200, $error_msg, 501);
            }
        }
    }

    public function actionUpdateQuantity()
    {
        //   if (isset($_SERVER['HTTP_AUTH_TOKEN'])) {
        //        $user = $this->_checkAuth();
        //        $user_id = $user->id;
        //     }
        //     else{
        //       $user_id = null;
        //     }
        $quantity = Yii::$app->request->post('quantity');
        $medicine_id = Yii::$app->request->post('medicine_id');
        $user_id = Yii::$app->request->post('user_id');
        $medicine = Medicines::findOne(['id' => $medicine_id]);
        /* if(empty($medicine)){
             $error_msg = 'Product not match';
             $this->_sendErrorResponse(200, $error_msg, 501);
         }*/
        $anonymous_identifier = Yii::$app->request->post('anonymous_identifier');

        /* if ($medicine->left_stock < $quantity) {
             if ($medicine->left_stock <= 0) {
                 $error_msg = 'stock not available';
             } else {
                 //  $error_msg = 'only '.$medicine->left_stock.' product available';
                 $error_msg = 'You can select more than available stock';
             }

             $this->_sendErrorResponse(200, $error_msg, 501);
         }*/
        if ($user_id) {
            $cart = Cart::findOne(['user_id' => $user_id, 'medicine_id' => $medicine_id]);
        } else {
            $cart = Cart::findOne(['anonymous_identifier' => $anonymous_identifier, 'medicine_id' => $medicine_id]);
        }
        if ($cart == NULL) {
            $error_msg = "product not match";
            $this->_sendErrorResponse(200, $error_msg, 501);
        } else {
            $old_quantity = $cart->quantity;

            $cart->quantity = $quantity;
            //  $use_stock = ($medicine->use_stock - $quantity) + $old_quantity;
            //$left_stock = ($medicine->left_stock + $quantity) - $old_quantity;

            $cart->total_price = $cart->quantity * $cart->store_price;
            $cart->paid_price = $cart->total_price;
            if ($cart->save(false)) {
                //  $medicine->use_stock = $use_stock;
                // $medicine->left_stock = $left_stock;
                if ($medicine->save(false)) {
                    $response['cart'] = $cart;
                    $message = 'successfully Update quantity';
                    $this->_sendResponse($response, $message);
                }
            }
        }

    }


    public function actionGetNotification()
    {
        $user = $this->_checkAuth();
        $user_id = $user->id;
        $offset = Yii::$app->request->get('offset');
        $objNotification = \common\models\Notification::find()->alias('n');
        $objNotification->where(['n.to_id' => $user_id]);
        $objNotification->alias('n');
        $objNotification->select(['n.*', 'u.profile_pic as from_profile_pic', 'u.fullname as from_name', 'ut.profile_pic as to_profile_pic', 'ut.fullname as to_name']);
        $objNotification->orderBy(['created_at' => SORT_DESC]);
        $objNotification->andWhere(['<>', 'n.type', 'MESSAGE']);
        $objNotification->leftJoin('user as ut', 'ut.id=n.to_id &&(n.type="Follow Request")');
        $objNotification->leftJoin('user as u', 'u.id=n.from_id');
        $objNotification->orderBy(['created_at' => SORT_DESC]);
        $objNotification->limit(50);
        $objNotification->offset($offset);
        $objNotification->asArray();
        $result = $objNotification->all();
        if (empty($result)) {
            $error_msg = "no record found";
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
        $response = ['notificationList' => $result];
        $message = 'Notification List successfully sent.';
        $this->_sendResponse($response, $message);
    }

    public function actionTestNotification()
    {
        /*date_default_timezone_set('Asia/Kolkata');
        $timestamp = date("Y-m-d H:i:s");
        echo $timestamp;die;
        */
        $apiKey = Yii::$app->params['apikey'];
        $client = new Client();
        $client->setApiKey($apiKey);
        $client->injectHttpClient(new \GuzzleHttp\Client());

        $note = new Notification('My testing from API', 'testing notification');
        $note->setIcon('notification_icon_resource_name')
            ->setColor('#ffffff')
            ->setBadge(1);

        $message = new \paragraph1\phpFCM\Message();
        $message->addRecipient(new Device('eddl_Qz4uu0:APA91bF6q6v10zKzFwOVvAf1N79or93wLiOX0D5YjKxDyTp5SDhPOMl9CpJAJ1Gx3b_k4zoVWKLZRXiEretr1gr-WprRuAjIa0UhJCBTrZRUVKUFjyiVxDtamlB_6rb3XtQl3COxwktx'));
        $message->setNotification($note)
            ->setData(array('someId' => 111));

        $response = $client->send($message);
        var_dump($response->getStatusCode());
    }

    public function actionMedicinDetail($medicine_id = null, $language_id = null)
    {
        $objMedicine = Medicines::find()->where(['id' => $medicine_id])->one();

        if ($objMedicine == null) {
            $error_msg = "Medicine not found";
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
        $medicineQuery = Medicines::findWithRelations($language_id);
        $medicineQuery->having(['m.id' => $medicine_id]);
        $objMedicine = $medicineQuery->one();

//        $sql = $dealsQuery->createCommand()->rawSql;

        if ($objMedicine != null) {
            $response = ['medicineData' => $objMedicine];
            $message = "medicine detail sent successfully";
            $this->_sendResponse($response, $message);
        }

        $error_msg = "medicine not found error ";
        $this->_sendErrorResponse(200, $error_msg, 501);
    }


    public function actionAddToWishlist(){
        $medicine_id = Yii::$app->request->get('medicine_id');
        if (isset($_SERVER['HTTP_AUTH_TOKEN'])) {
            $user = $this->_checkAuth();
            $user_id = $user->id;
        }
        else{
            $user_id = null;
        }
        if ($user_id) {
            if (Wishlist::findOne(['medicine_id' => $medicine_id])) {
                Wishlist::findOne(['medicine_id' => $medicine_id], ['user_id' => $user_id])->delete();
                $medicine = Medicines::findOne(['id' => $medicine_id]);
                //  $medicine->wishlist_cnt -= '1';
                if ($medicine->save(false)) {
                    $error_msg = "remove from wishlist";
                    $this->_sendErrorResponse(200, $error_msg, 501);
                }
            } else {
                $wishlist = new Wishlist();
                $wishlist->user_id = $user_id;
                $wishlist->medicine_id = $medicine_id;
                if ($wishlist->save(false)) {
                    $medicine = Medicines::findOne(['id' => $medicine_id]);
                    //    $medicine->wishlist_cnt += '1';
                    if ($medicine->save(false)) {
                        $message = "add to wishlist";
                        $response['wishlist'] = $wishlist;
                    }
                } else {
                    $error_msg = "something went wrong";
                    $this->_sendErrorResponse(200, $error_msg, 501);
                }
            }
        } else {
            $anonymous_identifier = Yii::$app->request->get('anonymous_identifier');
            if (Wishlist::findOne(['medicine_id' => $medicine_id, 'anonymous_identifier' => $anonymous_identifier])) {
                Wishlist::findOne(['medicine_id' => $medicine_id, 'anonymous_identifier' => $anonymous_identifier])->delete();
                $medicine = Medicines::findOne(['id' => $medicine_id]);
                // $medicine->wishlist_cnt -= '1';
                if ($medicine->save(false)) {
                    $error_msg = "remove from wishlist";
                    $this->_sendErrorResponse(200, $error_msg, 501);
                }
            } else {
                $wishlist = new Wishlist();
                $wishlist->anonymous_identifier = $anonymous_identifier;
                $wishlist->medicine_id = $medicine_id;
                if ($wishlist->save(false)) {
                    $medicine = Medicines::findOne(['id' => $medicine_id]);
                    //  $medicine->wishlist_cnt += '1';
                    if ($medicine->save(false)) {
                        $message = "add to wishlist";
                        $response['wishlist'] = $wishlist;
                    }
                } else {
                    $error_msg = "something went wrong";
                    $this->_sendErrorResponse(200, $error_msg, 501);
                }
            }
        }
        $this->_sendResponse($response, $message);
    }

    public function actionMakeOrder($language_id = null,$cart_ids=null,$address_id=null,$payment_method_id=null)    {
        if (Yii::$app->request->post()) {
            $user = $this->_checkAuth();
            $str_cart_ids = Yii::$app->request->post('cart_ids');
            $address_id = Yii::$app->request->post('address_id');
            $payment_method_id = Yii::$app->request->post('payment_method_id');

            if($str_cart_ids === null){
                $this->_sendErrorResponse(200, "Add item to Add to cart.", 603); // email is already exists
                return;
            }
            if($address_id === null){
                $this->_sendErrorResponse(200, "select or add shipping address.", 603); // email is already exists
                return;
            }
            if($payment_method_id === null){
                $this->_sendErrorResponse(200, "choose any one paymentmethod.", 603); // email is already exists
                return;
            }
            $arr_cart_ids = explode(",", $str_cart_ids);
            $numItems = count($arr_cart_ids);
            $counter = 0;
            foreach ($arr_cart_ids as $cart_id) {
                $cart = Cart::findByPk($cart_id);
                $medicine = Medicines::findOne($cart['medicine_id']);
                if ($counter == 0) {
                    $order = new Orders();
                    $order->user_id = $user['id'];
                    $order->name = $user['username'];
                    $order->email = $user['email'];
                    $order->is_order = 0;
                    $order->address_id = $address_id;
                    $order->payment_method_id = $payment_method_id;
                    // $order->card_num = Yii::$app->request->post('card_num');
                    // $order->card_cvc = Yii::$app->request->post('card_cvc');
                    // $order->card_exp_month = Yii::$app->request->post('card_exp_month');
                    // $order->card_exp_year = Yii::$app->request->post('card_exp_year');
                    $order->paid_amount = $cart['paid_price'];
                    $order->save(false);
                }

                $order_item = new OrderItem();
                $order_item->user_id = $user['id'];
                $order_item->order_id = $order['id'];
                $order_item->item_name = $medicine['name'];
                $order_item->item_number = $cart['medicine_id'];
                $order_item->item_price = $cart['store_price'];
                $order_item->quantity = $cart['quantity'];
                $order_item->medicine_id = $cart['medicine_id'];
                if ($order_item->save(false)) {
                    Cart::findOne(['medicine_id' => $medicine->id], ['user_id' => $user->id])->delete();
                }

                $order->paid_amount += $cart['paid_price'];
                $order->save(false);
                $counter = $counter + 1;
            }

            $findQuery = Orders::OrderDetail($order['id'],$language_id);
            $findQuery->asArray();

            $arrOrder = $findQuery->all();
            if ($arrOrder == null) {
                $arrOrder = [];
            }
            $response = ['orderDetails' => $arrOrder];
            $message = 'successfully Make Order';
            $this->_sendResponse($response, $message);
        } else {
            $error_msg = 'parameter not set';
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
    }

    public function actionPlaceOrder($order_id=null,$language_id){
        $user = $this->_checkAuth();
        $order = Orders::findByPk($order_id);
        if(empty($order)){
            $error_msg = 'Order Empty';
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
        $order->is_order = 1;
        $order->save(false);

        $findQuery = Orders::OrderDetail($order_id,$language_id);
        $findQuery->asArray();

        $arrOrder = $findQuery->all();
        if ($arrOrder == null) {
            $arrOrder = [];
        }
        $response = ['orderDetails' => $arrOrder];
        $message = 'Order successfully';
        $this->_sendResponse($response, $message);

    }
    public function actionOrderList($language_id = null,$offset = 0, $limit = null){
        $user = $this->_checkAuth();
        $user_id = $user->id;
        if ($limit == null) {
            $limit = \Yii::$app->params['records_limit'];
        }
        $findQuery = Orders::findByRelation($language_id);
        // $findQuery->addSelect(['wishlist' => $wishlist]);
        $findQuery->andWhere(['o.user_id'=>$user_id]);
        $findQuery->offset($offset);
        $findQuery->limit($limit);
        $findQuery->asArray();
        $arrOrder = $findQuery->all();

        if ($arrOrder == null) {
            $arrOrder = [];
        }
        $p['offset'] = $offset;
        $p['limit'] = $limit;
        $p['record_sent'] = count($arrOrder);
        $response = ['orderList' => $arrOrder, 'pagination' => $p];
        $message = 'successfully send Order List';
        $this->_sendResponse($response, $message);
    }
    public function actionOrderDetail($order_id=null,$language_id = null){
        if ($order_id == null) {
            $this->_sendErrorResponse(200, "Order not match.", 603); // email is already exists
            return;
        }
        $findQuery = Orders::OrderDetail($order_id,$language_id);
        $findQuery->asArray();

        $arrOrder = $findQuery->all();
        if ($arrOrder == null) {
            $arrOrder = [];
        }
        $response = ['orderDetails' => $arrOrder];
        $message = 'successfully send Order Detail';
        $this->_sendResponse($response, $message);
    }
    public function actionCancelOrder(){
        $user = $this->_checkAuth();
        $order_id = Yii::$app->request->post('order_id');
        $order = Orders::findByPk($order_id);
        if(empty($order)){
            $error_msg = 'Order Empty';
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
        $order->is_order = 0;
        $order->is_canceled = 1;
        $order->save(false);

        $response['order'] = $order;
        // $response['order_item'] = $order_item;
        $message = 'successfully cancel order';
        $this->_sendResponse($response, $message);

    }
    public function actionContactUs(){
        $contactQuery = ContactUs::find();
        $contactQuery->alias('c');
        $contactQuery->select(['c.id','c.email','c.location','c.contact_number','c.support_and_inquiries','c.complains','c.tracking_and_delivery','c.whats_app']);
        $contactArray=$contactQuery->asArray()->all();
        $response['ContactUs'] = $contactArray;
        $message = "ContactUs detail sent!";
        $this->_sendResponse($response, $message);
    }

    public function actionAboutUs(){
        $aboutQuery = AboutUs::find();
        $aboutQuery->alias('a');
        $aboutQuery->select(['a.id','a.description']);
        $aboutArray=$aboutQuery->asArray()->all();
        $response['AboutUs'] = $aboutArray;
        $message = "AboutUs detail sent!";
        $this->_sendResponse($response, $message);
    }

    public function actionOrderAgain(){
        $order_id = Yii::$app->request->post('order_id');
        $language_id = Yii::$app->request->post('language_id');
        $user = $this->_checkAuth();
        $objOrder = Orders::findByPk($order_id);

        if(empty($objOrder)){
            $error_msg = 'Order Empty';
            $this->_sendErrorResponse(200, $error_msg, 501);
        }

        $secondObjOrder = new Orders();
        $secondObjOrder->attributes = $objOrder->attributes;
        $secondObjOrder->is_order = '0';
        $secondObjOrder->created_at = date('Y-m-d H:i:s');
        $secondObjOrder->updated_at = date('Y-m-d H:i:s');
        $secondObjOrder->save();

        $arrayOrderItem = OrderItem::find()
            ->select(['id','medicine_id','quantity'])
            ->where(['order_id'=>$order_id])->asArray()
            ->all();
        foreach($arrayOrderItem as $orderItem)
        {
            $arrayMedicine = Medicines::find()
                ->select(['*'])
                ->where(['id'=>$orderItem['medicine_id']])->asArray()
                ->one();
            /* if($orderItem['quantity']>$arrayMedicine['left_stock']){
                 $error_msg = 'You can not select more than availbale stock';
                 $this->_sendErrorResponse(200, $error_msg, 501);
             }
             else{
                 Medicines::updateStock($orderItem['medicine_id'],$orderItem['quantity']);
             }*/

            $objOrderItem= OrderItem::findByPk($orderItem['id']);
            $secondSObjOrderItem = new OrderItem();
            $secondSObjOrderItem->attributes = $objOrderItem->attributes;
            $secondSObjOrderItem->created_at = date('Y-m-d H:i:s');
            $secondSObjOrderItem->updated_at = date('Y-m-d H:i:s');
            $secondSObjOrderItem->order_id = $secondObjOrder['id'];
            $result =$secondSObjOrderItem->save();
        }
        $findQuery = Orders::OrderDetail($secondObjOrder->id,$language_id);
        $findQuery->asArray();

        $arrOrder = $findQuery->all();
        if ($arrOrder == null) {
            $arrOrder = [];
        }
        $response = ['orderDetails' => $arrOrder];
        $message = 'successfully Make Order';
        $this->_sendResponse($response, $message);
    }
    public function actionSendEnquiry(){
        $email = Yii::$app->request->post('email');
        $number = Yii::$app->request->post('number');
        $message = Yii::$app->request->post('message');
        $name = Yii::$app->request->post('name');
        $contact =  new ContactForm();
        $response = $contact->sendEmail($email,$number,$message,$name);
        if($response){
            $message = "Enquiry send successfully";
            $this->_sendResponse($response, $message);
        }
        $error_msg = 'Something went wrong';
        $this->_sendErrorResponse(200, $error_msg, 501);
    }

    public function actionAgeGroupList(){
        $ageGroupQuery = AgeGroup::find();
        $ageGroupQuery->select(['id','age_group']);
        $arrAgeGroup = $ageGroupQuery->all();

        if ($arrAgeGroup == null) {
            $arrAgeGroup = [];
        }
        $response = ['AgeGroupList' => $arrAgeGroup];
        $message = "Age Group List Sent successfully";
        $this->_sendResponse($response, $message);

    }

    public function actionTimeSlot(){
        $timeSlotQuery = TimeSlot::find();
        $timeSlotQuery->select(['id','day','morning_hours_from','morning_hours_to','evening_hours_from','evening_hours_to','is_open']);
        $arrTimeSlot= $timeSlotQuery->all();

        if ($arrTimeSlot == null) {
            $arrTimeSlot = [];
        }
        $response = ['TimeSlotList' => $arrTimeSlot];
        $message = "Time Slot List Sent successfully";
        $this->_sendResponse($response, $message);

    }
}
