<?php

include_once('DBConn.class.php');

class Mechanics extends DBConn {
    //`REG_ID`, `US_ID`, `username`, `email`, `number`, `password`, `insertdate`, `status`, `type`,
    // `date`, `authentification`, `location`, `LatLong`, `TOKEN`, `IMAGE`, `registered`, `LONGITUDE`, `ADDRESS`, `SPECIALITY`, `MAKES`
   
    function createMech($regid ,$username, $email, $number,$location,$address,$speciality,$make) {
     return $this->lazyInsert('automech', array('US_ID','username', 'email', 'number', 'password','insertdate','status','location','registered',
        'ADDRESS','SPECIALITY','MAKES'), 
        array($regid,$username, $email, $number,"autocare1234",$this->DBdate,"1",$location,"1",$address,$speciality,$make));
    }
  
   function setMechanicCategory($name,$user_id){
       return $this->lazyInsert("mobo_mechanicscat", array("MC_NAME","MC_INSDATE","USER_ID"), array($name, $this->DBdate, $user_id)); 
   }
   function getAllMechanicCategory() {
       return $this->simpleLazySelect("mobo_mechanicscat", "where MC_STATUS=1");
   }
   function getAllMechanics() {
       return $this->simpleLazySelect('automech', 'where status= 1');
   }
   function deactivateMechanic($mech_id){
       return $this->lazyUpdate('automech', array('status'), array('0'), "US_ID", $mech_id);
   }
   function getAdminById($admin_id) {
        return $this->simpleLazySelect("users", "where USER_ID = $admin_id");
    }
    function Fetch_Incomplete_orders(){
       $val = $this->complexSelect('automech.*,autousers.*','automech,autousers',
            "where automech.us_id = autousers.us_id");
        return @$val;
    }
    
}
