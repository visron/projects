<?php
// Be sure to include the file you've just downloaded
require_once('AfricasTalkingGateway.php');
include_once('smshandler.class.php');
// Specify your authentication credentials
/**
* 
*/
// global $record = new smshandler();

class SMS extends smshandler
{ 
  
  function sendsms($number,$mess)
  {
  
$username   = "Leave";
$apikey     = "bc7f337d29c6c16e32d52960f9fba79137bd936d27181297cc223fa400549206";
// Specify the numbers that you want to send to in a comma-separated list
// Please ensure you include the country code (+254 for Kenya in this case)
$recipients = $number;
// $from = "AUTOCARE NG-KE";
// And of course we want our recipients to know what we really do
$message    = $mess;
// Create a new instance of our awesome gateway class
$gateway    = new AfricasTalkingGateway($username, $apikey);
/*************************************************************************************
  NOTE: If connecting to the sandbox:
  1. Use "sandbox" as the username
  2. Use the apiKey generated from your sandbox application
     https://account.africastalking.com/apps/sandbox/settings/key
  3. Add the "sandbox" flag to the constructor
  $gateway  = new AfricasTalkingGateway($username, $apiKey, "sandbox");
**************************************************************************************/
// Any gateway error will be captured by our custom Exception class below, 
// so wrap the call in a try-catch block
try 
{ 
  // Thats it, hit send and we'll take care of the rest. 
  $results = $gateway->sendMessage($recipients, $message);
            
  foreach($results as $result) {
    // status is either "Success" or "error message"
    $storemessage = $this->recordsms($result->number,$result->status,$message,$result->cost,$result->messageId);
 //   return 1;
    
   // echo " Number: " .$result->number;
    // echo " Status: " .$result->status;
    // echo " MessageId: " .$result->messageId;
    // echo " Cost: "   .$result->cost."\n";
  }
  return 1;
}
catch ( AfricasTalkingGatewayException $e )
{
  return 0;
 // echo "Encountered an error while sending: ".$e->getMessage();
}
}
}
// DONE!!! 
//Sending Messages using sender id/short code
// require_once('AfricasTalkingGateway.php');
// $username   = "MyAppUsername";
// $apikey     = "MyAppAPIKey";
// $recipients = "+254711XXXYYY,+254733YYYZZZ",0701291383;
// $message    = "I'm a lumberjack and its ok, I sleep all night and I work all day";

//
//$from = "shortCode or senderId"; // Specify your AfricasTalking shortCode or sender id
 
// $gateway    = new AfricasTalkingGateway($username, $apikey);
// try 
// {
   
//    $results = $gateway->sendMessage($recipients, $message, $from);
            
//   foreach($results as $result) {
//     echo " Number: " .$result->number;
//     echo " Status: " .$result->status;
//     echo " MessageId: " .$result->messageId;
//     echo " Cost: "   .$result->cost."\n";
//   }
// }
// catch ( AfricasTalkingGatewayException $e )
// {
//   echo "Encountered an error while sending: ".$e->getMessage();
// }
