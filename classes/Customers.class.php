<?php

include_once('DBConn.class.php');

class Customers extends DBConn {
    

    //`USER_ID`, `USER_NAMES`, `USER_EMAIL`, `COUNTRY_CODE`, `USER_PHONENUMBER`, `USER_PASSWORD`, `USER_AUTHENTICATION`,
  //`USER_IMAGE`, `USER_AUTH_ID`, `USER_SERVER_AUTHCODE`, `USER_TOKEN_ID`, `USER_INSDATE`, `FIREBASE_TOKEN`, `VISIBLE`
    
    function Emailexist($emails) {
        $val = $this->simpleLazySelect('mobo', "where USER_EMAIL = '$emails' AND VISIBLE = 1");
        return @$val;
    }
    
    function Numberexist($phone) {
        $val = $this->simpleLazySelect('mobo', "where USER_PHONENUMBER = '$phone' AND VISIBLE = 1");
        return @$val;
    }
    
  function getAllCustomers(){
      return $this->simpleLazySelect('mobo', 'where VISIBLE= 1');
  }
  function getMechanicClients(){
      return $this->simpleLazySelect('AutomechCustomer', 'where status = 1');
  }
  function getSpecificMechanicClients($id){
      return $this->simpleLazySelect('AutomechCustomer', "where status = 1 AND US_ID = '$id'");
  }
  function generateOrderNumber() {
      $today = date("Ymd");
      $rand = strtoupper(substr(uniqid(sha1(time())), 0, 4));
      $orderno = $today . $rand;
      return $orderno;
  }
  function createInvoice($c_id,$inv_name, $link_id, $amount)
  {
      $val = $this->lazyInsert('invoices_table', array(
          'INV_GENERATED',
          'LINK_ID',
          'INV_INSDATE',
          'INV_AMOUNT',
          'INV_REF_DATE',
          'US_ID','C_ID'
      ), array(
          $inv_name,
          $link_id,
          $this->DBdate,
          $amount,
          $this->DBdate,$link_id,$c_id
      ));
      return $val;
  }
  function getInvoices($linkid)
  {
      $val = $this->simpleLazySelect('invoices_table,AutomechCustomer', "where AutomechCustomer.C_id = invoices_table.C_ID and invoices_table.US_ID = '$linkid' ");
      return @$val;
  }
  
  function newCustomer($us_id,$name,$number,$email,$plates){
      $value = array($us_id,$name,$number,$plates,$email,$this->DBdate);
      $val = $this->lazyInsert('AutomechCustomer', array("US_ID","custname","custphone","custplates","custemail","insertdate"), $value);
      return $val;
  }
  
 
  function deactivateCustomer($customer_id){
      return $this->lazyUpdate('mobo', array("VISIBLE"), array("0"), "USER_ID", $customer_id);
  }
 
  //`CAR_ID`, `USER_ID`, `CAR_MODEL`, `CAR_ODOMETER`, `CAR_CAPACITY`, `CAR_CARID`, 
  //`CAR_YOM`, `CAR_MANUFACTURE`, `CAR_TYPE`, `CAR_VISIBLE`, `CAR_FUEL`, `CAR_STATUS`
  //GETTING Customers Details
  function getCustomerDetails(){
    return $this->simpleLazySelect("mobo_car", "where CAR_STATUS= 1 ");
  }
    
  function getCustomerById($userid){
    return $this->simpleLazySelect("mobo", "where USER_ID = $userid");
  }
function getCustomerDetailsbyid($userid){
    return $this->simpleLazySelect("automechcustomer", "where US_ID = $userid");
  }
  function getFirebaseToken($us_id) {
       $val = $this->simpleLazySelect('mobo', "where USER_ID = '$us_id'");
        return @$val[0];
  }
  // get customer subcription 
  function getUserSub() {
      $val = $this->simpleLazySelect('usersuscriptions', 'where SUS_STATUS = 1');
      return @$val;
  }
  
  function getSubscriptionById($susid) {
      return $this->simpleLazySelect('subscriptionpackages', "where SUS_ID = $susid");
      
  }
   function getVehicleById($cid){
    return $this->simpleLazySelect("mobo_car", "where CAR_ID = $cid");
    }
  function getcombineddata($user_id){
        $val = $this->complexSelect2("mobo.USER_ID,mobo.USER_NAMES,"
                . "bookservice.BS_DATE,bookservice.BS_TIME,bookservice.BS_NOTES,bookservice.BS_ID,"
                . "bookservice.BS_TYPE",
            "mobo,bookservice,automech",
            "WHERE mobo.USER_ID = bookservice.US_ID AND automech.US_ID = '$user_id'  "
                . "AND automech.REG_ID = bookservice.BS_ASS_MECH AND bookservice.BS_REQUEST = 0");
        return $val;
  }

  function getAcceptedService($user_id){
      $val = $this->complexSelect2("mobo.USER_ID,mobo.USER_NAMES,"
          . "bookservice.BS_DATE,bookservice.BS_TIME,bookservice.BS_NOTES,bookservice.BS_ID,"
          . "bookservice.BS_TYPE",
          "mobo,bookservice,automech",
          "WHERE mobo.USER_ID = bookservice.US_ID AND automech.US_ID = '$user_id'  "
          . "AND automech.REG_ID = bookservice.BS_ASS_MECH AND bookservice.BS_REQUEST = 1");
      return $val;
  }

  function getRejectedService($user_id){
        $val = $this->complexSelect2("mobo.USER_ID,mobo.USER_NAMES,"
            . "bookservice.BS_DATE,bookservice.BS_TIME,bookservice.BS_NOTES,bookservice.BS_ID,"
            . "bookservice.BS_TYPE",
            "mobo,bookservice,automech",
            "WHERE mobo.USER_ID = bookservice.US_ID AND automech.US_ID = '$user_id'  "
            . "AND automech.REG_ID = bookservice.BS_ASS_MECH AND bookservice.BS_REQUEST = 2");
        return $val;
  }
    


}

?>
