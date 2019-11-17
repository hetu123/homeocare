<?php
/**
 * Created by PhpStorm.
 * User: Hetal
 * Date: 2018-06-04
 * Time: 02:46 PM
 */

namespace api\modules\v1\controllers;

use api\modules\v1\models\UploadForm;
use common\models\ApnsDevices;
use common\models\Cart;
use common\models\Medicines;
use common\models\Orders;
use common\models\User;
use common\models\Wishlist;
use Yii;
use yii\db\Query;
use yii\web\UploadedFile;
use Swift_Message;
use Twilio\Rest\Client;
use common\models\Addresses;
use common\models\UserAddress;
use common\models\AppoinmentBooking;

class UserController extends BaseApiController
{
    public function actionSignup()
    {
        $fullname = Yii::$app->request->post('fullname');
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');
        $email = Yii::$app->request->post('email');
        $phonenumber = Yii::$app->request->post('phone');
        $gender = Yii::$app->request->post('gender');
        $fbId = Yii::$app->request->post('fbId');
        $anonymous_identifier = Yii::$app->request->post('anonymous_identifier');
        $googleId = Yii::$app->request->post('googleId');
        $auth_key = '';

        if (isset($_SERVER['HTTP_AUTH_TOKEN'])) {
            $auth_key = $_SERVER['HTTP_AUTH_TOKEN'];
            $message = 'sussefully update user deatil';
        }
        /*if (!empty($email)) {
            $useremail = User::findOne(['email' => $email]);
        }
        if (!empty($phonenumber)) {
            $user_phonenumber = User::findOne(['phonenumber' => $phonenumber]);
        }*/
        $user = User::findIdentityByAuthKey($auth_key);

        if (empty($user)) {
            if (!empty($username)) {
                $user = User::findByUsername($username);
                if ($user != null) {
                    $this->_sendErrorResponse(200, "Username is already in use", 603); // email is already exists
                    return;
                }
            }
            if (!empty($email)) {
                $user = User::findByEmail($email);
                if ($user != null) {
                    $this->_sendErrorResponse(200, "email is already in use", 603); // email is already exists
                    return;
                }
            }
            if (!empty($phonenumber)) {
                $user = User::findByPhone($phonenumber);
                if ($user != null) {
                    $this->_sendErrorResponse(200, "phonenumber is already in use", 603); // phone number is already exists
                    return;
                }
            }
            $user = new User();
            if ($fbId !== null) {
                $fbUser = User::findOne(['facebook_id' => $fbId]);
                if (empty($fbUser)) {
                    $user->facebook_id = $fbId;
                    $user->password_hash = Yii::$app->security->generatePasswordHash($fbId);
                } else {
                    $this->actionFacebookLogin($fbId, $anonymous_identifier);
                }
            }
            if ($googleId !== null) {
                $googleUser = User::findOne(['google_id' => $googleId]);
                if (empty($googleUser)) {
                    $user->google_id = $googleId;
                    $user->password_hash = Yii::$app->security->generatePasswordHash($googleId);
                } else {
                    $this->actionGoogleLogin($googleId, $anonymous_identifier);
                }

            } else {
                $user->password_hash = Yii::$app->security->generatePasswordHash($password);
            }
           // $user->sendWelcomeMail($email);
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->status = User::STATUS_ACTIVE;
            $user->created_at = date('Y-m-d H:i:s');
            $message = 'sussefully register';
        }

        $model = new UploadForm();
        if (!empty($fullname)) {
            $user->fullname = $fullname;
        }

        if (!empty($email)) {
            $user->email = $email;
        }
        if (!empty($gender)) {
            $user->gender = $gender;
        }
        if (!empty($phonenumber)) {
            $user->phonenumber = $phonenumber;
        }
        if (!empty($username)) {
            $user->username = $username;
        }
        $user->updated_at = date('Y-m-d H:i:s');
        $model->mainImage = UploadedFile::getInstancesByName('profile_pic');
        if (!empty($model->mainImage)) {
            foreach ($model->mainImage as $file) {
                $filename = $file->baseName . uniqid() . '.' . $file->extension;
                $path = Yii::getAlias('@img') . '/profile/';
                $upload = $file->saveAs($path . $filename);
                if ($upload) {
                    $path = "http://" . $_SERVER['SERVER_NAME'] . '/uploads/profile/';
                    $user->profile_pic = $path . $filename;
                    $user->save(false);
                } else {
                    $error_msg = 'Sorry could not upload your profile picture ';
                    $this->_sendErrorResponse(200, $error_msg, 501);

                }
            }
        }
        $user->save(false);
        if ($user->save(false)) {
            /*$activate_token = Yii::$app->security->generateRandomString() . '_' . time();
            $user->activate_token = $activate_token;
            if ($user->save(false)) {
                if (empty($auth_key)) {
                    $subject = 'activation link';
                    $link = 'http:' . Url::base('') . '/v1/user/active?token=' . $user->activate_token;
                    $email_message = "<a href='$link'>Activation Link</a>";
                    $user->sendEmail1($user->email, $subject, $email_message);
                }
            }*/
            // $cart = Cart::findAll(['anonymous_identifier'=>Yii::$app->request->post('anonymous_identifier')]);
            $carts = Cart::findAll(['anonymous_identifier' => Yii::$app->request->post('anonymous_identifier')]);
            if (!empty($carts)) {
                foreach ($carts as $cart) {
                    $cart->user_id = $user->id;
                    $cart->anonymous_identifier = NULL;
                    $cart->save(false);
                }
            }
            $whishlists = Wishlist::findAll(['anonymous_identifier' => Yii::$app->request->post('anonymous_identifier')]);
            if (!empty($whishlists)) {
                foreach ($whishlists as $whishlist) {
                    $whishlist->user_id = $user->id;
                    $whishlist->anonymous_identifier = NULL;
                    $whishlist->save(false);
                }
            }
            $cnt = (new Query())
                ->select('*')
                ->from('cart')
                ->where(['user_id' => $user->id])
                ->count();
            $response['token'] = $user->getAuthKey();
            $response['total_Cart_count'] = $cnt;
            $userData = User::findByPk($user->id);
            $response['user'] = $this->_userData($userData);

        }
        $this->_sendResponse($response, $message);
    }

    private function actionFacebookLogin($fbId = null, $anonymous_identifier = null)
    {
        $user = User::findOne(['facebook_id' => $fbId]);
        if (empty($user)) {
            $this->_sendErrorResponse(401, "No such user.", 1001);
        }
        if (!empty($anonymous_identifier)) {
            $carts = Cart::findAll(['anonymous_identifier' => $anonymous_identifier]);
            if (!empty($carts)) {
                foreach ($carts as $cart) {
                    $test = Cart::findOne(['medicine_id' => $cart->medicine_id, 'user_id' => $user->id]);
                    if (!empty($test)) {
                        $test->user_id = $user->id;
                        $test->quantity += $cart->quantity;
                        $test->total_price = $test->quantity * $test->store_price;
                        $test->anonymous_identifier = NULL;
                        $test->save(false);
                        $cart->delete();
                    } else {
                        $cart->user_id = $user->id;
                        $cart->anonymous_identifier = NULL;
                        $cart->save(false);
                    }
                }
            }
            $wishlists = Wishlist::findAll(['anonymous_identifier' => Yii::$app->request->post('anonymous_identifier')]);
            if (!empty($wishlists)) {
                foreach ($wishlists as $wishlist) {
                    $test = Wishlist::findOne(['medicine_id' => $wishlist->medicine_id, 'user_id' => $user->id]);
                    if (!empty($test)) {
                        $test->user_id = $user->id;
                        $test->anonymous_identifier = NULL;
                        $test->save(false);
                        $wishlist->delete();
                    } else {
                        $wishlist->user_id = $user->id;
                        $wishlist->anonymous_identifier = NULL;
                        $wishlist->save(false);
                    }
                }
            }
        }

        $cnt = (new Query())
            ->select('*')
            ->from('cart')
            ->where(['user_id' => $user->id])
            ->count();
        $response['token'] = $user->getAuthKey();
        $response['total_Cart_count'] = $cnt;
        $userData = User::findByPk($user->id);
        $response['user'] = $this->_userData($userData);
        $message = 'Successfully logged in';
        $this->_sendResponse($response, $message);

    }

    private function actionGoogleLogin($google_id = null, $anonymous_identifier = null)
    {
        $user = User::findOne(['google_id' => $google_id]);
        if (empty($user)) {
            $this->_sendErrorResponse(401, "No such user.", 1001);
        }
        if (!empty($anonymous_identifier)) {
            $carts = Cart::findAll(['anonymous_identifier' => $anonymous_identifier]);
            if (!empty($carts)) {
                foreach ($carts as $cart) {
                    $test = Cart::findOne(['medicine_id' => $cart->medicine_id, 'user_id' => $user->id]);
                    if (!empty($test)) {
                        $test->user_id = $user->id;
                        $test->quantity += $cart->quantity;
                        $test->total_price = $test->quantity * $test->store_price;
                        $test->anonymous_identifier = NULL;
                        $test->save(false);
                        $cart->delete();
                    } else {
                        $cart->user_id = $user->id;
                        $cart->anonymous_identifier = NULL;
                        $cart->save(false);
                    }
                }
            }
            $wishlists = Wishlist::findAll(['anonymous_identifier' => Yii::$app->request->post('anonymous_identifier')]);
            if (!empty($wishlists)) {
                foreach ($wishlists as $wishlist) {
                    $test = Wishlist::findOne(['medicine_id' => $wishlist->medicine_id, 'user_id' => $user->id]);
                    if (!empty($test)) {
                        $test->user_id = $user->id;
                        $test->anonymous_identifier = NULL;
                        $test->save(false);
                        $wishlist->delete();
                    } else {
                        $wishlist->user_id = $user->id;
                        $wishlist->anonymous_identifier = NULL;
                        $wishlist->save(false);
                    }
                }
            }
        }
        $cnt = (new Query())
            ->select('*')
            ->from('cart')
            ->where(['user_id' => $user->id])
            ->count();
        $response['token'] = $user->getAuthKey();
        $response['total_Cart_count'] = $cnt;
        $userData = User::findByPk($user->id);
        $response['user'] = $this->_userData($userData);
        $message = 'Successfully logged in';
        $this->_sendResponse($response, $message);

    }

    public function actionLogin()
    {
        if (Yii::$app->request->post()) {
            $email = Yii::$app->request->post('email');
            $anonymous_identifier = Yii::$app->request->post('anonymous_identifier');
            $is_mail = $this->checkEmail($email);
            if ($is_mail) {
                $result = User::findOne(['email' => $email]);
            } else {
                $result = User::findOne(['phonenumber' => $email]);
            }
            if (empty($result)) {
                $error_msg = "wrong email or phonenumber";
                $this->_sendErrorResponse(200, $error_msg, 501);
            } else {
                if (!empty($result->google_id) || !empty($result->facebook_id)) {
                    $validate = 1;
                } else {
                    $validate = Yii::$app->security->validatePassword(Yii::$app->request->post('password'), $result->password_hash);
                }
                if ($validate == 1) {
                    if (!empty($anonymous_identifier)) {
                        $carts = Cart::findAll(['anonymous_identifier' => $anonymous_identifier]);
                        if (!empty($carts)) {
                            foreach ($carts as $cart) {
                                $test = Cart::findOne(['medicine_id' => $cart->medicine_id, 'user_id' => $result->id]);
                                if (!empty($test)) {
                                    $test->user_id = $result->id;
                                    $test->quantity += $cart->quantity;
                                    $test->total_price = $test->quantity * $test->store_price;
                                    $test->anonymous_identifier = NULL;
                                    $test->save(false);
                                    $cart->delete();
                                } else {
                                    $cart->user_id = $result->id;
                                    $cart->anonymous_identifier = NULL;
                                    $cart->save(false);
                                }
                            }
                        }
                        $wishlists = Wishlist::findAll(['anonymous_identifier' => Yii::$app->request->post('anonymous_identifier')]);
                        if (!empty($wishlists)) {
                            foreach ($wishlists as $wishlist) {
                                $test = Wishlist::findOne(['medicine_id' => $wishlist->medicine_id, 'user_id' => $result->id]);
                                if (!empty($test)) {
                                    $test->user_id = $result->id;
                                    $test->anonymous_identifier = NULL;
                                    $test->save(false);
                                    $wishlist->delete();
                                } else {
                                    $wishlist->user_id = $result->id;
                                    $wishlist->anonymous_identifier = NULL;
                                    $wishlist->save(false);
                                }
                            }
                        }
                    }
                    $cnt = (new Query())
                        ->select('*')
                        ->from('cart')
                        ->where(['user_id' => $result->id])
                        ->count();
                    $response['token'] = $result->getAuthKey();
                    $response['total_Cart_count'] = $cnt;
                    $userData = User::findByPk($result->id);
                    $response['user'] = $this->_userData($userData);
                    $message = 'Successfully logged in';
                    $this->_sendResponse($response, $message);
                } else {
                    $error_msg = "wrong password";
                    $this->_sendErrorResponse(200, $error_msg, 501);
                }
            }
        } else {
            $error_msg = "parameter not set";
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
    }

    private function checkEmail($email)
    {
        if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)) {
            return true;
        }
        return false;
    }

    public function actionLogout()
    {
        $value = $this->_checkAuth();
        $response['user'] = '';
        $message = "user logged out successfully";
        $this->_sendResponse($response, $message);
    }


    public function actionGetCartDetail($language_id = null, $user_id = null, $anonymous_identifier = null, $offset = 0, $limit = null)
    {
        //   if (isset($_SERVER['HTTP_AUTH_TOKEN'])) {
        //        $user = $this->_checkAuth();
        //        $user_id = $user->id;
        //     }
        //     else{
        //       $user_id = null;
        //     }
        if ($limit == null) {
            $limit = \Yii::$app->params['records_limit'];
        }
        $findQuery = Cart::findByRelation($language_id);
        //  $findQuery->alias('c');
        if ($user_id) {
            $grand_total = $findQuery->sum('c.total_price');
            $wishlist = (new Query())
                ->select('count(id)')
                ->from('wishlist')
                ->where(['user_id' => $user_id])
                ->andWhere('medicine_id = c.medicine_id');
            $findQuery->where(['c.user_id' => $user_id]);
        } else {
            $grand_total = $findQuery->sum('c.total_price');
            $wishlist = (new Query())
                ->select('count(id)')
                ->from(Wishlist::tableName())
                ->where(['anonymous_identifier' => $anonymous_identifier])
                ->andWhere('medicine_id = c.medicine_id');
            $findQuery->where(['c.anonymous_identifier' => $anonymous_identifier]);
        }
        $findQuery->addSelect(['wishlist' => $wishlist]);
        $findQuery->offset($offset);
        $findQuery->limit($limit);
        $findQuery->asArray();
        $arrCart = $findQuery->all();

        if ($arrCart == null) {
            $arrCart = [];
        }
        $p['offset'] = $offset;
        $p['limit'] = $limit;
        $p['record_sent'] = count($arrCart);
        $response = ['GrandTotal' => $grand_total, 'cartDetails' => $arrCart, 'pagination' => $p];
        $message = 'successfully send cart detail';
        $this->_sendResponse($response, $message);

    }

    public function actionGetWishlistDetail($language_id = null, $user_id = null, $anonymous_identifier = null, $offset = 0, $limit = null)
    {
        // if (isset($_SERVER['HTTP_AUTH_TOKEN'])) {
        //     $user = $this->_checkAuth();
        //     $user_id = $user->id;
        //  }
        //  else{
        //    $user_id = null;
        //  }
        if ($limit == null) {
            $limit = \Yii::$app->params['records_limit'];
        }
        $query = Wishlist::findByRelation($language_id);
        // print_r($query->all());die();
        //    $query->alias('w');

        if ($user_id) {
            $query->where(['w.user_id' => $user_id]);

        } else {
            $query->where(['w.anonymous_identifier' => $anonymous_identifier]);
        }

        $query->offset($offset);
        $query->limit($limit);
        $query->asArray();
        $arrWishlist = $query->all();

        if ($arrWishlist == null) {
            $arrWishlist = [];
        }
        $p['offset'] = $offset;
        $p['limit'] = $limit;
        $p['record_sent'] = count($arrWishlist);
        $response = ['wishlistDetails' => $arrWishlist, 'pagination' => $p];
        $message = 'whishlist send successfully';
        $this->_sendResponse($response, $message);

    }

    public function actionUserDetail()
    {
        $user = $this->_checkAuth();
        $user_id = $user->id;

        $Order = (new Query())
            ->select('*')
            ->from(Orders::tableName())
            ->where(['user_id' => $user_id])
            ->count();

        $cart = (new Query())
            ->select('*')
            ->from(Cart::tableName())
            ->where(['user_id' => $user_id])
            ->count();

        $wishlist = (new Query())
            ->select('*')
            ->from(Wishlist::tableName())
            ->where(['user_id' => $user_id])
            ->count();

        $user = User::findOne(['id' => $user_id]);

        if (empty($user)) {
            $response['status'] = 'false';
            $error_msg = "user not found";
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
        $response['status'] = 'true';
        $response['user'] = $this->_userData($user);
        //$response['user'] =$result;
        $response['orderCount'] = $Order;
        $response['cartCount'] = $cart;
        $response['whishlistCount'] = $wishlist;
        $message = 'user Detail send successfully';
        $this->_sendResponse($response, $message);

    }

    public function actionActive($token)
    {
        $user = User::findOne(['activate_token' => $token]);
        if (empty($user)) {
            $response['status'] = 'false';
            $error_msg = "token is not match";
            $this->_sendErrorResponse(200, $error_msg, 501);
        } else {
            $user->status = '1';
            if ($user->save(false)) {
                $response['status'] = 'false';
                $error_msg = "successfully activate account";
                $this->_sendErrorResponse(200, $error_msg, 501);
            }
        }
    }

    public function actionCartCounter($user_id = null)
    {
        // if (isset($_SERVER['HTTP_AUTH_TOKEN'])) {
        //     $user = $this->_checkAuth();
        //     $user_id = $user->id;
        //  }
        //  else{
        //    $user_id = null;
        //  }            
        $anonymous_identifier = Yii::$app->request->get('anonymous_identifier');
        if ($user_id) {
            $cart = (new Query())
                ->select('*')
                ->from(Cart::tableName())
                ->where(['user_id' => $user_id])
                ->count();
        } else {
            $cart = (new Query())
                ->select('*')
                ->from(Cart::tableName())
                ->where(['anonymous_identifier' => $anonymous_identifier])
                ->count();
        }
        if ($cart == 0) {
            $response['status'] = 'false';
            $error_msg = "No item in to cart";
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
        $response['cart_count'] = $cart;
        $message = 'successfully send count of cart item';
        $this->_sendResponse($response, $message);
    }

    public function actionRegisterDevice()
    {
        $device_uuid = Yii::$app->request->post('device_uuid');
        $user_id = Yii::$app->request->post('user_id', null);
        $device_token = Yii::$app->request->post('device_token');
        $platform_type = Yii::$app->request->post('platform_type');
        $app_name = Yii::$app->request->post('app_name', null);
        $app_version = Yii::$app->request->post('app_version', null);
        $device_name = Yii::$app->request->post('device_name');
        $device_model = Yii::$app->request->post('device_model', null);
        $device_os_version = Yii::$app->request->post('device_os_version');
        $push_badge = Yii::$app->request->post('push_badge', null);
        $push_alert = Yii::$app->request->post('push_alert', null);
        $push_sound = Yii::$app->request->post('push_sound', null);
        $environment = Yii::$app->request->post('environment', null);
        $status = Yii::$app->request->post('status', null);
        if ($device_uuid === null) {
            $this->_sendErrorResponse(200, "missing device_uuid parameter!", 101);
        }
        if (empty($platform_type)) {
            $this->_sendErrorResponse(200, "missing platform_type parameter!", 101);
        }
        $checkDevice = ApnsDevices::findOne(['device_uuid' => $device_uuid]);
        if (empty($checkDevice)) {
            $device = new ApnsDevices;
            $device->device_uuid = $device_uuid;
            $device->created_at = date('Y-m-d H:i:s');
        } else {
            $device = $checkDevice;
        }
        $device->user_id = $user_id;
        $device->platform_type = !empty($platform_type) ? $platform_type : ApnsDevices::PLATFORM_OTHER;
        $device->app_name = 'homeocare';
        $device->app_version = $app_version;
        $device->device_token = $device_token;
        $device->device_name = $device_name;
        $device->device_model = $device_model;
        $device->device_os_version = $device_os_version;
        $device->updated_at = date('Y-m-d H:i:s');
        if ($push_sound != null)
            $device->push_sound = $push_sound;
        if ($push_alert != null)
            $device->push_alert = $push_alert;
        if ($push_badge != null)
            $device->push_badge = $push_badge;
        $device->environment = !empty($environment) ? $environment : ApnsDevices::ENVIRONMENT_DEVELOPMENT;
        $device->status = !empty($status) ? $status : "active";
        if ($device->save(false)) {
            $user = User::findIdentity($device->user_id);
            if ($user == null) {
                $response = ['token' => null, 'Device' => $device];
                $message = "Device Registered successfully.";
            } else {
                $token = $user->getAuthKey();
                $response = ['token' => $token, 'Device' => $device];
                $message = "Device Registered successfully.";
            }
            $this->_sendResponse($response, $message);
        }
    }

    public function actionForgotPassword()
    {
        $result = "";
        $message = "";
        $response = [];
        $email = Yii::$app->request->post('email');
        $model = new User();
        $is_mail = $this->checkEmail($email);
        if ($is_mail) {
            $user = User::findOne(['email' => $email]);
            if (empty($user)) {
                $message = "email does not match";
                $result = "false";
            } else {
                $password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
                $user->password_reset_token = $password_reset_token;
                if ($user->save(false)) {
                    //  $user=User::findOne(['email'=>$email]);
                    $subject = 'Reset password link';
                    $link = 'http://' . $_SERVER['HTTP_HOST'] . '/site/reset-password?token=' . $user->password_reset_token;
                    $message = "<a href='$link'>Password reset token</a>";

                    if ($model->sendEmail($email, $subject, $message)) {
                        $result = "true";
                        $message = "mail send successfully";
                    } else {
                        $result = "false";
                        $message = "mail not send";
                    }
                }
            }
        } else {

            $user = User::findByPhone($email);
            $otp = rand(100000, 999999); // a random 6 digit number
            if (empty($user)) {
                $this->_sendErrorResponse(200, "Phone number does not match", 101);
            }
            $user->otp = "$otp";
            $user->otp_expire = time() + 600;
            $user->save(false);
            // To expire otp after 10 minutes
            if (!$user->save()) {

                $errorString = implode(", ", \yii\helpers\ArrayHelper::getColumn($user->errors, 0, false)); // Model's Errors string
                $response = [
                    'success' => false,
                    'msg' => $errorString
                ];
            } else {
                $msg = 'One Time Passowrd(OTP) is ' . $otp;
                $sid = \Yii::$app->params['twilioSid'];  //accessing the above twillio credentials saved in params.php file
                $token = \Yii::$app->params['twiliotoken'];
                $twilioNumber = \Yii::$app->params['twilioNumber'];
                try {
                    $client = new Client($sid, $token);
                    $client->messages->create(
                    // Where to send a text message (your cell phone?)
                        '+919974005096',
                        array(
                            'from' => $twilioNumber,
                            'body' => 'I sent this message in under 10 minutes!'
                        )
                    );

                    /* $client = new \Twilio\Rest\Client($sid, $token);
                     $result=$client->messages->create($email, [
                         'from' => $twilioNumber,
                         'body' => (string) $msg
                     ]);*/


                    $response = [
                        'success' => true,
                        'msg' => 'OTP Sent and valid for 10 minutes.'
                    ];
                } catch (\Exception $e) {
                    $response = [
                        'success' => false,
                        'msg' => $e->getMessage()
                    ];
                }
            }
        }

        $response['mailResponse'] = $result;
        $this->_sendResponse($response, $message);
    }

    public function actionAddAddress(){
        $user = $this->_checkAuth();
        $user_id = $user->id;
        $address_id = Yii::$app->request->post('address_id');
        $address1 = Yii::$app->request->post('address1');
        $address2 = Yii::$app->request->post('address2');
        $pincode = Yii::$app->request->post('pincode');
        $city_id = Yii::$app->request->post('city_id');
        $contact = Yii::$app->request->post('contact');



        if (empty($address1) && empty($address2) && empty($pincode) && empty($city_id) && empty($contact)) {
            $this->_sendErrorResponse(200, "missing parameter!", 101);
        }
        if ($address_id) {
            $objAddress = Addresses::findByPk($address_id);
            $message = 'Successfully Update Address';
        } else {
            $objAddress = new Addresses();
            $message = 'Successfully Add Address';
        }
        $objAddress->address1 = $address1;
        $objAddress->address2 = $address2;
        $objAddress->pincode = $pincode;
        $objAddress->city_id = $city_id;
        $objAddress->contact = $contact;
        $success = $objAddress->save(false);

        if ($success) {
            $address_id = $objAddress->id;
            $objUserAddress = new UserAddress();
            $objUserAddress->user_id = $user_id;
            $objUserAddress->address_id = $address_id;
            $objUserAddress->save(false);
            $objAddress = Addresses::findByRelation();
            $objAddress->where(['a.id' => $address_id]);
            $objAddress->asArray();
            $objAddress = $objAddress->all();
        }
        $this->_sendResponse($objAddress, $message);
    }

    public function actionGetAddressList($offset = 0, $limit = null)
    {
        $user = $this->_checkAuth();
        $user_id = $user->id;
        if ($limit == null) {
            $limit = \Yii::$app->params['records_limit'];
        }
        $addressQuery = Addresses::findByRelation();
        $addressQuery->innerJoin('user_address as us', ['us.user_id' => $user_id]);
        $addressQuery->where(['us.user_id' => $user_id]);
        $addressQuery->offset($offset);
        $addressQuery->limit($limit);
        $addressQuery->asArray();
        $arrAddress = $addressQuery->all();

        if ($arrAddress == null) {
            $arrAddress = [];
        }

        $p['offset'] = $offset;
        $p['limit'] = $limit;
        $p['record_sent'] = count($arrAddress);
        $response = ['addressList' => $arrAddress, 'pagination' => $p];
        $message = "Address List Sent successfully";
        $this->_sendResponse($response, $message);
    }

    public function actionChangePassword()
    {
        $user = $this->_checkAuth();
        $password = Yii::$app->request->post('password');
        $user_id = $user->id;
        $model = User::findByPk($user_id);
        if ($model) {
            $model->setPassword($password);
            if ($model->save(false)) {
                $response['user'] = $this->_userData($model);
                $message = "Password updated successfully";
                $this->_sendResponse($response, $message);
            }
        } else {
            $response['status'] = 'false';
            $error_msg = "Retry later";
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
    }

    public function actionDeleteAddress($address_id = null)
    {
        $user = $this->_checkAuth();
        $user_id = $user->id;
        $address = Addresses::findOne(['id' => $address_id]);
        if ($address === NULL) {
            $error_msg = "Address not metch";
            $this->_sendErrorResponse(200, $error_msg, 501);
        }

        $result = $address->delete();

        if ($result == true) {

            $response['address'] = '';
            $message = 'Address successfully remove';
            $this->_sendResponse($response, $message);

        } else {
            $error_msg = "something went wrong";
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
    }

    public function actionBookAppoinment()
    {
        $user = $this->_checkAuth();
        $user_id = $user->id;
        $age_group_id = Yii::$app->request->post('age_group_id');
        $date = Yii::$app->request->post('date');
        $time_slot_id = Yii::$app->request->post('time_slot_id');
        $symptoms = Yii::$app->request->post('symptoms');

        $objAppoinmentBooking = new AppoinmentBooking();
        $objAppoinmentBooking->age_group_id = $age_group_id;
        $objAppoinmentBooking->date = $date;
        $objAppoinmentBooking->time_slot_id = $time_slot_id;
        $objAppoinmentBooking->symptoms = $symptoms;
        $objAppoinmentBooking->is_approve = 0;
        $objAppoinmentBooking->is_cancel = 0;
        $objAppoinmentBooking->status = 'Disapprove';
        $success = $objAppoinmentBooking->save(false);
        if ($success) {
            $response = ['BookingDetail' => $objAppoinmentBooking];
            $message = "Booking Request send successfully.";
            $this->_sendResponse($response, $message);
        }
        $error_msg = "something went wrong";
        $this->_sendErrorResponse(200, $error_msg, 501);
    }

    public function actionTest(){
        $address1 = Yii::$app->request->post('address1');
        $address2 = Yii::$app->request->post('address2');
        $pincode = Yii::$app->request->post('pincode');
        $city_id = Yii::$app->request->post('city_id');
        $contact = Yii::$app->request->post('contact');
        $user_id = Yii::$app->request->post('user_id');
        $address_id = Yii::$app->request->post('address_id');

        if (empty($address1) && empty($address2) && empty($pincode) && empty($city_id) && empty($contact)) {
            $this->_sendErrorResponse(200, "missing parameter!", 101);
        }

        if($address_id){
            $objAddress = Addresses::findByPk($address_id);
            $message = 'Successfully Update Address';
        } else {
            $objAddress = new Addresses();
            $message = 'Successfully Add Address';
        }
        if($address1){
            $objAddress->address1 =$address1;
        }
        if($address2){
            $objAddress->address2 =$address2;
        }
        if($pincode){
            $objAddress->pincode =$pincode;
        }
        if($city_id){
            $objAddress->city_id =$city_id;
        }
        if($contact){
            $objAddress->contact =$contact;
        }

        $success = $objAddress->save(false);

        if ($success) {
            $address_id = $objAddress->id;
            $objUserAddress = new UserAddress();
            $objUserAddress->user_id = $user_id;
            $objUserAddress->address_id = $address_id;
            $objUserAddress->save(false);
            $objAddress = Addresses::findByRelation();
            $objAddress->where(['a.id' => $address_id]);
            $objAddress->asArray();
            $objAddress = $objAddress->all();
        }
        $this->_sendResponse($objAddress, $message);
    }
}
