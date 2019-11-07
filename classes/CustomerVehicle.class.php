<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once('DBConn.class.php');

class CustomerVehicle extends DBConn {

  
    /**
     * 
     * `CAR_ID`, `USER_ID`, `CAR_MODEL`, `CAR_ODOMETER`, `CAR_CAPACITY`, `CAR_CARID`, `CAR_YOM`,
     * `CAR_MANUFACTURE`, `CAR_TYPE`, `CAR_VISIBLE`, `CAR_FUEL`, `CAR_STATUS`
     */
  function getAllVehicle(){
      return $this->simpleLazySelect('mobo_car', 'where CAR_STATUS= 1');
  }
   function getVehicleById($cid){
    return $this->simpleLazySelect("mobo_car", "where CAR_ID = $cid");
  }
  
  /**
   * 
   * @param type $customer_id
   * @return type
   */
  function deactivateVehicle($car_id){
      return $this->lazyUpdate('mobo_car', array("CAR_STATUS"), array("0"), "CAR_ID", $car_id);
  }
  
}

?>
