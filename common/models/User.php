<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends \common\models\base\UserBase implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
        //  throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    // public static function findByUsername($username)
    // {
    //     return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    // }
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }
    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    public function createAdmin(){
        $auth = \Yii::$app->authManager;
        $authorRole = $auth->getRole('admin');
        $auth->assign($authorRole, $this->id);
        return $this->goBack();
    }
    public static function findIdentityByAuthKey($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
        // throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    public function sendEmail($email, $subject,$message) {

        $mailer = \Yii::$app->mailer;
        return $mailer->compose(['html' => 'layouts/html'], ['content' => $message])
            //  ->setFrom([\Yii::$app->params['adminEmail'] => \Yii::$app->name . ' Confirmation'])
            ->setFrom(["myemail@myemail.com"])
            ->setTo($email)
            ->setSubject($subject)
            ->send();

    }
    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
    /**
     * Finds Model by id
     *
     * @param string $id
     * @return static|null
     */
    public static function findByPk($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }
    /**
     * Finds user by phone
     *
     * @param string $phone
     * @return static|null
     */
    public static function findByPhone($phone)
    {
        return static::findOne(['phonenumber' => $phone]);
    }

    public function sendWelcomeMail($email)
    {

        $mailer = \Yii::$app->mailer;

        if (!$user) {
            return false;
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'WelcomeMail-html', 'text' => 'WelcomeMail-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['noReplyEmail'] => Yii::$app->name])
            ->setTo($email)
            ->setSubject('Welcome to ' . Yii::$app->name)
            ->send();

    }
    public function sendEnquiryMail(){
        $mailer = \Yii::$app->mailer;
        $result =$mailer->compose(['html' => 'WelcomeMail-html', 'text' => 'WelcomeMail-text'], ['user' => $this])
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' Confirmation'])
            ->setTo($email)
            ->setSubject("Homeocare Enquiry Mail")
            ->send();
        print_r($result);die();
    }
}

