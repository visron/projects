<?php
@include_once ('DBConn.class.php');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Firebase
 *
 * @author ELITEBOOK 840
 */
class Firebase extends DBConn {
   public function retrieveAll(){
        $val = $this->simpleLazySelect("mobo","WHERE FIREBASE_TOKEN NOT = ' ' AND VISIBLE = 1 ");
        return @$val;
    }
     // sending push message to single user by firebase reg id
    public function send($to, $message) {
        $fields = array(
            'to' => $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }

    //public function sendAllUsers($to){}

    // Sending message to a topic by topic name
    public function sendToTopic($to, $message) {
        $fields = array(
            'to' => '/topics/' . $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }

     // sending push message to multiple users by firebase registration ids
    public function sendMultiple($registration_ids, $message) {
        $fields = array(
            'to' => $registration_ids,
            'data' => $message,
        );
 
        return $this->sendPushNotification($fields);
    }

	 // function makes curl request to firebase servers
    private function sendPushNotification($fields) {
         
/*        require_once __DIR__ . '/config.php';
*/ 
        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';
 
        $headers = array(
            'Authorization: key=AAAAevwrO1I:APA91bFIsp7WGADs9Uag_1M9t6YBo537T-rag_P9jVy9RPM4zvDbNquG9noTJxiTEAQvT0S1Lkb2XGeAfVxm4IurouxYJI6QkHX1E0GZJv4y7qWk-3w0K_nzI8Ens205c_WKH_FWFk2_',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

            // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
 
        return $result;
    }
}

