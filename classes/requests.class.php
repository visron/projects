<?php
include_once ("DBConn.class.php");
class Requests extends DBConn{

  function createRequest($name,$number,$from,$to,$userid)
  {
    $request = $this->lazyInsert('requests',
    array("Name","Number","Pickup","Destination","Timestamp","customer_id"),
    array($name,$number,$from,$to,$this->DBdate,$userid));
    return $request;
  }

  function getRequests(){
      $requests = $this->simpleLazySelect("requests", "");
      return @$requests;
  }
  
  function getRequest($id){
      $requests = $this->simpleLazySelect("requests", "Where ID = '$id'");
      return @$requests;
  }
  function editRequest($id,$name,$number,$pickup,$destination,$status){
        return $this->lazyUpdate("requests", array("Name","Number","Pickup","Destination","Status"), 
        array($name,$number,$pickup,$destination,$status), "ID", $id);
  }
  function deleteRequest($id){
        return $this->lazyUpdate("requests", array("is_active"), array('0'), "ID", $id);
  }
}
 ?>
