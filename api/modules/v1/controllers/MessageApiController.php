<?php
/**
 * Created by PhpStorm.
 * User: hetal
 * Date: 22/8/18
 * Time: 3:01 PM
 */

namespace api\modules\v1\controllers;


use common\models\Message;
use common\models\Notification;
use common\models\User;
use yii;

class MessageApiController extends BaseApiController
{


    public function actionSendMessage()
    {
        $lastTimestamp = Yii::$app->request->post('lastTimestamp', 0);

        $user = $this->_checkAuth();
        $message = Yii::$app->request->post('message');
        $to_id = Yii::$app->request->post('to_id');

        if ($to_id === null && $message === null) {
            $error_msg = "there was a problem with your from_id and message try again.";
            $this->_sendErrorResponse(200, $error_msg, 501);
        }

        $objMessage = new Message();
        $objMessage->to_id = $to_id;
        $objMessage->from_id = $user->id;
        $objMessage->message = $message;
        $objMessage->created_at = time();
        if ($objMessage->save(false)) {
//"You received a message from " . $user->name .'.';
            $fromUser = User::findByPk($user->id);
            //    print_r($fromUser->profile_pic);die;
            $toUser = User::findByPk($to_id);
            $titleMessage = $user->fullname . ' has sent a message.';
            $type = "MESSAGE";
            $reference_id = $objMessage->id;
            $d['id'] = $objMessage->id;
            $d['message_id'] = $objMessage->id;
            $d['from_id'] = $user->id;
            $d['from_name'] = $fromUser->fullname;
            $d['from_profile_pic'] = $fromUser->profile_pic;
            $d['to_id'] = $to_id;
            $d['to_name'] = $toUser->fullname;
            $d['to_profile_pic'] = $toUser->profile_pic;
            $d['message'] = $message;
            $d['is_read'] = "0";
            $d['type'] = "MESSAGE";
            //  $d['deletedById'] = "";
            $d['created_at'] = $objMessage->created_at;
            $result=$this->notification($titleMessage, $to_id, $type, $reference_id, $d);

        }
        $messages = Message::findById($objMessage->id, $to_id, $user->id, $lastTimestamp);
        $messages->andWhere(['<>','deletedBy',$user->id]);

        $arrMessage = $messages->limit(50)->asArray()->all();
        $response = ["messageList" => $arrMessage];
        $message = "message sent successfully.";
        $this->_sendResponse($response, $message);
    }

    public function actionGetMessage()
    {
        $user = $this->_checkAuth();
        $lastTimestamp = Yii::$app->request->get('lastTimestamp', 0);
        $to_id = Yii::$app->request->get('to_id');
        $arrMsgs = Message::findWithIsRead($to_id, $user->id, $lastTimestamp)->all();
        /* print_r($user->id);die;*/
        foreach ($arrMsgs as $msg) {
            $msg->is_read = 1;
            $msg->save(false);
        }
        $messages = Message::findWithToId($to_id, $user->id);
        $messages->andWhere(['>', 'm.created_at', $lastTimestamp]);
        $messages->andWhere(['<>','deletedBy',$user->id]);
        //  $messages->orWhere(['=','deletedBy',Null]);
        $arrMessage = $messages->limit(50)->asArray()->all();
        if (empty($arrMessage)) {
            $error_msg = "no record found.";
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
        $response = ["messageList" => $arrMessage/*, 'sql' => $sql*/];
        $message = "message get successfully.";
        $this->_sendResponse($response, $message);
    }

    public function actionAllMessages()
    {
        $lastTimestamp = Yii::$app->request->get('lastTimestamp', 0);
        $user = $this->_checkAuth();
        $messages = Message::findWithFromId($user->id);
        $messages->andWhere(['>', 'm.created_at', $lastTimestamp]);
        $arrMessage = $messages->asArray()->all();
        if (empty($arrMessage)) {
            $error_msg = "no record found.";
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
        $response = ["messageList" => $arrMessage];
        $message = "all message get successfully.";
        $this->_sendResponse($response, $message);
    }

    public function actionDeleteParticulerChatMessage()
    {
        $user = $this->_checkAuth();
        $messgae_id = Yii::$app->request->post('message_id');
        $objMessage = Message::findOne(['id' => $messgae_id]);
        if ($objMessage == null) {
            $error_msg = "no record found.";
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
        if ($objMessage->deletedBy == 0 || $objMessage->deletedBy == $user->id) {
            $objMessage->deletedBy = $user->id;
            $objMessage->save();
        } else {
            $objMessage->delete();
            $objNotification = Notification::findOne(['reference_id' => $messgae_id, 'type' => 'MESSAGE']);
            $objNotification->delete();
        }
        $response = ['messageDelete' => $objMessage];
        $message = "Message deleted successfully.";
        $this->_sendResponse($response, $message);
    }

    public function actionDeleteAllChatMessages()
    {
        $user = $this->_checkAuth();
        $to_id = Yii::$app->request->post('to_id');
        $from_id = $user->id;
        $objMessage = Message::find()->where('(from_id=' . $from_id . '&& to_id=' . $to_id . ') || (from_id=' . $to_id . ' && to_id=' . $from_id . ')')->asArray()->all();
        if ($objMessage == null) {
            $error_msg = "no record found.";
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
        foreach ($objMessage as $message) {
            if ($message['deletedBy'] == 0 || $message['deletedBy'] == $user->id) {
                $query = Message::findOne($message['id']);
                $query->deletedBy = $from_id;
                $query->save();
            } else {
                $query = Message::findOne($message['id']);
                if (!empty($query)) {
                    $query->delete();
                    $objNotification = Notification::findOne(['reference_id' => $message['id'], 'type' => 'MESSAGE']);
                    $objNotification->delete();
                }
            }
        }
        $result = Message::find()->where('(from_id=' . $from_id . '&& to_id=' . $to_id . ') || (from_id=' . $to_id . ' && to_id=' . $from_id . ')')->asArray()->all();
        $response = ['messageDelete' => $result];
        $message = "All Message deleted successfully.";
        $this->_sendResponse($response, $message);
    }

    public function actionGetAllLastMessage(){
        $user = $this->_checkAuth();
        $lastTimestamp = Yii::$app->request->get('lastTimestamp', 0);

        $messages = Message::findWithFromIdForLastMessage($user->id);
        $messages->andWhere(['>', 'm.created_at', $lastTimestamp]);
        $arrMessage = $messages->asArray()->all();
        if (empty($arrMessage)) {
            $error_msg = "no record found.";
            $this->_sendErrorResponse(200, $error_msg, 501);
        }
        $response = ["messageList" => $arrMessage];
        $message = "all last message get successfully.";
        $this->_sendResponse($response, $message);
    }
}