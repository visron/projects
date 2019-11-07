<?php

include_once('DBConn.class.php');

class Services extends DBConn{
// function setNewServiceProvider(US_ID, SP_NAME, SP_LICENSE, SP_COUNTY, SP_TOWN, SP_PHYSICAL_ADDRESS, SP_LONG, SP_LAT, SP_AVATAR){ $sql = this->lazyInsert("service_providers", array(US_ID, SP_NAME, SP_LICENSE, SP_COUNTY, SP_TOWN, SP_PHYSICAL_ADDRESS, SP_LONG, SP_LAT, SP_AVATAR), array($US_ID, $SP_NAME, $SP_LICENSE, $SP_COUNTY, $SP_TOWN, $SP_PHYSICAL_ADDRESS, $SP_LONG, $SP_LAT, $SP_AVATAR), "");
// if($sql){
// return true;
// } else{
// return false;
// }
    function getAllServices(){
        $table = "services";
        $condition = "WHERE S_STATUS = 1";
        $val = $this->simpleLazySelect($table, $condition);
        return @$val;
    }
    function getServiceTypes(){
        $table = "service_types";
        $condition = "WHERE ST_STATUS = 1";
        $val = $this->simpleLazySelect($table, $condition);
        return @$val;
    }
    function openService($date,$notes,$mech,$cust,$time,$type){
        $table = "automech_service";
        $column = array("AS_US_ID","AS_TYPE","AS_DATE","AS_TIME","AS_NOTES","AS_TIMESTAMP","AS_MECH_ID","AS_C_ID");
        $value = array($mech,$type,$date,$time,$notes,$this->DBdate,$mech,$cust);
        
        
        $val  = $this->lazyInsert($table, $column, $value);
        return $val;
    }
    function getServiceDetails($serviceid){
          $table = "repairs";
        $condition = "WHERE R_S_ID = '$serviceid' AND R_STATUS = 1";
        $val = $this->simpleLazySelect($table, $condition);
        return @$val;
    }
    
}
?>