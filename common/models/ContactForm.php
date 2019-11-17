<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $tel_number;
    public $body;
   


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name','email', 'tel_number', 'body'], 'safe'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
           // ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'tel_number' => 'Telephone Number',
            'message' => 'Message',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email = null,$number=null,$message = null,$name=null)
    {
       // $mail_ids = explode(',', $email);
        $mail_sent_status = Yii::$app->mailer->compose(
                ['html' => 'contactForm-html', 'text' => 'contactForm-text'],
                ['name' => $name,'email'=>$email,'number'=>$number,'message'=>$message,]
                )
            ->setTo([Yii::$app->params['noReplyEmail'] => Yii::$app->params['emailFrom'] ])
            ->setFrom($email)
            // ->setReplyTo([ $email => $name])
            ->setSubject("Contact enquiry form Homeocare")
            ->setTextBody($this->body)
            ->send();
        
        if($mail_sent_status){

       		Yii::$app->mailer->compose(
                ['html' => 'contact-response-to-user-html', 'text' => 'contact-response-to-user-text'],
                ['data' => $this]
                )
            ->setTo($email)
            ->setFrom([Yii::$app->params['noReplyEmail'] => Yii::$app->params['emailFrom'] ])
            ->setSubject("Thank you to contact Homeocare")
            ->setTextBody($this->body)
            ->send(); 	
	        
        }    
        
        return   $mail_sent_status;          
    }
}
