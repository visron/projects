<?php
include_once('DBConn.class.php');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * `SUS_ID`, `SUS_NAME`, `SUS_DESC`, `SUS_STATUS`, `SUS_INSDATE`, `SUS_DURATION`, `P_LINK`, `SUS_COST`
 */

/**
 * Description of Subscription
 *
 * @author ELITEBOOK 840
 */
class Subscription extends DBConn {
    function createSubPackage($susid,$package,$description,$duration,$cost) {
        return $this->lazyInsert("subscriptionpackages",
                array("SUS_NAME","SUS_DESC","SUS_STATUS","SUS_INSDATE","SUS_DURATION","SUS_COST"), 
                array($package,$description,"1", $this->DBdate,$duration,$cost));
    }
    function getAllSubPackage() {
        return $this->simpleLazySelect('subscriptionpackages','where SUS_STATUS=1');
    } 
   function getUserSub() {
      $val = $this->simpleLazySelect('usersuscriptions', 'where SUS_STATUS = 1');
      return @$val[0];
    }
    
    function getPackageById($susid) {
        return $this->simpleLazySelect('subscriptionpackages', "where SUS_ID =$susid ");  
    }
  
}


                               