<?php
include_once('../classes/DBConn.class.php');
require_once('fcmnotifications.php');
require_once('sendmessage.php');
/**
*  
*/    
$send = new SMS();
$notify = new fcm();

class service_cron extends DBConn
{
	
	function getbookings()
	{
		$datenow = date('Y-m-d');
	//	echo $datenow;
	$val = $this->simpleLazySelect('BookService',
	 "where BS_DATE = '$datenow' AND BS_STATUS = 1");
        return @$val;
       // echo json_encode($val);
	}
	function updatestatus($BS_ID){

        if ($this->lazyUpdate('BookService',
         array('BS_STATUS'), 
         array(2),
          'BS_ID', $BS_ID)) {
            return true;
        } else {
            return false;
        }
    }
	
	function gettoken($us_id)
	{
		
	$val = $this->simpleLazySelect('mobo',
	 "where USER_ID = '$us_id'");
        //echo json_encode($val)."</br>";
        return @$val;
	}}


$serv = new service_cron();
$upcoming = $serv->getbookings();
if($upcoming){
    foreach ($upcoming as $ga) {
        $BS_ID = $ga['BS_ID'];
        $US_ID = $ga['US_ID'];
        $BS_DATE = $ga['BS_DATE']; 
        $BS_TIME = $ga['BS_TIME']; 
       
        //echo $US_ID."</br>";
    $fetchtoken = $serv->gettoken($US_ID);
    $token = ($fetchtoken[0]['FIREBASE_TOKEN']);
    $username = ($fetchtoken[0]['USER_NAMES']);
    $phone = ($fetchtoken[0]['USER_PHONENUMBER']);
    $code = ($fetchtoken[0]['COUNTRY_CODE']);
    $numbercoded = $code.$phone;
 //   echo json_encode($fetchtoken[0]['FIREBASE_TOKEN'])."</br>";
    echo $token."</br>";
    echo $username."</br>";
    echo $numbercoded."</br></br></hr>";
    $message = $notify->sendto($token, "Hello ".$username.", you have a service today at ".$BS_TIME);
    $body = "Hello ".$username.", you have a service scheduled today at ".$BS_TIME. ". Visit us at autocare.ng for amazing offers on car products";
    $servicemessage = $send->sendsms($numbercoded,$body);
    	$updatestatus = $serv->updatestatus($BS_ID);
    }
}
else{
	echo "All Users have been notified of pending services";
}
//$data = json_encode($upcoming);
//echo $data;

?>