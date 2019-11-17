<?php

namespace common\models;

class ContactUs extends \common\models\base\ContactUsBase
{
    public function sendEmail($email)
    {
        $mail_ids = explode(',', $email);
        $mail_sent_status = Yii::$app->mailer->compose(
                ['html' => 'contactForm-html', 'text' => 'contactForm-text'],
                ['data' => $this]
                )
            ->setTo($mail_ids)
            ->setFrom([Yii::$app->params['noReplyEmail'] => Yii::$app->params['emailFrom'] ])
            ->setReplyTo([ $this->email => $this->first_name.' '.$this->last_name ])
            ->setSubject("Contact enquiry form Homeocare")
            //->setTextBody($this->body)
            ->send();
        
        if($mail_sent_status){

       		Yii::$app->mailer->compose(
                ['html' => 'contact-response-to-user-html', 'text' => 'contact-response-to-user-text'],
                ['data' => $this]
                )
            ->setTo($this->email)
            ->setFrom([Yii::$app->params['noReplyEmail'] => Yii::$app->params['emailFrom'] ])
            ->setSubject("Thank you to contact Homeocare")
            //->setTextBody($this->body)
            ->send(); 	
	        
        }    
        
        return   $mail_sent_status;          
    }  
}